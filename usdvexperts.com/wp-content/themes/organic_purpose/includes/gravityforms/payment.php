<?php

add_action('init', 'call_zotapay');
function call_zotapay() {
    if ( !is_user_logged_in() ) return;
    new ZotaPay( $_POST );
}

class ZotaPay
{
    /**
     * @var string
     */
    var $env = 'test'; //test|prod

    /**
     * @var string
     */
    var $test_request_url = 'https://sandbox.zotapay.com/paynet/api/v2/sale-form/';

    /**
     * @var string
     */
    var $prod_request_url = 'https://gate.zotapay.com/paynet/api/v2/sale-form/';

    /**
     * @var string
     */
    var $control_key = 'EBD90BB1-F8F8-4909-A214-985C3C1D547A';

    /**
     * @var int
     */
    var $endpoint_id = 908;

    /**
     * @var array|bool
     */
    var $map;



    public function __construct( $request )
    {
        add_action( 'gform_after_submission_4' , array( $this, 'process'), 10, 2 );
        add_action( 'gform_after_submission_13', array( $this, 'process'), 10, 2 );

        if ( isset( $request['processor-tx-id'] ) ) {
            $this->callback( $request );
        }
    }

    /**
     * @param $entry
     * @param $form
     */
    public function process( $entry, $form )
    {

        // Application for 1 Year
        if ( $form['id'] == 4 ) {
            $this->setMap( 'map.products.1.json' );
            update_user_meta( get_current_user_id(), 'product', 'Application for 1 Year' );
        }

        // Application for 2 Year
        if ( $form['id'] == 13 ) {
            $this->setMap( 'map.products.2.json' );
            update_user_meta( get_current_user_id(), 'product', 'Application for 2 Year' );
        }

        $user = new WP_User( get_current_user_id() );

        $params = array(
            'endpoint_id' => $this->endpoint_id,
            'client_orderid' => $entry['id'],
            'amount' => $entry[$this->map['fields']['total']],
            'email' => $user->user_email,
            'merchant_control' => $this->control_key,
        );

        $control = $this->control( $params );

        $country_code = $this->countrycodes( get_user_meta( $user->ID, 'country_of_residence', true ) );

        $request = array(
            'client_orderid'    => $params['client_orderid'],
            'order_desc'        => $entry[$this->map['fields']['product']],
            'address1'          => get_user_meta( $user->ID, 'route', true ),
            'city'              => get_user_meta( $user->ID, 'locality', true ),
            'zip_code'          => get_user_meta( $user->ID, 'postal_code', true ),
            'country'           => $country_code,
            'email'             => $params['email'],
            'amount'            => $params['amount'],
            'currency'          => 'USD',
            'ipaddress'         => $_SERVER['REMOTE_ADDR'],
            'redirect_url'      => get_the_permalink( 1622 ),

            'control' => $control,
        );

        $request_url = $this->env == 'prod' ? $this->prod_request_url : $this->test_request_url;
        $response = $this->sendRequest( $request_url.$this->endpoint_id, $request);

        if ( isset( $response['redirect-url'] ) ) {
            wp_redirect( $response['redirect-url'] );
            exit();
        }
    }

    /**
     * ZotaPay Callback
     * @param $request
     * @return void
     */
    public function callback( $request )
    {
        // Update lead

        $lead = GFFormsModel::get_lead( $request['merchant_order'] );

        switch ( $request['status'] )
        {
            case( 'approved' ):

                $lead['payment_status']   = 'success';
                $lead['transaction_id']   = $request['orderid'];
                $lead['transaction_type'] = $request['card-type'];
                $lead['payment_date']     = date('Y-m-d H:i:s');

                $form = GFForms::get_form( $lead['form_id'] );

                $lead[$this->map['fields']['payment_status']] = 'success';

                GFAPI::send_notifications( $form, $lead );

                $user_payment_status = true;
                break;

            default:
                $lead['payment_status'] = 'failed';
                $user_payment_status = false;
        }

        GFAPI::update_entry( $lead );
        update_user_meta( get_current_user_id(), 'payment', $user_payment_status );

        // Redirections to succes/failed page

        if ( $request['status'] == 'approved' ) {
            wp_redirect( get_the_permalink( 992 ) ); exit();
        } else {
            wp_redirect( get_the_permalink( 994 ) ); exit();
        }

    }

    /**
     * @param array $values
     * @return string
     */
    public function control( array $values )
    {
        $string = '';

        foreach( $values as $key=>$value )
        {
            if ( $key == 'amount' ) {
                $string.= $value * 100;
            } else {
                $string.= $value;
            }
        }

        $result = sha1( $string );

        return $result;
    }

    /**
     * @param $url
     * @param array $requestFields
     * @return array
     */
    public function sendRequest( $url, array $requestFields )
    {
        $curl = curl_init( $url );

        curl_setopt_array( $curl, array
        (
            CURLOPT_HEADER         => 0,
            CURLOPT_USERAGENT      => 'Zotapay-Client/1.0',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST           => 1,
            CURLOPT_RETURNTRANSFER => 1
        ));

        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $requestFields ) );

        $response = curl_exec( $curl );

        if( curl_errno( $curl ) )
        {
            $error_message  = 'Error occurred: ' . curl_error( $curl );
            $error_code     = curl_errno( $curl );
        }
        elseif( curl_getinfo( $curl, CURLINFO_HTTP_CODE ) != 200 )
        {
            $error_code     = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
            $error_message  = "Error occurred. HTTP code: '{$error_code}'";
        }

        curl_close( $curl );

        if ( !empty( $error_message ) )
        {
            throw new RuntimeException( $error_message, $error_code );
        }

        if( empty( $response ) )
        {
            throw new RuntimeException( 'Host response is empty' );
        }

        $responseFields = array();

        parse_str( $response, $responseFields );

        return $responseFields;
    }

    /**
     * @param $filename
     */
    protected function setMap( $filename )
    {
        $map = file_get_contents( get_template_directory_uri() . '/includes/gravityforms/'.$filename );
        if ( !$map ) $this->map = false;
        $map = json_decode( $map, true );
        $this->map = $map;
    }

    /**
     * @return array|bool
     */
    protected function getMap()
    {
        return $this->map;
    }

    /**
     * @return string
     */
    protected function countrycodes( $country_name )
    {
        $countrycodes = array (
            'AF' => 'Afghanistan',
            'AX' => 'Åland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Zaire',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Côte D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and Mcdonald Islands',
            'VA' => 'Vatican City State',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'KENYA',
            'KI' => 'Kiribati',
            'KP' => 'Korea, Democratic People\'s Republic of',
            'KR' => 'Korea, Republic of',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia, the Former Yugoslav Republic of',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States of',
            'MD' => 'Moldova, Republic of',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Réunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard and Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan, Province of China',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania, United Republic of',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Minor Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );

        foreach ( $countrycodes as $key=>$value )
        {
            if ( $value == $country_name )
            {
                $result = $key;
                break;
            }
        }

        return $result;
    }


}