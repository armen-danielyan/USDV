<?php
//set multi lang
function get_usdv_user_locale_language()
{
    if(!isset($_COOKIE['_set_user_local_language'])) {

        $arabicLang = array('Bahrain','Iraq','Jordan','Kuwait','Lebanon','Oman','Qatar','Pakistan','Saudi Arabia','Turkey','United Arab Emirates' );

        $spainLang = array('Spain', 'Venezuela', 'Peru', 'Mexico', 'Ecuador', 'Colombia', 'Chile');

        $ItalianoLang = array('Italy' );

        $ip_address = $_SERVER['REMOTE_ADDR'];
        $aa = @file_get_contents('https://ip-api.com/json/'.$ip_address);
        $a = json_decode($aa);

        $lang_code = 'en';

        if(!empty($a) && $a->status=='success'){
            $country = $a->country;
            if(in_array($country, $arabicLang)){
                $lang_code = 'ar';
            }elseif(in_array($country, $spainLang)){
                $lang_code = 'es';
            }elseif(in_array($country, $ItalianoLang)){ echo 'here3';
                $lang_code = 'it';
            }else{
                $lang_code = 'en';
            }
        }
        //get lang option and set default lang
        $new_settings = array();
        if($settings = get_option('polylang')){
            foreach($settings as $key=>$value){
                if($key == 'default_lang'){
                    $new_settings['default_lang'] = $lang_code;
                }else{$new_settings[$key] = $value;

                }
            }
        }

        update_option('polylang', $new_settings);
        setcookie("_set_user_local_language", 1, time() + 3600);
    }

}

add_action('init', 'get_usdv_user_locale_language');

//admin part start
add_action('admin_menu', 'usdv_apply_member_list_menu_page');
/**
 * Member list - admin menu
 */
function usdv_apply_member_list_menu_page(){
    add_menu_page('US DV Applicants', ' US DV Applicants', 'manage_options', 'us-dv-apply-member', 'usdv_apply_member_list_page', 'dashicons-admin-users"');
}

//add_action( 'show_user_profile', array( $this, 'add_customer_meta_fields' ) );
add_action( 'edit_user_profile', 'add_usdv_member_additional_fields' );

//add_action( 'personal_options_update', array( $this, 'save_customer_meta_fields' ) );
add_action( 'edit_user_profile_update', 'save_usdv_member_additional_fields' );

function add_usdv_member_additional_fields($user){
   if(isset($user->roles) && ($user->roles[0] == 'member')){
       $user_id = $user->ID;
       include_once "member_additional_fields.php";
   }
}

function save_usdv_member_additional_fields($member_id){
   if(isset($_POST)){

       update_user_meta($member_id, 'first_name', $_POST['first_name']);
       update_user_meta($member_id, 'last_name', $_POST['last_name']);
       update_user_meta($member_id, 'birth_country', $_POST['birth_country']);
       update_user_meta($member_id, 'education_level', $_POST['education_level']);
       update_user_meta($member_id, 'country_of_residence', $_POST['country_of_residence']);
       update_user_meta($member_id, 'phone_code', $_POST['phone_code']);
       update_user_meta($member_id, 'phone', $_POST['phone']);

       update_user_meta($member_id, 'married_status', $_POST['married_status']);
       update_user_meta($member_id, 'occupation', $_POST['occupation']);
       update_user_meta($member_id, 'annual_income', $_POST['annual_income']);
       update_user_meta($member_id, 'work_experience', $_POST['work_experience']);
       update_user_meta($member_id, 'been_to_usa', $_POST['been_to_usa']);
       update_user_meta($member_id, 'purpose_of_appliying', $_POST['purpose_of_appliying']);

       //check marid
       if (($_POST['married_status'] != 'Married')) {
           $total_child = get_user_meta($member_id, 'no_of_children', true);
           update_user_meta($member_id, 'have_children', 'no');
           for ($i = 1; $i <= $total_child; $i++) {
               delete_user_meta($member_id, 'c_first_name_'.$i);
               delete_user_meta($member_id, 'c_last_name_'.$i);
               delete_user_meta($member_id, 'c_gender_'.$i);
               delete_user_meta($member_id, 'c_dob_'.$i);
           }
           update_user_meta($member_id, 'no_of_children', 0);
       }

       update_user_meta($member_id, 'spouse_birth_country', $_POST['spouse_birth_country']);
       update_user_meta($member_id, 'spouse_education_level', $_POST['spouse_education_level']);
       update_user_meta($member_id, 'have_children', $_POST['have_children']);
       if($_POST['have_children'] == 'Yes'){
           update_user_meta($member_id, 'no_of_children', $_POST['no_of_children']);
           $total_child = $_POST['no_of_children'];
           for ($i = 1; $i <= $total_child; $i++) {
               update_user_meta($member_id, 'c_first_name_'.$i, $_POST['c_first_name_'.$i]);
               update_user_meta($member_id, 'c_last_name_'.$i, $_POST['c_last_name_'.$i]);
               update_user_meta($member_id, 'c_gender_'.$i, $_POST['c_gender_'.$i]);
               update_user_meta($member_id, 'c_dob_'.$i, $_POST['c_dob_'.$i]);
           }
       }

       update_user_meta($member_id, 'address1', $_POST['address1']);
       update_user_meta($member_id, 'address2', $_POST['address2']);
       update_user_meta($member_id, 'address', $_POST['address']);
       update_user_meta($member_id, 'street_number', $_POST['street_number']);
       update_user_meta($member_id, 'route', $_POST['route']);
       update_user_meta($member_id, 'locality', $_POST['locality']);
       update_user_meta($member_id, 'administrative_area_level_1', $_POST['administrative_area_level_1']);
       update_user_meta($member_id, 'postal_code', $_POST['postal_code']);
       update_user_meta($member_id, 'country', $_POST['country']);
       update_user_meta($member_id, 'additional_phone_country', $_POST['additional_phone_country']);
       update_user_meta($member_id, 'additional_phone_code', $_POST['additional_phone_code']);
       update_user_meta($member_id, 'additional_phone', $_POST['additional_phone']);

   }
}

/**
 * Member list - admin page
 */
function usdv_apply_member_list_page(){
    //load Registered_Member_List_Table class file
    include_once "member_list.php";
    //Create an instance of Registered Member List Table class...
    $memberResultListTable = new Registered_Member_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $memberResultListTable->prepare_items();?>
    <div class="wrap">

        <div id="icon-users" class="icon32"><br/></div>
        <h2><?php echo __('US DV Applicants', 'usdv-apply-form') ?></h2>

        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="member-list" method="get">
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <!-- Now we can render the completed list table -->
            <?php $memberResultListTable->display() ?>
        </form>

    </div>
    <?php
}
//admin part end

function urf_ajax_user_registration_form(){
    $return = array();

    $email  = ! empty( $_POST['email'] )  ?  $_POST['email']  : '';
	$step   = ! empty( $_POST['step'] )   ?  $_POST['step']   : 0;
	$update = ! empty( $_POST['update'] ) ?  $_POST['update'] : 0;

    if ( email_exists($email) && $step == 0 && $update == 0 )
    {
        $return['status'] = 'exists';
        echo json_encode($return);
	}
    elseif( $step )
    {
		$member_id = email_exists($email);



		if( $step == 1 && $update == 1 )
        {
            update_user_meta($member_id, 'first_name', $_POST['first_name']);
			update_user_meta($member_id, 'last_name', $_POST['last_name']);
			update_user_meta($member_id, 'birth_country', $_POST['birth_country']);
			update_user_meta($member_id, 'education_level', $_POST['education_level']);
			update_user_meta($member_id, 'country_of_residence', $_POST['country_of_residence']);
			update_user_meta($member_id, 'phone_country', $_POST['phone_country']);
			update_user_meta($member_id, 'phone_code', $_POST['phone_code']);
			update_user_meta($member_id, 'phone', $_POST['phone']);
		}
        if( $step == 2 )
        {
			update_user_meta($member_id, 'married_status', $_POST['married_status']);
			update_user_meta($member_id, 'occupation', $_POST['occupation']);
			update_user_meta($member_id, 'annual_income', $_POST['annual_income']);
			update_user_meta($member_id, 'work_experience', $_POST['work_experience']);
			update_user_meta($member_id, 'been_to_usa', $_POST['been_to_usa']);
			update_user_meta($member_id, 'purpose_of_appliying', $_POST['purpose_of_appliying']);

            //check marid
            if (($_POST['married_status'] != 'Married')) {
                $total_child = get_user_meta($member_id, 'no_of_children', true);
                update_user_meta($member_id, 'have_children', 'no');
                for ($i = 1; $i <= $total_child; $i++) {
                    delete_user_meta($member_id, 'c_first_name_'.$i);
                    delete_user_meta($member_id, 'c_last_name_'.$i);
                    delete_user_meta($member_id, 'c_gender_'.$i);
                    delete_user_meta($member_id, 'c_dob_'.$i);
                }
                update_user_meta($member_id, 'no_of_children', 0);
            }

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
			update_user_meta($member_id, 'additional_phone_code', $_POST['additional_phone_code']);
			update_user_meta($member_id, 'additional_phone', $_POST['additional_phone']);

			update_user_meta($member_id, 'step4', 1);

			update_user_meta($member_id, 'registration_complete', 1);

            //get child details
            if(get_user_meta($member_id, 'have_children', true) == 'Yes'){
               $total_child = get_user_meta($member_id, 'no_of_children', true);
                if($total_child > 0){
                for ($i = 1; $i <= $total_child; $i++) {?>
                    <strong>Children <?php echo $i; ?></strong>
                    <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below">
                        <li id="field_1_1" class="gfield field_sublabel_below field_description_below">
                            <div class="ginput_complex ginput_container no_prefix has_first_name no_middle_name has_last_name no_suffix gf_name_has_2 ginput_container_name" id="input_1_1">
                                    <span id="input_1_1_3_container" class="name_first">
                                        <input type="text" name="c_first_name_<?php echo $i; ?>" id="c_first_name" value="<?php echo get_user_meta($member_id, 'c_first_name_'.$i, true); ?>"  aria-label="First name" tabindex="1" class="">
                                        <label for="first_name">First Name*</label>
                                    </span>
                                    <span id="input_1_1_6_container" class="name_last">
                                        <input type="text" name="c_last_name_<?php echo $i; ?>" id="c_last_name" value="<?php echo get_user_meta($member_id, 'c_last_name_'.$i, true); ?>" aria-label="Last name" tabindex="2" class="required">
                                        <label for="last_name">Last Name*</label>
                                    </span>
                                <div class="gf_clear gf_clear_complex"></div>
                            </div>
                        </li>

                        <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                            <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">
                                <span class="ginput_left address_zip" id="input_1_2_5_container">
                                    <?php $childGender = get_user_meta($member_id, 'c_gender_'.$i, true); ?>
                                    <select class="" name="c_gender_<?php echo $i; ?>" id="gender" tabindex="3">
                                        <option value="">Select Gender</option>
                                        <option value="male" <?php echo !empty($childGender) && $childGender == 'male' ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo !empty($childGender) && $childGender == 'female' ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                    <label for="last_name">Gender</label>
                                </span>
                                <span id="input_1_1_6_container" class="ginput_right  name_last">
                                    <input type="date" name="c_dob_<?php echo $i; ?>" id="c_dob_" value="<?php echo get_user_meta($member_id, 'c_dob_'.$i, true); ?>" aria-label="dob" tabindex="2" class="required">
                                    <label for="last_name">Date of birth *</label>
                                </span>

                                <div class="gf_clear gf_clear_complex"></div>
                            </div>
                        </li>
                    </ul>

                <?php } }else{
                    echo '<strong>You have no children.</strong>';
                }
            }else{
                echo '<strong>You have no children.</strong>';
            }

		}elseif($step == 5 && isset($_POST['childUpdate'])){

            //get child details
            if(get_user_meta($member_id, 'have_children', true) == 'Yes'){
                $total_child = get_user_meta($member_id, 'no_of_children', true);
                for ($i = 1; $i <= $total_child; $i++) {
                    update_user_meta($member_id, 'c_first_name_'.$i, $_POST['c_first_name_'.$i]);
                    update_user_meta($member_id, 'c_last_name_'.$i, $_POST['c_last_name_'.$i]);
                    update_user_meta($member_id, 'c_gender_'.$i, $_POST['c_gender_'.$i]);
                    update_user_meta($member_id, 'c_dob_'.$i, $_POST['c_dob_'.$i]);
                }
            }

		}elseif($step == 7 && isset($_POST['confirm_password'])){
			wp_set_password( $_POST['confirm_password'], $member_id );
		}

	}
    else {

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

		if ( $member_id = wp_insert_user( $new_customer_data ) ) {

            wp_set_auth_cookie( $member_id, false );

			update_user_meta($member_id, 'first_name', $_POST['first_name']);
			update_user_meta($member_id, 'last_name', $_POST['last_name']);
			update_user_meta($member_id, 'birth_country', $_POST['birth_country']);
			update_user_meta($member_id, 'education_level', $_POST['education_level']);
			update_user_meta($member_id, 'country_of_residence', $_POST['country_of_residence']);
			update_user_meta($member_id, 'phone_country', $_POST['phone_country']);
			update_user_meta($member_id, 'phone_code', $_POST['phone_code']);
			update_user_meta($member_id, 'phone', $_POST['phone']);
			update_user_meta($member_id, 'step1', 1);
			update_user_meta($member_id, 'registration_complete', 0);


            // Salesforce web to lead
            $url = 'https://www.salesforce.com/servlet/servlet.WebToLead?encoding=UTF-8';
            $post = array(
                'oid'                     => '00D24000000j6f3',
                'first_name'              => $_POST['first_name'],
                'last_name'               => $_POST['last_name'],
                'email'                   => $email,
                'Country_of_Birth__c'     => $_POST['birth_country'],
                'Country_of_Residence__c' => $_POST['country_of_residence'],
                'Education_Level__c'      => $_POST['education_level'],
                'phone'                   => '('.$_POST['phone_code'] .')'. $_POST['phone'],
                'retURL'                  => add_query_arg(array()),
                'debug'                   => 0,
                'debug_email'             => 0
            );
            $args = array(
                'body'      => $post,
                'headers'   => array(
                    'user-agent' => 'Salesforce web to lead - WordPress/'.get_bloginfo('url'),
                ),
                'sslverify' => false,
                'timeout'	=> 60
            );

            $response = wp_remote_post( $url, $args );



            wp_new_user_notification($member_id, $password);
            $return['status'] = 'added';
            $return['id'] = $member_id;
            echo json_encode($return);
		}
	}
	die(); // Important
}
add_action( 'wp_ajax_user_registration_form', 'urf_ajax_user_registration_form' );
add_action( 'wp_ajax_nopriv_user_registration_form', 'urf_ajax_user_registration_form' );

function urf_ajax_check_eligible(){
    $education_level = array(
        'High School Degree',
        'Some University Courses',
        'University Degree',
        'Some Graduate Level Courses',
        'Master Degree',
        'Some Doctorates Level Courses',
        'Doctorate Degree'
    );
    $birth_country = array(
        "Afghanistan",
        "Albania",
        "Algeria",
        "Andorra",
        "Angola",
        "Antigua and Barbuda",
        "Argentina",
        "Armenia",
        "Aruba",
        "Australia",
        "Austria",
        "Azerbaijan",
        "Bahamas",
        "Bahrain",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Bhutan",
        "Bolivia",
        "Bosnia and Herzegovina",
        "Botswana",
        "Brunei",
        "Bulgaria",
        "Burkina Faso",
        "Burma",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Cape Verde",
        "Central African Republic",
        "Chad",
        "Chile",
        "Comoros",
        "Congo, Democratic Republic of the",
        "Congo, Republic of the",
        "Costa Rica",
        "Côte dIvoire",
        "Croatia",
        "Cuba",
        "Curacao",
        "Cyprus",
        "Czech Republic",
        "Denmark",
        "Djibouti",
        "Dominica",
        "East Timor",
        "Egypt",
        "Equatorial Guinea",
        "Eritrea",
        "Estonia",
        "Ethiopia",
        "Fiji",
        "Finland",
        "France",
        "Gabon",
        "Gambia",
        "Georgia",
        "Germany",
        "Ghana",
        "Greece",
        "Grenada",
        "Guatemala",
        "Guinea",
        "Guinea-Bissau",
        "Guyana",
        "Vatican City",
        "Honduras",
        "Hong Kong",
        "Hungary",
        "Iceland",
        "Indonesia",
        "Iran",
        "Iraq",
        "Ireland",
        "Israel",
        "Italy",
        "Japan",
        "Jordan",
        "Kazakhstan",
        "Kenya",
        "Kiribati",
        "Kosovo",
        "Kuwait",
        "Kyrgyzstan",
        "Laos",
        "Latvia",
        "Lebanon",
        "Lesotho",
        "Liberia",
        "Libya",
        "Liechtenstein",
        "Lithuania",
        "Luxembourg",
        "Macau",
        "Macedonia",
        "Madagascar",
        "Malawi",
        "Malaysia",
        "Maldives",
        "Mali",
        "Malta",
        "Marshall Islands",
        "Mauritania",
        "Mauritius",
        "Micronesia",
        "Moldova",
        "Monaco",
        "Mongolia",
        "Montenegro",
        "Morocco",
        "Mozambique",
        "Namibia",
        "Nauru",
        "Nepal",
        "Netherlands",
        "Netherlands Antilles",
        "New Zealand",
        "Nicaragua",
        "Niger",
        "North Korea",
        "South Korea",
        "Norway",
        "Oman",
        "Palau",
        "Palestinian Territories",
        "Panama",
        "Papua New Guinea",
        "Paraguay",
        "Poland",
        "Portugal",
        "Qatar",
        "Romania",
        "Russia",
        "Rwanda",
        "Saint Kitts and Nevis",
        "Saint Lucia",
        "Saint Vincent and the Grenadines",
        "Samoa",
        "San Marino",
        "Sao Tome and Principe",
        "Saudi Arabia",
        "Senegal",
        "Serbia",
        "Seychelles",
        "Sierra Leone",
        "Singapore",
        "Sint Maarten",
        "Slovakia",
        "Slovenia",
        "Solomon Islands",
        "Somalia",
        "South Africa",
        "South Sudan",
        "Spain",
        "Sri Lanka",
        "Sudan",
        "Suriname",
        "Swaziland",
        "Sweden",
        "Switzerland",
        "Syria",
        "Taiwan",
        "Tajikistan",
        "Tanzania",
        "Thailand",
        "Timor-Leste",
        "Togo",
        "Tonga",
        "Trinidad and Tobago",
        "Tunisia",
        "Turkey",
        "Turkmenistan",
        "Tuvalu",
        "Uganda",
        "Ukraine",
        "United Arab Emirates",
        "Uruguay",
        "Uzbekistan",
        "Vanuatu",
        "Venezuela",
        "Yemen",
        "Zambia",
        "Zimbabwe"
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

			sleep(10);
			echo 'eligible';
		} else {
			update_user_meta($member_id, 'DV_eligible', 0);
			sleep(10);
			echo 'not_eligible';
		}
	}else {
		sleep(10);
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

//member login action
function urf_ajax_member_change_password(){
	if ( empty( $_POST['password'] ) ) {?>
		<div class="error"><?php _e("Password is required.", 'organicthemes') ?></div>
	<?php }

	if ( empty( $_POST['cpassword'] ) ) {?>
		<div class="error"><?php _e("Confirm Password is required.", 'organicthemes') ?></div>
	<?php }

	if ( $_POST['password'] !=  $_POST['cpassword']) {?>
		<div class="error"><?php _e("Confirm Password did not match.", 'organicthemes') ?></div>
	<?php }

	if ( $_POST['password'] ==  $_POST['cpassword']) {
		$member_id = get_current_user_id();
		$member = new WP_User($member_id);

		$password = $_POST['cpassword'];

		wp_set_password( $_POST['cpassword'], $member_id );
		// Here is the magic:
		wp_cache_delete($member_id, 'users');
		wp_cache_delete($member->user_login, 'userlogins');
		wp_logout();
		wp_signon(array('user_login' => $member->user_login, 'user_password' => $password));
		echo 'success';
	}
	die();
}

add_action( 'wp_ajax_member_change_password', 'urf_ajax_member_change_password' );
add_action( 'wp_ajax_nopriv_member_change_password', 'urf_ajax_member_change_password' );

//member login action
function urf_ajax_get_phone_code_by_ip(){

    $ip_address = $_SERVER['REMOTE_ADDR'];
    $aa = file_get_contents('http://ip-api.com/json/'.$ip_address);
    $a = json_decode($aa);

    if(!empty($a) && $a->status=='success'){
        $countryCode = $a->country;
        echo get_phone_code_from_country($countryCode);
    }
	die();
}

add_action( 'wp_ajax_get_phone_code_by_ip', 'urf_ajax_get_phone_code_by_ip' );
add_action( 'wp_ajax_nopriv_get_phone_code_by_ip', 'urf_ajax_get_phone_code_by_ip' );

//member photo upload action
function urf_ajax_member_photo_upload(){
    $member_id = get_current_user_id();
    $return = array();
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }

    $uploadedfile = $_FILES['photo'];

    $upload_overrides = array( 'test_form' => false );

    $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

    if ( $movefile && !isset( $movefile['error'] ) ) {
        $return['status'] = 1;
        $return['url'] = $movefile['url'];

        //unlink past image
        if($photo_url = get_user_meta($member_id, 'photo_url', true)){
            //url to path
            $photo_path = str_replace(rtrim(get_site_url(),'/').'/', ABSPATH, $photo_url);
           @unlink($photo_path);
        }
        update_user_meta($member_id, 'photo_url', $movefile['url']);

        echo json_encode(array($return));
    } else {
        $return['status'] = 0;
        $return['url'] = $movefile['error'];
        echo json_encode(array($return));
    }
	die();
}


add_action( 'wp_ajax_member_photo_upload', 'urf_ajax_member_photo_upload' );
add_action( 'wp_ajax_nopriv_member_photo_upload', 'urf_ajax_member_photo_upload' );

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

function getCountryList(){
    $country = array(
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
//        'United States',
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

    return $country;
}

function getEducationLevelList(){
    $education = array(
        'Primary School',
        'High School No Degree',
        'High School Degree',
        'Vocational School',
        'Some University Courses',
        'University Degree',
        'Some Graduate Level Courses',
        'Master Degree',
        'Some Doctorates Level Courses',
        'Doctorate Degree',
        'Other'
    );

    return $education;
}

function getOccupationList(){
    $occupations = array(
        'Accountant',
        'Actor/Actress',
        'Architect',
        'Astronomer',
        'Athlete',
        'Author',
        'Baker',
        'Banker',
        'Beautician',
        'Bricklayer',
        'Bus driver',
        'Business Man',
        'Business Owner',
        'Butcher',
        'Carpenter',
        'Cashier',
        'CEO (Chief Executive Officer)',
        'CFO (Chief Financial Officer)',
        'Chef/Cook',
        'Chemist',
        'CIO (Chief Information Officer)',
        'Cleaner',
        'Clerk',
        'CMO (Chief Marketing Officer)',
        'Computer Programmer',
        'Computer Technician',
        'Contractor',
        'COO (Chief Operating Officer)',
        'CTO (Chief Technology Officer)',
        'CXO (Chief Experience Officer)',
        'Dentist',
        'Doctor�MD',
        'Electrician',
        'Engineer',
        'Factory worker',
        'Farmer',
        'Fireman',
        'Fisherman',
        'Florist',
        'Gardener',
        'Graphic Designer',
        'Hairdresser',
        'Interior Designer',
        'Jewler',
        'Journalist',
        'Judge',
        'Lawyer',
        'Lecturer',
        'Librarian',
        'Lifeguard',
        'Manager',
        'Marketing Manager',
        'Mechanic',
        'Model',
        'Musician',
        'Newsreader',
        'Nurse',
        'Optician',
        'Other',
        'Painter',
        'Pharmacist',
        'Photographer',
        'Pilot',
        'Plumber',
        'Policeman/Policewoman',
        'Politician',
        'Postman',
        'Professorv',
        'Psychiatrist',
        'Psychologist',
        'Real estate agent',
        'Receptionist',
        'Sales Manager',
        'Salesman',
        'Scientist',
        'Secretary',
        'Shop assistant',
        'Software Engineer',
        'Soldier',
        'Surgeon',
        'Tailor',
        'Taxi driver',
        'Teacher',
        'Therapist',
        'Traffic warden',
        'Translator',
        'Travel agent',
        'TV Presenter',
        'Veterinary doctor(Vet)',
        'Waiter / Waitress',
        'Web Developer',
        'Window cleaner'
    );

    return $occupations;
}

function getMaritalStatusList()
{
    $status = array(
        'Single',
        'Married',
        'Widowed',
        'Divorced',
        'Legally Seperated'
    );

    return $status;
}

function getAnnualIncomeList()
{
    $incomes = array(
        'Less than $10,000',
        '$10,000 - $25,000',
        '$25,000 - $50,000',
        '$50,000 - $100,000',
        'More than $100,000'
    );

    return $incomes;
}

function getWorkExperienceList()
{
    $experience = array(
        'Less than 5 years',
        '5 Years - 10 years',
        '10 years - 20 Years',
        '20 years - 30 Years',
        'More than 30 Years'
    );

    return $experience;
}

function getPurposeForApplyingList()
{
    $purpose = array(
        'Migration',
        'Business',
        'Leisure',
        'Education',
        'Other'
    );

    return $purpose;
}

function get_phone_code_from_country($country){

    $countryList = array(
        'Afghanistan'                                  => 93,
        'Albania'                                      => 355,
        'Algeria'                                      => 213,
        'American Samoa'                               => 1684,
        'Andorra'                                      => 376,
        'Angola'                                       => 244,
        'Anguilla'                                     => 1264,
        'Antarctica'                                   => 0,
        'Antigua and Barbuda'                          => 1268,
        'Argentina'                                    => 54,
        'Armenia'                                      => 374,
        'Aruba'                                        => 297,
        'Australia'                                    => 61,
        'Austria'                                      => 43,
        'Azerbaijan'                                   => 994,
        'Bahamas'                                      => 1242,
        'Bahrain'                                      => 973,
        'Bangladesh'                                   => 880,
        'Barbados'                                     => 1246,
        'Belarus'                                      => 375,
        'Belgium'                                      => 32,
        'Belize'                                       => 501,
        'Benin'                                        => 229,
        'Bermuda'                                      => 1441,
        'Bhutan'                                       => 975,
        'Bolivia'                                      => 591,
        'Bosnia and Herzegovina'                       => 387,
        'Botswana'                                     => 267,
        'Bouvet Island'                                => 0,
        'Brazil'                                       => 55,
        'British Indian Ocean Territory'               => 246,
        'Brunei Darussalam'                            => 673,
        'Bulgaria'                                     => 359,
        'Burkina Faso'                                 => 226,
        'Burundi'                                      => 257,
        'Cambodia'                                     => 855,
        'Cameroon'                                     => 237,
        'Canada'                                       => 1,
        'Cape Verde'                                   => 238,
        'Cayman Islands'                               => 1345,
        'Central African Republic'                     => 236,
        'Chad'                                         => 235,
        'Chile'                                        => 56,
        'China'                                        => 86,
        'Christmas Island'                             => 61,
        'Cocos (Keeling) Islands'                      => 672,
        'Colombia'                                     => 57,
        'Comoros'                                      => 269,
        'Congo'                                        => 242,
        'Congo, the Democratic Republic of the'        => 242,
        'Cook Islands'                                 => 682,
        'Costa Rica'                                   => 506,
        'Cote D Ivoire'                                => 225,
        'Croatia'                                      => 385,
        'Cuba'                                         => 53,
        'Cyprus'                                       => 357,
        'Czech Republic'                               => 420,
        'Denmark'                                      => 45,
        'Djibouti'                                     => 253,
        'Dominica'                                     => 1767,
        'Dominican Republic'                           => 1809,
        'Ecuador'                                      => 593,
        'Egypt'                                        => 20,
        'El Salvador'                                  => 503,
        'Equatorial Guinea'                            => 240,
        'Eritrea'                                      => 291,
        'Estonia'                                      => 372,
        'Ethiopia'                                     => 251,
        'Falkland Islands (Malvinas)'                  => 500,
        'Faroe Islands'                                => 298,
        'Fiji'                                         => 679,
        'Finland'                                      => 358,
        'France'                                       => 33,
        'French Guiana'                                => 594,
        'French Polynesia'                             => 689,
        'French Southern Territories'                  => 0,
        'Gabon'                                        => 241,
        'Gambia'                                       => 220,
        'Georgia'                                      => 995,
        'Germany'                                      => 49,
        'Ghana'                                        => 233,
        'Gibraltar'                                    => 350,
        'Greece'                                       => 30,
        'Greenland'                                    => 299,
        'Grenada'                                      => 1473,
        'Guadeloupe'                                   => 590,
        'Guam'                                         => 1671,
        'Guatemala'                                    => 502,
        'Guinea'                                       => 224,
        'Guinea-Bissau'                                => 245,
        'Guyana'                                       => 592,
        'Haiti'                                        => 509,
        'Heard Island and Mcdonald Islands'            => 0,
        'Holy See (Vatican City State)'                => 39,
        'Honduras'                                     => 504,
        'Hong Kong'                                    => 852,
        'Hungary'                                      => 36,
        'Iceland'                                      => 354,
        'India'                                        => 91,
        'Indonesia'                                    => 62,
        'Iran, Islamic Republic of'                    => 98,
        'Iraq'                                         => 964,
        'Ireland'                                      => 353,
        'Israel'                                       => 972,
        'Italy'                                        => 39,
        'Jamaica'                                      => 1876,
        'Japan'                                        => 81,
        'Jordan'                                       => 962,
        'Kazakhstan'                                   => 7,
        'Kenya'                                        => 254,
        'Kiribati'                                     => 686,
        'Korea, Democratic People\'s Republic of'      => 850,
        'Korea, Republic of'                           => 82,
        'Kuwait'                                       => 965,
        'Kyrgyzstan'                                   => 996,
        'Lao People\'s Democratic Republic'            => 856,
        'Latvia'                                       => 371,
        'Lebanon'                                      => 961,
        'Lesotho'                                      => 266,
        'Liberia'                                      => 231,
        'Libyan Arab Jamahiriya'                       => 218,
        'Liechtenstein'                                => 423,
        'Lithuania'                                    => 370,
        'Luxembourg'                                   => 352,
        'Macao'                                        => 853,
        'Macedonia, the Former Yugoslav Republic of'   => 389,
        'Madagascar'                                   => 261,
        'Malawi'                                       => 265,
        'Malaysia'                                     => 60,
        'Maldives'                                     => 960,
        'Mali'                                         => 223,
        'Malta'                                        => 356,
        'Marshall Islands'                             => 692,
        'Martinique'                                   => 596,
        'Mauritania'                                   => 222,
        'Mauritius'                                    => 230,
        'Mayotte'                                      => 269,
        'Mexico'                                       => 52,
        'Micronesia, Federated States of'              => 691,
        'Moldova, Republic of'                         => 373,
        'Monaco'                                       => 377,
        'Mongolia'                                     => 976,
        'Montserrat'                                   => 1664,
        'Morocco'                                      => 212,
        'Mozambique'                                   => 258,
        'Myanmar'                                      => 95,
        'Namibia'                                      => 264,
        'Nauru'                                        => 674,
        'Nepal'                                        => 977,
        'Netherlands'                                  => 31,
        'Netherlands Antilles'                         => 599,
        'New Caledonia'                                => 687,
        'New Zealand'                                  => 64,
        'Nicaragua'                                    => 505,
        'Niger'                                        => 227,
        'Nigeria'                                      => 234,
        'Niue'                                         => 683,
        'Norfolk Island'                               => 672,
        'Northern Mariana Islands'                     => 1670,
        'Norway'                                       => 47,
        'Oman'                                         => 968,
        'Pakistan'                                     => 92,
        'Palau'                                        => 680,
        'Palestinian Territory, Occupied'              => 970,
        'Panama'                                       => 507,
        'Papua New Guinea'                             => 675,
        'Paraguay'                                     => 595,
        'Peru'                                         => 51,
        'Philippines'                                  => 63,
        'Pitcairn'                                     => 0,
        'Poland'                                       => 48,
        'Portugal'                                     => 351,
        'Puerto Rico'                                  => 1787,
        'Qatar'                                        => 974,
        'Reunion'                                      => 262,
        'Romania'                                      => 40,
        'Russian Federation'                           => 70,
        'Rwanda'                                       => 250,
        'Saint Helena'                                 => 290,
        'Saint Kitts and Nevis'                        => 1869,
        'Saint Lucia'                                  => 1758,
        'Saint Pierre and Miquelon'                    => 508,
        'Saint Vincent and the Grenadines'             => 1784,
        'Samoa'                                        => 684,
        'San Marino'                                   => 378,
        'Sao Tome and Principe'                        => 239,
        'Saudi Arabia'                                 => 966,
        'Senegal'                                      => 221,
        'Serbia and Montenegro'                        => 381,
        'Seychelles'                                   => 248,
        'Sierra Leone'                                 => 232,
        'Singapore'                                    => 65,
        'Slovakia'                                     => 421,
        'Slovenia'                                     => 386,
        'Solomon Islands'                              => 677,
        'Somalia'                                      => 252,
        'South Africa'                                 => 27,
        'South Georgia and the South Sandwich Islands' => 0,
        'Spain'                                        => 34,
        'Sri Lanka'                                    => 94,
        'Sudan'                                        => 249,
        'Suriname'                                     => 597,
        'Svalbard and Jan Mayen'                       => 47,
        'Swaziland'                                    => 268,
        'Sweden'                                       => 46,
        'Switzerland'                                  => 41,
        'Syrian Arab Republic'                         => 963,
        'Taiwan, Province of China'                    => 886,
        'Tajikistan'                                   => 992,
        'Tanzania, United Republic of'                 => 255,
        'Thailand'                                     => 66,
        'Timor-Leste'                                  => 670,
        'Togo'                                         => 228,
        'Tokelau'                                      => 690,
        'Tonga'                                        => 676,
        'Trinidad and Tobago'                          => 1868,
        'Tunisia'                                      => 216,
        'Turkey'                                       => 90,
        'Turkmenistan'                                 => 7370,
        'Turks and Caicos Islands'                     => 1649,
        'Tuvalu'                                       => 688,
        'Uganda'                                       => 256,
        'Ukraine'                                      => 380,
        'United Arab Emirates'                         => 971,
        'United Kingdom'                               => 44,
        'United States'                                => 1,
        'United States Minor Outlying Islands'         => 1,
        'Uruguay'                                      => 598,
        'Uzbekistan'                                   => 998,
        'Vanuatu'                                      => 678,
        'Venezuela'                                    => 58,
        'Viet Nam'                                     => 84,
        'Virgin Islands, British'                      => 1284,
        'Virgin Islands, U.s.'                         => 1340,
        'Wallis and Futuna'                            => 681,
        'Western Sahara'                               => 212,
        'Yemen'                                        => 967,
        'Zambia'                                       => 260,
        'Zimbabwe'                                     => 263
    );

    return isset($countryList[$country]) ? $countryList[$country] : '';
}

function hide_admin_bar_from_front_end(){
    if (is_blog_admin()) {
        return true;
    }
    return false;
}
add_filter( 'show_admin_bar', 'hide_admin_bar_from_front_end' );