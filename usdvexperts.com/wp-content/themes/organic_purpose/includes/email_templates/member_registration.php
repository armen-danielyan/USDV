<?php

function urf_ajax_user_registration_form(){
	$email      = ! empty( $_POST['email'] ) ?  $_POST['email'] : '';
	$step      = ! empty( $_POST['step'] ) ?  $_POST['step'] : 0;
	$update      = ! empty( $_POST['update'] ) ?  $_POST['update'] : 0;
	if (email_exists($email) && $step == 0 && $update == 0) {
		echo 'exists';
	} elseif($step) {
		$member_id = email_exists($email);
		if($step == 1 && $update == 1){

			update_user_meta($member_id, 'first_name', $_POST['first_name']);
			update_user_meta($member_id, 'last_name', $_POST['first_name']);
			update_user_meta($member_id, 'birth_country', $_POST['birth_country']);
			update_user_meta($member_id, 'education_level', $_POST['education_level']);
			update_user_meta($member_id, 'country_of_residence', $_POST['country_of_residence']);
			update_user_meta($member_id, 'phone', $_POST['phone']);

		}if($step == 2){
			update_user_meta($member_id, 'married_status', $_POST['married_status']);
			update_user_meta($member_id, 'occupation', $_POST['occupation']);
			update_user_meta($member_id, 'annual_income', $_POST['annual_income']);
			update_user_meta($member_id, 'work_experience', $_POST['work_experience']);
			update_user_meta($member_id, 'been_to_usa', $_POST['been_to_usa']);
			update_user_meta($member_id, 'purpose_of_appliying', $_POST['purpose_of_appliying']);

			update_user_meta($member_id, 'step2', 1);
		}elseif($step == 3){
			update_user_meta($member_id, 'spouse_birth_country', $_POST['spouse_birth_country']);
			update_user_meta($member_id, 'spouse_education_level', $_POST['spouse_education_level']);
			update_user_meta($member_id, 'have_children', $_POST['have_children']);
			if($_POST['have_children'] == 'Yes'){
				update_user_meta($member_id, 'no_of_children', $_POST['no_of_children']);
			}

			update_user_meta($member_id, 'step3', 1);
		}elseif($step == 4){
			update_user_meta($member_id, 'address1', $_POST['address1']);
			update_user_meta($member_id, 'address2', $_POST['address2']);
			update_user_meta($member_id, 'address', $_POST['address']);
			update_user_meta($member_id, 'street_number', $_POST['street_number']);
			update_user_meta($member_id, 'route', $_POST['route']);
			update_user_meta($member_id, 'locality', $_POST['locality']);
			update_user_meta($member_id, 'administrative_area_level_1', $_POST['administrative_area_level_1']);
			update_user_meta($member_id, 'postal_code', $_POST['postal_code']);
			update_user_meta($member_id, 'country', $_POST['country']);
			update_user_meta($member_id, 'additional_phone', $_POST['additional_phone']);

			update_user_meta($member_id, 'step4', 1);

			update_user_meta($member_id, 'registration_complete', 1);
		}elseif($step == 7 && isset($_POST['confirm_password'])){
			wp_set_password( $_POST['confirm_password'], $member_id );
		}
	}else{
		$username = sanitize_user( current( explode( '@', $email ) ) );
		// Ensure username is unique
		$append     = 1;
		$o_username = $username;

		while ( username_exists( $username ) ) {
			$username = $o_username . $append;
			$append ++;
		}
		$password = wp_generate_password();
		$new_customer_data = array(
			'user_login' => $username,
			'user_pass'  => $password,
			'user_email' => $email,
			'role'       => 'member'
		);

		if($member_id = wp_insert_user($new_customer_data)){

			update_user_meta($member_id, 'first_name', $_POST['first_name']);
			update_user_meta($member_id, 'last_name', $_POST['last_name']);
			update_user_meta($member_id, 'birth_country', $_POST['birth_country']);
			update_user_meta($member_id, 'education_level', $_POST['education_level']);
			update_user_meta($member_id, 'country_of_residence', $_POST['country_of_residence']);
			update_user_meta($member_id, 'phone', $_POST['phone']);
			update_user_meta($member_id, 'step1', 1);
			update_user_meta($member_id, 'registration_complete', 0);

			wp_new_user_notification($member_id, $password);
			echo 'added';
		}
	}
	die(); // Important
}
add_action( 'wp_ajax_user_registration_form', 'urf_ajax_user_registration_form' );
add_action( 'wp_ajax_nopriv_user_registration_form', 'urf_ajax_user_registration_form' );

function urf_ajax_check_eligible(){
	$education_level = array('high_school_degree','some_university_courses','university_degree','some_graduate_level_courses','master_degree','some_doctorate_level_courses','doctorate_degree','other');
	$birth_country = array(
            'Afghanistan',
            'Albania',
            'Algeria',
            'American Samoa',
            'Andorra',
            'Angola',
            'Antigua and Barbuda',
            'Argentina',
            'Armenia',
            'Australia',
            'Austria',
            'Azerbaijan',
            'Bahamas',
            'Bahrain',
            'Bangladesh',
            'Barbados',
            'Belarus',
            'Belgium',
            'Belize',
            'Benin',
            'Bermuda',
            'Bhutan',
            'Bolivia',
            'Bosnia and Herzegovina',
            'Botswana',
            'Brazil',
            'Brunei',
            'Bulgaria',
            'Burkina Faso',
            'Burundi',
            'Cambodia',
            'Cameroon',
            'Canada',
            'Cape Verde',
            'Cayman Islands',
            'Central African Republic',
            'Chad',
            'Chile',
            'China',
            'Colombia',
            'Comoros',
            'Congo, Democratic Republic of the',
            'Congo, Republic of the',
            'Costa Rica',
            'Côte dIvoire',
            'Croatia',
            'Cuba',
            'Cyprus',
            'Czech Republic',
            'Denmark',
            'Djibouti',
            'Dominica',
            'Dominican Republic',
            'East Timor',
            'Ecuador',
            'Egypt',
            'El Salvador',
            'Equatorial Guinea',
            'Eritrea',
            'Estonia',
            'Ethiopia',
            'Faroe Islands',
            'Fiji',
            'Finland',
            'France',
            'French Polynesia',
            'Gabon',
            'Gambia',
            'Georgia',
            'Germany',
            'Ghana',
            'Greece',
            'Greenland',
            'Grenada',
            'Guam',
            'Guatemala',
            'Guinea',
            'Guinea-Bissau',
            'Guyana',
            'Haiti',
            'Honduras',
            'Hong Kong',
            'Hungary',
            'Iceland',
            'India',
            'Indonesia',
            'Iran',
            'Iraq',
            'Ireland',
            'Israel',
            'Italy',
            'Jamaica',
            'Japan',
            'Jordan',
            'Kazakhstan',
            'Kenya',
            'Kiribati',
            'North Korea',
            'South Korea',
            'Kosovo',
            'Kuwait',
            'Kyrgyzstan',
            'Laos',
            'Latvia',
            'Lebanon',
            'Lesotho',
            'Liberia',
            'Libya',
            'Liechtenstein',
            'Lithuania',
            'Luxembourg',
            'Macedonia',
            'Madagascar',
            'Malawi',
            'Malaysia',
            'Maldives',
            'Mali',
            'Malta',
            'Marshall Islands',
            'Mauritania',
            'Mauritius',
            'Mexico',
            'Micronesia',
            'Moldova',
            'Monaco',
            'Mongolia',
            'Montenegro',
            'Morocco',
            'Mozambique',
            'Myanmar',
            'Namibia',
            'Nauru',
            'Nepal',
            'Netherlands',
            'New Zealand',
            'Nicaragua',
            'Niger',
            'Nigeria',
            'Northern Mariana Islands',
            'Norway',
            'Oman',
            'Pakistan',
            'Palau',
            'Palestine, State of',
            'Panama',
            'Papua New Guinea',
            'Paraguay',
            'Peru',
            'Philippines',
            'Poland',
            'Portugal',
            'Puerto Rico',
            'Qatar',
            'Romania',
            'Russia',
            'Rwanda',
            'Saint Kitts and Nevis',
            'Saint Lucia',
            'Saint Vincent and the Grenadines',
            'Samoa',
            'San Marino',
            'Sao Tome and Principe',
            'Saudi Arabia',
            'Senegal',
            'Serbia',
            'Seychelles',
            'Sierra Leone',
            'Singapore',
            'Sint Maarten',
            'Slovakia',
            'Slovenia',
            'Solomon Islands',
            'Somalia',
            'South Africa',
            'Spain',
            'Sri Lanka',
            'Sudan',
            'Sudan, South',
            'Suriname',
            'Swaziland',
            'Sweden',
            'Switzerland',
            'Syria',
            'Taiwan',
            'Tajikistan',
            'Tanzania',
            'Thailand',
            'Togo',
            'Tonga',
            'Trinidad and Tobago',
            'Tunisia',
            'Turkey',
            'Turkmenistan',
            'Tuvalu',
            'Uganda',
            'Ukraine',
            'United Arab Emirates',
            'United Kingdom',
            'United States',
            'Uruguay',
            'Uzbekistan',
            'Vanuatu',
            'Vatican City',
            'Venezuela',
            'Vietnam',
            'Virgin Islands, British',
            'Virgin Islands, U.S.',
            'Yemen',
            'Zambia',
            'Zimbabwe'
        );

	$eligible = 0;
	$email      = ! empty( $_POST['email'] ) ?  $_POST['email'] : '';
	if($member_id = email_exists($email)) {
		//if not married
		if (isset($_POST['married_status']) && $_POST['married_status'] != 'Married') {
			if (in_array($_POST['education_level'], $education_level) && in_array($_POST['birth_country'], $birth_country)) {
				$eligible = 1;
			}
		} elseif (isset($_POST['married_status']) && $_POST['married_status'] == 'Married') {
			if (in_array($_POST['education_level'], $education_level) && in_array($_POST['birth_country'], $birth_country)) {
				$eligible = 1;
			} elseif (in_array($_POST['education_level'], $education_level)) {
				if (in_array($_POST['spouse_birth_country'], $birth_country)) {
					$eligible = 1;
				}
			} else {
				if (in_array($_POST['spouse_education_level'], $education_level) && in_array($_POST['spouse_birth_country'], $birth_country)) {
					$eligible = 1;
				}
			}
		}

		if ($eligible == 1) {
			update_user_meta($member_id, 'DV_eligible', 1);
			//send mail
			// set content type to html
			add_filter( 'wp_mail_content_type', 'urf_content_type' );

			//BUILD USER NOTIFICATION EMAIL
			$user = new WP_User( $member_id );

			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$subject  = sprintf(__('Congratulation! You are eligible for the US Diversity Program. - %s:'), $blogname) . "\r\n\r\n";

			//Get e-mail template
			$message_template = file_get_contents(ABSPATH . '/wp-content/themes/organic_purpose/includes/email_templates/eligible.php');
			//replace placeholders with user-specific content
			$message = str_ireplace('[login_url]', get_permalink(979), $message_template);
			//Prepare headers for HTML
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//Send user notification email
			wp_mail($user->user_email, $subject, $message, $headers);
			// remove html content type
			remove_filter ( 'wp_mail_content_type', 'urf_content_type' );

			echo 'eligible';
		} else {
			update_user_meta($member_id, 'DV_eligible', 0);
			echo 'not_eligible';
		}
	}else {
		echo 'not_eligible';
	}
	die();
}

add_action( 'wp_ajax_check_eligible', 'urf_ajax_check_eligible' );
add_action( 'wp_ajax_nopriv_check_eligible', 'urf_ajax_check_eligible' );

function urf_ajax_immigrate_to_other(){
	$email      = ! empty( $_POST['email'] ) ?  $_POST['email'] : '';
	if($member_id = email_exists($email)){
		update_user_meta($member_id, 'DV_eligible', 0);
		update_user_meta($member_id, 'immigrate_to', $_POST['immigrateTo']);
		echo '1';
	}
	die();
}

add_action( 'wp_ajax_immigrate_to_other', 'urf_ajax_immigrate_to_other' );
add_action( 'wp_ajax_nopriv_immigrate_to_other', 'urf_ajax_immigrate_to_other' );

//member login action
function urf_ajax_member_login(){
	$creds  = array();
	if ( empty( $_POST['email'] ) ) {?>
		<div class="error"><?php _e("E-mail is required.", 'organicthemes') ?></div>
	<?php }

	if ( empty( $_POST['password'] ) ) {?>
		<div class="error"><?php _e("Password is required.", 'organicthemes') ?></div>
	<?php }

	if ( is_email( $_POST['email'] ) ) {
		$user = get_user_by( 'email', $_POST['email'] );

		if ( isset( $user->user_login ) ) {
			$creds['user_login'] 	= $user->user_login;
			$creds['user_password'] = $_POST['password'];
			//$creds['remember']      = isset( $_POST['rememberme'] );

			$user = wp_signon($creds, false );
			if ( is_wp_error( $user ) ) {
				echo '<div class="error">'.$user->get_error_message().'</div>';
			}else{
				echo 'success';
			}
		} else {?>
			<div class="error"><?php _e("A user could not be found with this email address.", 'organicthemes') ?></div>
		<?php }
	}
	die();
}

add_action( 'wp_ajax_member_login', 'urf_ajax_member_login' );
add_action( 'wp_ajax_nopriv_member_login', 'urf_ajax_member_login' );

function add_member_role() {
	// Member role
	add_role( 'member','Member', array(
		'read' 						=> true,
		'edit_posts' 				=> false,
		'delete_posts' 				=> false
	) );
}
add_action( 'init', 'add_member_role' );

function urf_content_type() {

	return 'text/html';
}