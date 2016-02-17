<?php
/**
 * Template Name: Member Registration
 */
get_header();
global $wpdb;

//check login
if (is_user_logged_in()) {?>
    <script>
        window.location = "<?php echo get_permalink(981); ?>";
    </script>
<?php
}
?>

<script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.steps.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.validate.min.js" type="text/javascript"></script>
<script>
    jQuery(function() {
        var form = jQuery("#member_registration_form").show();
        var stepReady = true;
        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            titleTemplate: '<span class="number">#index#</span><span class="headingTitle">#title#</span>',
            /* Labels */
            labels: {
                current: "",
                previous: "",
                finish: "",
                next: "Step 2",
                loading: "Loading ..."
            },
            onStepChanging: function(event, currentIndex, newIndex)
            {
                //disabled done step
                jQuery('.steps').find('.done').addClass('disabled');

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                //check email already exist in system
                if (newIndex === 1)
                {
                    var email = jQuery('#email').val();
                    var first_name = jQuery('#first_name').val();
                    var last_name = jQuery('#last_name').val();
                    var birth_country = jQuery('#birth_country').val();
                    var education_level = jQuery('#education_level').val();
                    var country_of_residence = jQuery('#country_of_residence').val();
                    var phone_code = jQuery('#phone_code').val();
                    var phone = jQuery('#phone').val();

                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    if (email && first_name && last_name && birth_country && education_level && country_of_residence && phone_code && phone) {
                        jQuery("a[href^='#next']").text('Please wait...');
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&" + jQuery("#member_registration_form").serialize(),
                            dataType: 'json',
                            async: false,
                            cache: false,
                            timeout: 30000,
                            success: function(data) {
                                if (data.status == 'exists') {
                                    stepReady = false;
                                    window.location = "<?php echo get_permalink(979); ?>"; //redirect if email exists
                                } else if (data.status == 'added') {
                                    jQuery('#registrationSuccessStatus').val(1);
                                    jQuery('#mrid').val(data.id);
                                    jQuery('#merchant_order_id').val(data.id);
                                    stepReady = true;
                                }
                            }
                        });
                    }
                }

                //check email already exist in system
                if (newIndex === 2)
                {
                    jQuery('#have_children').on('change', function() {
                        if (this.value == 'Yes')
                        {
                            jQuery('#no_of_children').addClass("required");
                            jQuery('#no_of_children').val('');
                            jQuery('#no_of_children').prop("readonly", false);
                        }
                        if (this.value == 'no') {
                            jQuery('#no_of_children').removeClass("required");
                            jQuery('#no_of_children').val(0);
                            jQuery('#no_of_children').prop("readonly", true);
                        }
                    });
                    jQuery('#have_children').trigger('change');

                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    if (jQuery("#married_status").val()) {
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&step=2&" + jQuery("#member_registration_form").serialize(),
                            success: function(data) {
                            }
                        });
                    }
                }

                if (newIndex === 3 && (jQuery("#married_status").val() == 'Married'))
                {
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    // if (jQuery("#married_status").val() == 'Married') {
                    jQuery.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: "action=user_registration_form&step=3&" + jQuery("#member_registration_form").serialize(),
                        success: function(data) {
                        }
                    });
                    //}
                }
                if (newIndex === 4)
                {
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    if (jQuery("#address1").val()) {
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&step=4&" + jQuery("#member_registration_form").serialize(),
                            success: function(data) {
                            }
                        });
                    }
                }
                // Forbid next action on "Warning" step if the user is to young
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
               // return form.valid();
                if(stepReady){
                    return form.valid();
                }else{
                    return false;
                }
            },
            onStepChanged: function(event, currentIndex, priorIndex)
            {
                //disabled done step
                jQuery('.steps').find('.done').addClass('disabled');

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 0)
                {
                    jQuery("a[href^='#next']").text('Step 2');
                }

                if (currentIndex === 1)
                {
                    jQuery("a[href^='#next']").text('Step 3');
                }

                if (currentIndex === 2)
                {
                    jQuery("a[href^='#next']").text('Step 4');
                }

                if (currentIndex === 3)
                {
                    jQuery("a[href^='#next']").text('Check Eligibility Now');
                }

                if (currentIndex === 4)
                {
                    jQuery("a[href^='#finish']").remove();
                }

                if (currentIndex === 2 && priorIndex === 3)
                {
                    jQuery(this).steps("previous");
                    return;
                }

                //jQuery("input[name='married_status']:checked")
                if (currentIndex == 2 && (jQuery("#married_status").val() != 'Married'))
                {
                    jQuery(".body:eq(" + currentIndex + ") .required", form).removeClass("required");
                    form.steps("next");
                }
                if (currentIndex === 2 && (jQuery("#married_status").val() == 'Married'))
                {
                    jQuery(".body:eq(" + currentIndex + ") .married-details", form).addClass("required");
                }


                if (currentIndex === 4)
                {
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    jQuery.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: "action=check_eligible&" + jQuery("#member_registration_form").serialize(),
                        success: function(data) {
                            if (data == 'eligible') {
                                jQuery('#eligibilityCheckResult').html('<b>Congratulation</b><br/><p>You are eligible to apply.</p><br/>After 4 Sec. you will redirect to payment page.');
                                /*setTimeout(function() {
                                    window.location.href = "<?php echo get_permalink(985); ?>"
                                }, 4000);*/
                                setTimeout(function() {
                                    jQuery( "#goToPaymentPage" ).trigger( "click" );
                                }, 4000);
                            } else {
                                jQuery('#eligibilityCheckResult').html('<b>Unfortunately you are not eligible for US Diversity Visa</b><br/><p>Would you be interested to immigrate to</p><br/><a href="javascript:void(0)" onclick="immigrateTo(\'Canada\')">Canada</a><a href="javascript:void(0)" onclick="immigrateTo(\'Australia\')">Australia</a>');
                            }

                        }
                    });
                }

            },
            onFinishing: function(event, currentIndex)
            {

                return form.valid();
            },
            onFinished: function(event, currentIndex)
            {
                //alert("Submitted!");
                //form.submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) {
            },
            rules: {
                first_name: {
                    required: true,
                    lettersonly: true
                },
                last_name: {
                    required: true,
                    lettersonly: true
                },
                been_to_usa: {
                    required: true,
                    lettersonly: true
                },
                phone: {
                    required: true,
                    number: true
                },
                no_of_children: {
                    required: function(element) {
                        if(getMarriedStatus() == 'Married'){
                            return true;
                        }
                    },
                    /*integer: function(element) {
                        if(getMarriedStatus() == 'Married' && getHaveChildren() == 'Yes'){
                            return true;
                        }
                    }*/
                },
                additional_phone: {
                    required: true,
                    number: true
                },
                confirm: {
                    equalTo: "#password-2"
                }
            }
        });
        jQuery.validator.addMethod("lettersonly", function(value, element) {
            return this.optional(element) || /^[a-z]+$/i.test(value);
        }, "Letters only please");
        jQuery.validator.addMethod('integer', function(value, element, param) {
            return (value != 0) && (value == parseInt(value, 10));
        }, 'Please enter a non zero integer value!');
        //check children
        /*
        jQuery('select[name=\'have_children\']').on('change', function() {
            if (this.value == 'Yes')
            {
                jQuery('#childrenDiv').html('<span class="ginput_right address_state" id="input_1_2_4_container"><input id="no_of_children" name="no_of_children" type="text" class="required" tabindex="6" value="1"> <label for="no_of_children" id="input_1_2_4_label">Number of Children <span class="starred">*</span></label></span>')
            }
            if (this.value == 'no') {
                jQuery('#childrenDiv').html('')
            }
        });
        jQuery('select[name=\'have_children\']').trigger('change');*/
    });
    function getMarriedStatus() {
        return jQuery("#married_status").val();
    }
    function getHaveChildren() {
        return jQuery("#have_children").val();
    }
    function immigrateTo(country) {
        if (country) {
            var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: "action=immigrate_to_other&immigrateTo=" + country + "&" + jQuery("#member_registration_form").serialize(),
                success: function(data) {
                    if (data) {
                        jQuery('#eligibilityCheckResult').html('<b>Thank you.</b><br/><p>An immigration expert will contact you soon</p>');
                    }
                }
            });
        }
    }
</script>

    <?php $thumb = ( '' != get_the_post_thumbnail() ) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'purpose-featured-large') : false; ?>

<div <?php post_class(); ?> id="page-<?php the_ID(); ?>">
        <?php if ('' != get_the_post_thumbnail()) { ?>
        <div class="feature-img page-banner" <?php if (!empty($thumb)) { ?> style="background-image: url(<?php echo $thumb[0]; ?>);" <?php } ?>>
            <h1 class="headline img-headline"><?php the_title(); ?></h1>
    <?php the_post_thumbnail('purpose-featured-large'); ?>
        </div>
<?php } ?>

    <div class="row">
        <div class="content<?php if (empty($thumb)) { ?> no-thumb<?php } ?>">

            <!-- BEGIN .sixteen columns -->
            <div class="sixteen columns">
                <!-- BEGIN .postarea full -->
                <div class="postarea member_registration_form clearfix">

<?php if (!has_post_thumbnail()) { ?>
                        <h1 class="headline"><?php the_title(); ?></h1>
<?php } ?>
                    <div class="article">
                        <div class="gf_browser_chrome gform_wrapper" id="gform_wrapper_1">
                            <form style="" action="" id="member_registration_form" name="member_registration_form" enctype="multipart/form-data" method="post" role="application" class="wizard clearfix">
                                <input type="hidden" id="registrationSuccessStatus" value="0">
                                <h3>Personal Information</h3>
                                <fieldset>
                                    <div class="gform_body">
                                        <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below">  
                                            <li id="field_1_1" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="input_1_1_3">Personal Information</label>
                                                <div class="ginput_complex ginput_container no_prefix has_first_name no_middle_name has_last_name no_suffix gf_name_has_2 ginput_container_name" id="input_1_1">
                                                    <span id="input_1_1_3_container" class="name_first">
                                                        <input type="text" name="first_name" id="first_name"  aria-label="First name" tabindex="1" class="required">
                                                        <label for="first_name">First Name<span class="starred">*</span></label>
                                                    </span>
                                                    <span id="input_1_1_6_container" class="name_last">
                                                        <input type="text" name="last_name" id="last_name"  aria-label="Last name" tabindex="2" class="required">
                                                        <label for="last_name">Last Name<span class="starred">*</span></label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 

                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="input_1_2_1">Address</label>    
                                                <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="required" name="birth_country" id="birth_country" tabindex="3">
                                                            <option value="">Select Birth Country</option>
                                                            <?php
                                                                if($countries = getCountryList()){
                                                                    foreach($countries as $coutnry){
                                                                        echo '<option value="'.$coutnry.'">'.$coutnry.'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <label for="birth_country" id="input_1_2_5_label">Birth Country <span class="starred">*</span></label>
                                                    </span>
                                                    <span class="ginput_right address_country" id="input_1_2_6_container">
                                                        <select class="required" name="education_level" id="education_level" tabindex="4">
                                                            <option value="">Education Level</option>
                                                            <?php
                                                            if($educations = getEducationLevelList()){
                                                                foreach($educations as $education){
                                                                    echo '<option value="'.$education.'">'.$education.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="education_level" id="input_1_2_6_label">Education Level <span class="starred">*</span></label>
                                                    </span>


                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="required" name="country_of_residence" id="country_of_residence" tabindex="5">
                                                            <option value="">Select Residence Country</option>
                                                            <?php
                                                            if($countries = getCountryList()){
                                                                foreach($countries as $coutnry){
                                                                    echo '<option value="'.$coutnry.'">'.$coutnry.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="country_of_residence" id="input_1_2_5_label">Country of Residence <span class="starred">*</span></label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <input id="email" name="email" type="email" class="required email" tabindex="6">
                                                        <label for="input_1_2_4" id="input_1_2_4_label">Email <span class="starred">*</span></label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li>

                                            <li id="field_1_3" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="phone">Phone <span class="starred">*</span></label>
                                                <div class="ginput_container ginput_container_phone">
                                                    <input id="phone_code" name="phone_code" type="text" class="required medium" tabindex="7" style="width: 75px;float: left;margin-right: 5px">
                                                    <input id="phone" name="phone" type="text" class="required medium" tabindex="7" style="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </fieldset>

                                <h3>Profile</h3>
                                <fieldset>
                                    <div class="gform_body">
                                        <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below">
                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="input_1_2_1">Profile</label>    
                                                <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="required married_status" name="married_status" id="married_status" tabindex="1">
                                                            <option value="">Select Marital Status</option>
                                                            <?php
                                                            if($maritalStatus = getMaritalStatusList()){
                                                                foreach($maritalStatus as $status){
                                                                    echo '<option value="'.$status.'">'.$status.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="married_status" id="input_1_2_5_label">Marital Status <span class="starred">*</span></label>
                                                    </span>
                                                    <span class="ginput_right address_country" id="input_1_2_6_container">

                                                        <select class="required occupation" name="occupation" id="occupation" tabindex="2">
                                                            <option value="">Select Occupation</option>
                                                            <?php
                                                            if($occupations = getOccupationList()){
                                                                foreach($occupations as $occupation){
                                                                    echo '<option value="'.$occupation.'">'.$occupation.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <label for="occupation" id="input_1_2_6_label">Occupation <span class="starred">*</span></label>
                                                    </span>


                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                         <select class="required" name="annual_income" id="annual_income" tabindex="3">
                                                             <option value="">Select Annual Income</option>
                                                             <?php
                                                             if($incomes = getAnnualIncomeList()){
                                                                 foreach($incomes as $income){
                                                                     echo '<option value="'.$income.'">'.$income.'</option>';
                                                                 }
                                                             }
                                                             ?>
                                                         </select>
                                                        <label for="annual_income" id="input_1_2_5_label">Annual Income <span class="starred">*</span></label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <input id="work_experience" name="work_experience" type="text" class="required" tabindex="4">
                                                        <label for="work_experience" id="input_1_2_4_label">Work experience <span class="starred">*</span></label>
                                                    </span>

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">

                                                        <select id="been_to_usa" name="been_to_usa" class="required" tabindex="5">
                                                            <option value="">Select</option> 
                                                            <option value="Yes">Yes</option> 
                                                            <option value="No">No</option> 
                                                        </select>
                                                        <label for="been_to_usa" id="input_1_2_5_label">Been to USA <span class="starred">*</span></label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                         <select id="purpose_of_appliying" name="purpose_of_appliying" class="required" tabindex="6">
                                                            <option value="">Select</option> 
                                                            <?php
                                                            if($purpose = getPurposeForApplyingList()){
                                                                foreach($purpose as $purposeItem){
                                                                    echo '<option value="'.$purposeItem.'">'.$purposeItem.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="purpose_of_appliying" id="input_1_2_4_label">Purpose of applying <span class="starred">*</span></label>
                                                    </span>


                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 

                                        </ul>
                                    </div>
                                </fieldset>

                                <h3>Spouse details</h3>
                                <fieldset>

                                    <div class="gform_body">
                                        <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below"> 


                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="input_1_2_1">Spouse Details <span class="starred">*</span></label>    
                                                <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">
                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="required" name="spouse_birth_country" id="spouse_birth_country" tabindex="3">
                                                            <option value="">Select Spouse Birth Country</option>
                                                            <option value="Afghanistan">Afghanistan</option>
                                                            <option value="Albania">Albania</option>
                                                            <option value="Algeria">Algeria</option>
                                                            <option value="American Samoa">American Samoa</option>
                                                            <option value="Andorra">Andorra</option>
                                                            <option value="Angola">Angola</option>
                                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                            <option value="Argentina">Argentina</option>
                                                            <option value="Armenia">Armenia</option>
                                                            <option value="Australia">Australia</option>
                                                            <option value="Austria">Austria</option>
                                                            <option value="Azerbaijan">Azerbaijan</option>
                                                            <option value="Bahamas">Bahamas</option>
                                                            <option value="Bahrain">Bahrain</option>
                                                            <option value="Bangladesh">Bangladesh</option>
                                                            <option value="Barbados">Barbados</option>
                                                            <option value="Belarus">Belarus</option>
                                                            <option value="Belgium">Belgium</option>
                                                            <option value="Belize">Belize</option>
                                                            <option value="Benin">Benin</option>
                                                            <option value="Bermuda">Bermuda</option>
                                                            <option value="Bhutan">Bhutan</option>
                                                            <option value="Bolivia">Bolivia</option>
                                                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                            <option value="Botswana">Botswana</option>
                                                            <option value="Brazil">Brazil</option>
                                                            <option value="Brunei">Brunei</option>
                                                            <option value="Bulgaria">Bulgaria</option>
                                                            <option value="Burkina Faso">Burkina Faso</option>
                                                            <option value="Burundi">Burundi</option>
                                                            <option value="Cambodia">Cambodia</option>
                                                            <option value="Cameroon">Cameroon</option>
                                                            <option value="Canada">Canada</option>
                                                            <option value="Cape Verde">Cape Verde</option>
                                                            <option value="Cayman Islands">Cayman Islands</option>
                                                            <option value="Central African Republic">Central African Republic</option>
                                                            <option value="Chad">Chad</option>
                                                            <option value="Chile">Chile</option>
                                                            <option value="China">China</option>
                                                            <option value="Colombia">Colombia</option>
                                                            <option value="Comoros">Comoros</option>
                                                            <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>
                                                            <option value="Congo, Republic of the">Congo, Republic of the</option>
                                                            <option value="Costa Rica">Costa Rica</option>
                                                            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                                            <option value="Croatia">Croatia</option>
                                                            <option value="Cuba">Cuba</option>
                                                            <option value="Cyprus">Cyprus</option>
                                                            <option value="Czech Republic">Czech Republic</option>
                                                            <option value="Denmark">Denmark</option>
                                                            <option value="Djibouti">Djibouti</option>
                                                            <option value="Dominica">Dominica</option>
                                                            <option value="Dominican Republic">Dominican Republic</option>
                                                            <option value="East Timor">East Timor</option>
                                                            <option value="Ecuador">Ecuador</option>
                                                            <option value="Egypt">Egypt</option>
                                                            <option value="El Salvador">El Salvador</option>
                                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                            <option value="Eritrea">Eritrea</option>
                                                            <option value="Estonia">Estonia</option>
                                                            <option value="Ethiopia">Ethiopia</option>
                                                            <option value="Faroe Islands">Faroe Islands</option>
                                                            <option value="Fiji">Fiji</option>
                                                            <option value="Finland">Finland</option>
                                                            <option value="France">France</option>
                                                            <option value="French Polynesia">French Polynesia</option>
                                                            <option value="Gabon">Gabon</option>
                                                            <option value="Gambia">Gambia</option>
                                                            <option value="Georgia">Georgia</option>
                                                            <option value="Germany">Germany</option>
                                                            <option value="Ghana">Ghana</option>
                                                            <option value="Greece">Greece</option>
                                                            <option value="Greenland">Greenland</option>
                                                            <option value="Grenada">Grenada</option>
                                                            <option value="Guam">Guam</option>
                                                            <option value="Guatemala">Guatemala</option>
                                                            <option value="Guinea">Guinea</option>
                                                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                            <option value="Guyana">Guyana</option>
                                                            <option value="Haiti">Haiti</option>
                                                            <option value="Honduras">Honduras</option>
                                                            <option value="Hong Kong">Hong Kong</option>
                                                            <option value="Hungary">Hungary</option>
                                                            <option value="Iceland">Iceland</option>
                                                            <option value="India">India</option>
                                                            <option value="Indonesia">Indonesia</option>
                                                            <option value="Iran">Iran</option>
                                                            <option value="Iraq">Iraq</option>
                                                            <option value="Ireland">Ireland</option>
                                                            <option value="Israel">Israel</option>
                                                            <option value="Italy">Italy</option>
                                                            <option value="Jamaica">Jamaica</option>
                                                            <option value="Japan">Japan</option>
                                                            <option value="Jordan">Jordan</option>
                                                            <option value="Kazakhstan">Kazakhstan</option>
                                                            <option value="Kenya">Kenya</option>
                                                            <option value="Kiribati">Kiribati</option>
                                                            <option value="North Korea">North Korea</option>
                                                            <option value="South Korea">South Korea</option>
                                                            <option value="Kosovo">Kosovo</option>
                                                            <option value="Kuwait">Kuwait</option>
                                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                            <option value="Laos">Laos</option>
                                                            <option value="Latvia">Latvia</option>
                                                            <option value="Lebanon">Lebanon</option>
                                                            <option value="Lesotho">Lesotho</option>
                                                            <option value="Liberia">Liberia</option>
                                                            <option value="Libya">Libya</option>
                                                            <option value="Liechtenstein">Liechtenstein</option>
                                                            <option value="Lithuania">Lithuania</option>
                                                            <option value="Luxembourg">Luxembourg</option>
                                                            <option value="Macedonia">Macedonia</option>
                                                            <option value="Madagascar">Madagascar</option>
                                                            <option value="Malawi">Malawi</option>
                                                            <option value="Malaysia">Malaysia</option>
                                                            <option value="Maldives">Maldives</option>
                                                            <option value="Mali">Mali</option>
                                                            <option value="Malta">Malta</option>
                                                            <option value="Marshall Islands">Marshall Islands</option>
                                                            <option value="Mauritania">Mauritania</option>
                                                            <option value="Mauritius">Mauritius</option>
                                                            <option value="Mexico">Mexico</option>
                                                            <option value="Micronesia">Micronesia</option>
                                                            <option value="Moldova">Moldova</option>
                                                            <option value="Monaco">Monaco</option>
                                                            <option value="Mongolia">Mongolia</option>
                                                            <option value="Montenegro">Montenegro</option>
                                                            <option value="Morocco">Morocco</option>
                                                            <option value="Mozambique">Mozambique</option>
                                                            <option value="Myanmar">Myanmar</option>
                                                            <option value="Namibia">Namibia</option>
                                                            <option value="Nauru">Nauru</option>
                                                            <option value="Nepal">Nepal</option>
                                                            <option value="Netherlands">Netherlands</option>
                                                            <option value="New Zealand">New Zealand</option>
                                                            <option value="Nicaragua">Nicaragua</option>
                                                            <option value="Niger">Niger</option>
                                                            <option value="Nigeria">Nigeria</option>
                                                            <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                            <option value="Norway">Norway</option>
                                                            <option value="Oman">Oman</option>
                                                            <option value="Pakistan">Pakistan</option>
                                                            <option value="Palau">Palau</option>
                                                            <option value="Palestine, State of">Palestine, State of</option>
                                                            <option value="Panama">Panama</option>
                                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                                            <option value="Paraguay">Paraguay</option>
                                                            <option value="Peru">Peru</option>
                                                            <option value="Philippines">Philippines</option>
                                                            <option value="Poland">Poland</option>
                                                            <option value="Portugal">Portugal</option>
                                                            <option value="Puerto Rico">Puerto Rico</option>
                                                            <option value="Qatar">Qatar</option>
                                                            <option value="Romania">Romania</option>
                                                            <option value="Russia">Russia</option>
                                                            <option value="Rwanda">Rwanda</option>
                                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                            <option value="Saint Lucia">Saint Lucia</option>
                                                            <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
                                                            <option value="Samoa">Samoa</option>
                                                            <option value="San Marino">San Marino</option>
                                                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                                            <option value="Senegal">Senegal</option>
                                                            <option value="Serbia">Serbia</option>
                                                            <option value="Seychelles">Seychelles</option>
                                                            <option value="Sierra Leone">Sierra Leone</option>
                                                            <option value="Singapore">Singapore</option>
                                                            <option value="Sint Maarten">Sint Maarten</option>
                                                            <option value="Slovakia">Slovakia</option>
                                                            <option value="Slovenia">Slovenia</option>
                                                            <option value="Solomon Islands">Solomon Islands</option>
                                                            <option value="Somalia">Somalia</option>
                                                            <option value="South Africa">South Africa</option>
                                                            <option value="Spain">Spain</option>
                                                            <option value="Sri Lanka">Sri Lanka</option>
                                                            <option value="Sudan">Sudan</option>
                                                            <option value="Sudan, South">Sudan, South</option>
                                                            <option value="Suriname">Suriname</option>
                                                            <option value="Swaziland">Swaziland</option>
                                                            <option value="Sweden">Sweden</option>
                                                            <option value="Switzerland">Switzerland</option>
                                                            <option value="Syria">Syria</option>
                                                            <option value="Taiwan">Taiwan</option>
                                                            <option value="Tajikistan">Tajikistan</option>
                                                            <option value="Tanzania">Tanzania</option>
                                                            <option value="Thailand">Thailand</option>
                                                            <option value="Togo">Togo</option>
                                                            <option value="Tonga">Tonga</option>
                                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                            <option value="Tunisia">Tunisia</option>
                                                            <option value="Turkey">Turkey</option>
                                                            <option value="Turkmenistan">Turkmenistan</option>
                                                            <option value="Tuvalu">Tuvalu</option>
                                                            <option value="Uganda">Uganda</option>
                                                            <option value="Ukraine">Ukraine</option>
                                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                                            <option value="United Kingdom">United Kingdom</option>
                                                            <option value="United States">United States</option>
                                                            <option value="Uruguay">Uruguay</option>
                                                            <option value="Uzbekistan">Uzbekistan</option>
                                                            <option value="Vanuatu">Vanuatu</option>
                                                            <option value="Vatican City">Vatican City</option>
                                                            <option value="Venezuela">Venezuela</option>
                                                            <option value="Vietnam">Vietnam</option>
                                                            <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                            <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                            <option value="Yemen">Yemen</option>
                                                            <option value="Zambia">Zambia</option>
                                                            <option value="Zimbabwe">Zimbabwe</option>
                                                        </select>
                                                        <label for="spouse_birth_country" id="input_1_2_5_label">Spouse Birth Country <span class="starred">*</span></label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <select class="required" name="spouse_education_level" id="spouse_education_level" tabindex="4">
                                                            <option value="">Select Spouse Education Level</option>
                                                            <?php
                                                            if($educations = getEducationLevelList()){
                                                                foreach($educations as $education){
                                                                    echo '<option value="'.$education.'">'.$education.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <label for="spouse_education_level" id="input_1_2_4_label">Spouse Education Level <span class="starred">*</span></label>
                                                    </span>

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="required" name="have_children" id="have_children" tabindex="5">
                                                            <option value="no">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                        <label for="have_children" id="input_1_2_5_label">Have children <span class="starred">*</span></label>
                                                    </span>
                                                    <div id="childrenDiv">
                                                        <span class="ginput_right address_state" id="input_1_2_4_container"><input id="no_of_children" name="no_of_children" type="text" class="" tabindex="6" value="">
                                                            <label for="no_of_children" id="input_1_2_4_label">Number of Children <span class="starred">*</span></label></span>
                                                    </div>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 
                                        </ul>
                                    </div>
                                </fieldset>

                                <h3>Contact Details</h3>
                                <fieldset>

                                    <div class="gform_body">
                                        <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below"> 


                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="input_1_2_1">Contact Details *</label>    
                                                <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">
                                                    <input id="address1" name="address1" type="hidden" value="address1" class="required" tabindex="1">
                                                    <input id="address2" name="address2" type="hidden" value="address2" class="required" tabindex="2">
                                                    <!--<span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <input id="address1" name="address1" type="text" class="required" tabindex="1">
                                                        <label for="address1" id="input_1_2_5_label">Address1 *</label>
                                                    </span>
                                                    <span class="ginput_right address_country" id="input_1_2_6_container">
                                                        <input id="address2" name="address2" type="text" class="required" tabindex="2">
                                                        <label for="address2" id="input_1_2_6_label">Address2 *</label>
                                                    </span>-->

                                                    <div id="locationField">
                                                        <input id="autocomplete" placeholder="Enter your address" name="address" onfocus="geolocate()" type="text" autocomplete="off">
                                                    </div>

                                                    <table id="address">
                                                        <tr>
                                                            <td class="label">Street address</td>
                                                            <td class="slimField">
                                                                <input class="field" id="street_number" type="text" name="street_number" /></td>
                                                            <td class="wideField" colspan="2">
                                                                <input class="field" id="route" name="route" type="text"  /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">City</td>
                                                            <td class="wideField" colspan="3">
                                                                <input class="field" id="locality" name="locality" type="text"   /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">State</td>
                                                            <td class="slimField"><input class="field" id="administrative_area_level_1" name="administrative_area_level_1" type="text"  /></td>
                                                            <td class="label">Zip code</td>
                                                            <td class="wideField">
                                                                <input class="field" id="postal_code" name="postal_code" type="text"  /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Country</td>
                                                            <td class="wideField" colspan="3">
                                                                <input class="field" id="country" type="text" name="country"  /></td>
                                                        </tr>
                                                    </table>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <input id="additional_phone" name="additional_phone" type="text" class="required" tabindex="6">
                                                        <label for="additional_phone" id="input_1_2_4_label">Additional Phone <span class="starred">*</span></label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 
                                        </ul>
                                    </div>

                                </fieldset>

                                <h3>Eligibility Check</h3>

                                <fieldset>
                                    <div id="eligibilityCheckResult">
                                        <b>Checking your eligibility, it take couple of minute.</b><br/>
                                        <b>Please wait.</b>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" alt="Loading...">
                                    </div>
                                </fieldset>

                            </form>
                            <div style="display: none">
                                <form action='https://sandbox.2checkout.com/checkout/purchase' method='post' id="paymentForm">
                                    <input type='hidden' name='sid' value='901299300' />
                                    <input type='hidden' name='mode' value='2CO' />
                                    <input type='hidden' name='li_0_type' value='product' />
                                    <input type='hidden' name='li_0_name' value='US Diversity Visa' />
                                    <input type='hidden' name='li_0_description' value='US Diversity Visa' />
                                    <input type='hidden' name='currency_code' value='USD' />
                                    <input type='hidden' name='li_0_price' value='5.00' />
                                    <input type='hidden' name='mrid' value='' id="mrid" />
                                    <input type='hidden' name='merchant_order_id' value='' id="merchant_order_id" />
                                    <input name='submit' type='submit' value='Checkout' id="goToPaymentPage" />
                                </form>
                            </div>
                        </div>
                        <!-- END .postarea full -->
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- END .sixteen columns -->
            </div>

        </div>

    </div>
</div>
<?php get_footer();?>
<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    // [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
    }
    // [END region_fillform]

    // [START region_geolocation]
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
    // [END region_geolocation]

</script>
<script defer="" async="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDirXLoeVhtPfLdOqhqY2W6fbdn1blRThM&signed_in=true&libraries=places&callback=initAutocomplete"></script>
