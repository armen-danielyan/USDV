<?php
/**
 * Template Name: Member Profile
 */
get_header('client');
global $wpdb;

//check login
$user_id = get_current_user_id();
if ($user_id == 0) {?>
    <script>
        window.location = "<?php echo esc_url(home_url('/')); ?>"; //redirect if email exists
    </script>
    <?php
}

$user = new WP_User($user_id);
?>
<style type="text/css">
		.sidebar{padding-bottom: 0px;}
    </style>
<script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.steps.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.validate.min.js" type="text/javascript"></script>
<script>
    jQuery(function() {
        var form = jQuery("#member_registration_form").show();
        form.steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slideLeft",
            enableAllSteps: true,
            titleTemplate: '<span class="number">#index#</span><span class="headingTitle">#title#</span>',
            /* Labels */
            labels: {
                current: "",
                previous: "Back",
                finish: "Update",
                next: "Update & Go To Step 2",
                loading: "Loading ..."
            },
            onStepChanging: function(event, currentIndex, newIndex)
            {
                //disabled done step
                //jQuery('.steps').find('.done').addClass('disabled');

                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                //check email already exist in system
                if (newIndex === 1)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-3').hide();
                    jQuery('#member_registration_form-p-4').hide();

                    var email = jQuery('#email').val();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    if (email) {
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&update=1&step=1&" + jQuery("#member_registration_form").serialize(),
                            success: function(data) {
                                if (data == 'exists') {
                                    window.location = "<?php echo esc_url(home_url('/')); ?>"; //redirect if email exists
                                    return false;
                                } else if (data == 'added') {
                                    jQuery('#registrationSuccessStatus').val(1);
                                }
                            }
                        });
                    }
                }

                //check email already exist in system
                if (newIndex === 2)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-3').hide();
                    jQuery('#member_registration_form-p-4').hide();

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
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-4').hide();

                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    if (jQuery("#have_children").val()) {
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&step=3&" + jQuery("#member_registration_form").serialize(),
                            success: function(data) {
                            }
                        });
                    }
                }
                if (newIndex === 4)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-3').hide();
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                   // if (jQuery("#autocomplete").val()) {
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&step=4&" + jQuery("#member_registration_form").serialize(),
                            success: function(data) {
                                jQuery('#childDetailsDiv').html(data);
                            }
                        });
                   // }
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
                return form.valid();
            },
            onStepChanged: function(event, currentIndex, priorIndex)
            {
                //disabled done step
                //jQuery('.steps').find('.done').addClass('disabled');

                //remove done step
                jQuery('.steps').find('.done').removeClass('done');
                if (currentIndex) {
                    for (var i = 0; i < currentIndex; i++) {
                        jQuery('#member_registration_form-p-'+(currentIndex+1)).hide();
                        jQuery('#member_registration_form-t-'+i).parent().addClass('done');
                    }
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 0)
                {
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-3').hide();
                    jQuery('#member_registration_form-p-4').hide();

                    jQuery("a[href^='#next']").text('Update & Go To Step 2');
                }
                if (currentIndex === 1)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-4').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-3').hide();

                    jQuery("a[href^='#next']").text('Update & Go To Step 3');
                }

                if (currentIndex === 2)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-4').hide();
                    jQuery('#member_registration_form-p-3').hide();

                    jQuery("a[href^='#next']").text('Update & Go To Step 4');

                    jQuery('#have_children').on('change', function() {
                       if ((jQuery("#married_status").val() == 'Married') && jQuery('#have_children').val() == 'Yes')
                        {
                            //jQuery('#no_of_children').addClass("required");
                            jQuery('#no_of_children').val('');
                            jQuery('#no_of_children').prop("readonly", false);
                        }
                        if (this.value == 'no') {
                           // jQuery('#no_of_children').removeClass("required");
                            jQuery('#no_of_children').val(0);
                            jQuery('#no_of_children').prop("readonly", true);
                        }
                    });
                   // jQuery('#have_children').trigger('change');
                }

                if (currentIndex === 3)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-4').hide();

                    jQuery("a[href^='#next']").text('Update');
                }

                if (currentIndex === 2 && priorIndex === 3)
                {
                 //   jQuery(this).steps("previous");
                   // return;
                }

                if (currentIndex === 4)
                {
                    jQuery('#member_registration_form-p-0').hide();
                    jQuery('#member_registration_form-p-1').hide();
                    jQuery('#member_registration_form-p-2').hide();
                    jQuery('#member_registration_form-p-3').hide();
                }

                //jQuery("input[name='married_status']:checked")
                if (currentIndex == 2 && (jQuery("#married_status").val() != 'Married'))
                {
                    jQuery(".body:eq(" + currentIndex + ") .required", form).removeClass("required");
                    form.steps("next");
                }
                if (currentIndex === 2 && (jQuery("#married_status").val() == 'Married'))
                {
                   // jQuery(".body:eq(" + currentIndex + ") .married-details", form).addClass("required");
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
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    if ((jQuery("#married_status").val() == 'Married')) {
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: "action=user_registration_form&step=5&childUpdate=1&" + jQuery("#member_registration_form").serialize(),
                            success: function(data) {
                                //jQuery('#childDetailsDiv').html(data);
                                alert('Update successfully.');
                            }
                        });
                    }
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
                        if(getMarriedStatus() == 'Married'){
                            return true;
                        }
                    }*/
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
            if(value){
                return (value != 0) && (value == parseInt(value, 10));
            }else{
                return true;
            }
        }, 'Please enter a non zero integer value!');

        function getMarriedStatus() {
            return jQuery("#married_status").val();
        }
        function getHaveChildren() {
            return jQuery("#have_children").val();
        }

        //check step a click
        jQuery('.steps ul li a').click(function(){
            jQuery('#member_registration_form-p-0').hide();
            jQuery('#member_registration_form-p-1').hide();
            jQuery('#member_registration_form-p-2').hide();
            jQuery('#member_registration_form-p-3').hide();
            jQuery('#member_registration_form-p-4').hide();

            var currentItem = jQuery(this).attr('aria-controls');
            jQuery('#'+currentItem).show();

        });

    });

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
            <!-- BEGIN .three columns -->
            <div class="three columns">
                <?php get_sidebar('member'); ?>
                <!-- END .three columns -->
            </div>

            <!-- BEGIN .sixteen columns -->
            <div class="thirteen columns">
                <!--lang swicher-->
                <?php get_sidebar('language'); ?>
                <!-- BEGIN .postarea full -->
                <div class="postarea right member_registration_form clearfix profileContent">

<?php if (!has_post_thumbnail()) { ?>
                        <h1 class="headline"><?php the_title(); ?></h1>
<?php } ?>
                    <div class="blog-holder">
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
                                                        <input type="text" name="first_name" id="first_name" value="<?php echo get_user_meta($user_id, 'first_name', true); ?>"  aria-label="First name" tabindex="1" class="">
                                                        <label for="first_name">First Name*</label>
                                                    </span>
                                                    <span id="input_1_1_6_container" class="name_last">
                                                        <input type="text" name="last_name" id="last_name" value="<?php echo get_user_meta($user_id, 'last_name', true); ?>" aria-label="Last name" tabindex="2" class="">
                                                        <label for="last_name">Last Name*</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 

                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="input_1_2_1">Address</label>    
                                                <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="" name="birth_country" id="birth_country" tabindex="3">
                                                            <option value="">Select Birth Country</option>
                                                            <?php
                                                            if($countries = getCountryList()){
                                                                $birth_country = get_user_meta($user_id, 'birth_country', true);
                                                                foreach($countries as $coutnry){
                                                                    $selected = $birth_country == $coutnry ? 'selected' : '';
                                                                    echo '<option value="'.$coutnry.'" '.$selected.'>'.$coutnry.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="birth_country" id="input_1_2_5_label">Birth Country *</label>
                                                    </span>
                                                    <span class="ginput_right address_country" id="input_1_2_6_container">
                                                <?php $education_level = get_user_meta($user_id, 'education_level', true); ?>
                                                        <select class="" name="education_level" id="education_level" tabindex="4">
                                                            <option value="">Education Level</option>
                                                            <?php
                                                            if($educations = getEducationLevelList()){
                                                                $education_level = get_user_meta($user_id, 'education_level', true);
                                                                foreach($educations as $education){
                                                                    $selected = $education_level == $education ? 'selected' : '';
                                                                    echo '<option value="'.$education.'" '.$selected.'>'.$education.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="education_level" id="input_1_2_6_label">Education Level *</label>
                                                    </span>


                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="" name="country_of_residence" id="country_of_residence" tabindex="5">
                                                            <option value="">Select Residence Country</option>
                                                            <?php
                                                            if($countries = getCountryList()){
                                                                $country_of_residence = get_user_meta($user_id, 'country_of_residence', true);
                                                                foreach($countries as $coutnry){
                                                                    $selected = $country_of_residence == $coutnry ? 'selected' : '';
                                                                    echo '<option value="'.$coutnry.'" '.$selected.'>'.$coutnry.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="country_of_residence" id="input_1_2_5_label">Country of Residence *</label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <?php echo $user->user_email; ?>
                                                        <input id="email" name="email" type="hidden" value="<?php echo $user->user_email; ?>"readonly>
                                                        <label for="input_1_2_4" id="input_1_2_4_label">Email *</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li>

                                            <li id="field_1_3" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="phone">Phone *</label>
                                                <div class="ginput_container ginput_container_phone">
                                                    <input id="phone_code" name="phone_code" type="text" class="required medium" tabindex="7" value="<?php echo get_user_meta($user_id, 'phone_code', true); ?>" style="width: 75px;float: left;margin-right: 5px">
                                                    <input id="phone" name="phone" type="text" class="required medium" tabindex="7" style="" value="<?php echo get_user_meta($user_id, 'phone', true); ?>">
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
                                                        <select class="married_status" name="married_status" id="married_status" tabindex="1">
                                                            <option value="">Select Marital Status</option>
                                                            <?php
                                                            if($maritalStatus = getMaritalStatusList()){
                                                               $married_status = get_user_meta($user_id, 'married_status', true);
                                                                foreach($maritalStatus as $status){
                                                                    $selected = $married_status == $status ? 'selected' : '';
                                                                    echo '<option value="'.$status.'" '.$selected.'>'.$status.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="married_status" id="input_1_2_5_label">Marital Status *</label>
                                                    </span>
                                                    <span class="ginput_right address_country" id="input_1_2_6_container">

                                                        <select class="occupation" name="occupation" id="occupation" tabindex="2">
                                                            <option value="">Select Occupation</option>
                                                            <?php
                                                            if($occupations = getOccupationList()){
                                                               $m_occupation = get_user_meta($user_id, 'occupation', true);
                                                                foreach($occupations as $occupation){
                                                                    $selected = $m_occupation == $occupation ? 'selected' : '';
                                                                    echo '<option value="'.$occupation.'" '.$selected.'>'.$occupation.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <label for="occupation" id="input_1_2_6_label">Occupation *</label>
                                                    </span>


                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                       <select class="" name="annual_income" id="annual_income" tabindex="3">
                                                           <option value="">Select Annual Income</option>
                                                           <?php
                                                           if($incomes = getAnnualIncomeList()){
                                                              $annual_income =  get_user_meta($user_id, 'annual_income', true);
                                                               foreach($incomes as $income){
                                                                   $selected = $annual_income == $income ? 'selected' : '';
                                                                   echo '<option value="'.$income.'" '.$selected.'>'.$income.'</option>';
                                                               }
                                                           }
                                                           ?>
                                                       </select>
                                                        <label for="annual_income" id="input_1_2_5_label">Annual Income *</label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <select class="required" name="work_experience" id="work_experience" tabindex="4">
                                                            <option value="">Select Work Exp</option>
                                                            <?php
                                                            if($experiences = getWorkExperienceList()){
                                                                $work_experience =  get_user_meta($user_id, 'work_experience', true);
                                                                foreach($experiences as $experience){
                                                                    $selected = $work_experience == $experience ? 'selected' : '';
                                                                    echo '<option value="'.$experience.'" '.$selected.'>'.$experience.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="work_experience" id="input_1_2_4_label">Work experience *</label>
                                                    </span>

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select id="been_to_usa" name="been_to_usa" class="" tabindex="5">
                                                           <option value="">Select</option> 
                                                           <option value="Yes" <?php echo get_user_meta($user_id, 'been_to_usa', true) == 'Yes' ? 'selected' : ''; ?>>Yes</option> 
                                                           <option value="No" <?php echo get_user_meta($user_id, 'been_to_usa', true) == 'No' ? 'selected' : ''; ?>>No</option> 
                                                       </select>
                                                        <label for="been_to_usa" id="input_1_2_5_label">Been to USA *</label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <select id="purpose_of_appliying" name="purpose_of_appliying" class="required" tabindex="6">
                                                            <option value="">Select</option> 
                                                            <?php
                                                            if($purpose = getPurposeForApplyingList()){
                                                                $purpose_of_appliying = get_user_meta($user_id, 'purpose_of_appliying', true);
                                                                foreach($purpose as $purposeItem){
                                                                    $selected = $purpose_of_appliying == $purposeItem ? 'selected' : '';
                                                                    echo '<option value="'.$purposeItem.'" '.$selected.'>'.$purposeItem.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="purpose_of_appliying" id="input_1_2_4_label">Purpose of applying *</label>
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
                                                <label class="gfield_label" for="input_1_2_1">Spouse Details *</label>    
                                                <div class="ginput_complex ginput_container has_street has_street2 has_city has_state has_zip has_country ginput_container_address" id="input_1_2">
                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="" name="spouse_birth_country" id="spouse_birth_country" tabindex="3">
                                                            <option value="">Select Spouse Birth Country</option>
                                                            <?php
                                                            if($countries = getCountryList()){
                                                                $spouse_birth_country = get_user_meta($user_id, 'spouse_birth_country', true);
                                                                foreach($countries as $coutnry){
                                                                    $selected = $spouse_birth_country == $coutnry ? 'selected' : '';
                                                                    echo '<option value="'.$coutnry.'" '.$selected.'>'.$coutnry.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="spouse_birth_country" id="input_1_2_5_label">Spouse Birth Country *</label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <select class="" name="spouse_education_level" id="spouse_education_level" tabindex="4">
                                                            <option value="">Select Spouse Education Level</option>
                                                            <?php
                                                            if($educations = getEducationLevelList()){
                                                                $spouse_education_level = get_user_meta($user_id, 'spouse_education_level', true);
                                                                foreach($educations as $education){
                                                                    $selected = $spouse_education_level == $education ? 'selected' : '';
                                                                    echo '<option value="'.$education.'" '.$selected.'>'.$education.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <label for="spouse_education_level" id="input_1_2_4_label">Spouse Education Level *</label>
                                                    </span>

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <?php $have_children = get_user_meta($user_id, 'have_children', true); ?>
                                                        <select class="" name="have_children" id="have_children" tabindex="5">
                                                            <option value="no" <?php echo $have_children == 'no' ? 'selected' : ''; ?>>No</option>
                                                            <option value="Yes" <?php echo $have_children == 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                                        </select>
                                                        <label for="have_children" id="input_1_2_5_label">Have children *</label>
                                                    </span>
                                                    <div id="childrenDiv">
                                                        <span class="ginput_right address_state" id="input_1_2_4_container">
                                                            <input id="no_of_children" name="no_of_children" type="text" class="" tabindex="6" value="<?php echo get_user_meta($user_id, 'no_of_children', true); ?>">
                                                            <label for="no_of_children" id="input_1_2_4_label">Number of Children *</label>
                                                        </span>
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
                                                     <input id="address1" name="address1" type="hidden" class="" tabindex="1" value="address1">
                                                     <input id="address2" name="address2" type="hidden" class="" tabindex="2" value="address2">
                                                   <!-- <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <input id="address1" name="address1" type="text" class="required" tabindex="1" value="<?php //echo get_user_meta($user_id, 'address1', true); ?>">
                                                        <label for="address1" id="input_1_2_5_label">Address1 *</label>
                                                    </span>
                                                    <span class="ginput_right address_country" id="input_1_2_6_container">
                                                        <input id="address2" name="address2" type="text" class="required" tabindex="2" value="<?php //echo get_user_meta($user_id, 'address2', true); ?>">
                                                        <label for="address2" id="input_1_2_6_label">Address2 *</label>
                                                    </span>-->

                                                    <div id="locationField">
                                                        <input id="autocomplete" placeholder="Enter your address" name="address" onfocus="geolocate()" type="text" autocomplete="off" value="<?php echo get_user_meta($user_id, 'address', true); ?>">
                                                    </div>

                                                    <table id="address">
                                                        <tr>
                                                            <td class="label">Street address</td>
                                                            <td class="slimField">
                                                                <input class="field" id="street_number" type="text" name="street_number" value="<?php echo get_user_meta($user_id, 'street_number', true); ?>" readonly /></td>
                                                            <td class="wideField" colspan="2">
                                                                <input class="field" id="route" name="route" type="text" value="<?php echo get_user_meta($user_id, 'route', true); ?>" readonly /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">City</td>
                                                            <td class="wideField" colspan="3">
                                                                <input class="field" id="locality" name="locality" type="text" value="<?php echo get_user_meta($user_id, 'locality', true); ?>" readonly  /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">State</td>
                                                            <td class="slimField"><input class="field" id="administrative_area_level_1" name="administrative_area_level_1" value="<?php echo get_user_meta($user_id, 'administrative_area_level_1', true); ?>" type="text" readonly /></td>
                                                            <td class="label">Zip code</td>
                                                            <td class="wideField">
                                                                <input class="field" id="postal_code" name="postal_code" type="text" readonly value="<?php echo get_user_meta($user_id, 'postal_code', true); ?>" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label">Country</td>
                                                            <td class="wideField" colspan="3">
                                                                <input class="field" id="country" type="text" name="country" readonly value="<?php echo get_user_meta($user_id, 'country', true); ?>" /></td>
                                                        </tr>
                                                    </table>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <input id="additional_phone_code" name="additional_phone_code" type="text" value="<?php echo get_user_meta($user_id, 'additional_phone_code', true); ?>" class="medium" tabindex="7" style="width: 75px;float: left;margin-right: 5px">
                                                        <input id="additional_phone" name="additional_phone" type="text" class="" tabindex="6" value="<?php echo get_user_meta($user_id, 'additional_phone', true); ?>" style="width: 225px">
                                                        <label for="additional_phone" id="input_1_2_4_label">Additional Phone *</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 
                                        </ul>
                                    </div>

                                </fieldset>

                                <h3>Child details</h3>
                                <fieldset>
                                    <div class="gform_body" id="childDetailsDiv"><strong>Loading.....</strong>
                                    </div>
                                </fieldset>

                            </form>
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

<?php get_footer('client'); ?>
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
