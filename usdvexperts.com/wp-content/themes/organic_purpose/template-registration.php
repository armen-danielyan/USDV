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
                    var phone_country = jQuery('#phone_country').val();
                    var phone_code = jQuery('#phone_code').val();
                    var phone = jQuery('#phone').val();


                    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                    var ajaxurl2 = '<?php  ?>';
                    if (email && first_name && last_name && birth_country && education_level && country_of_residence && phone_code && phone) {
                        jQuery("a[href^='#next']").text('Please wait...');
                        //User Registration
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl2,
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
                        //SalesForce Registration
                        jQuery.ajax({
                            type: "POST",
                            url: ajaxurl2,
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
//                            jQuery('#no_of_children').prop("readonly", false);
                            jQuery('#no_of_children').attr("disabled", false);
                        }
                        if (this.value == 'no') {
                            jQuery('#no_of_children').removeClass("required");
                            jQuery('#no_of_children').val('');
//                            jQuery('#no_of_children').prop("readonly", true);
                            jQuery('#no_of_children').attr("disabled", true);
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
                                jQuery('#eligibilityCheckResult').html('<h2>Congratulations!</h2><br/><img src="<?php echo get_template_directory_uri().'/images/eligibility_yes.png'; ?>"><br/><h3>You are eligible to apply.</h3><br/>You will be redirected now to your DV application');
                                /*setTimeout(function() {
                                    window.location.href = "<?php echo get_permalink(985); ?>"
                                }, 4000);*/
                                setTimeout(function() {
//                                    window.location.href = "<?php //echo get_permalink(979); ?>//"
                                    window.location.href = "<?php echo get_permalink(981); ?>"
                                }, 2000);
//                                setTimeout(function() {
//                                    jQuery( "#goToPaymentPage" ).trigger( "click" );
//                                }, 4000);
                            } else {
                                jQuery('#eligibilityCheckResult').html('<strong>Unfortunately, you’re not eligible for the US DV program!</strong><br/><img src="<?php echo get_template_directory_uri().'/images/eligibility_no.png'; ?>"><br/><p>Would you be interested to immigrate to</p><br/><a class="altsug" href="javascript:void(0)" onclick="immigrateTo(\'Canada\')">Canada</a><a class="altsug" href="javascript:void(0)" onclick="immigrateTo(\'Australia\')">Australia</a>');
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
                    lettersonly: false
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
                    //required: true,
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
        var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: "action=get_phone_code_by_ip",
            success: function(code) {
                if (code) {
                    jQuery('#phone_code').val(code);
                    jQuery('#additional_phone_code').val(code);
                }
            }
        });
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
<script type="text/javascript">
    jQuery(document).ready(function () {
        // Tooltip only Text
        jQuery('.masterTooltip').hover(function () {
            // Hover over code
            var title = jQuery(this).attr('title');
            jQuery(this).data('tipText', title).removeAttr('title');
            jQuery('<span class="tooltip"></span>')
                .text(title)
                .appendTo('body')
                .fadeIn('slow');
        }, function () {
            // Hover out code
            jQuery(this).attr('title', jQuery(this).data('tipText'));
            jQuery('.tooltip').remove();
        }).mousemove(function (e) {
            var mousex = e.pageX + 20; //Get X coordinates
            var mousey = e.pageY + 10; //Get Y coordinates
            jQuery('.tooltip')
                .css({top: mousey, left: mousex})
        });
    });
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
                                                        <label for="first_name">
                                                            <span class="starred">*</span>
                                                            <span>First Name</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>
                                                    <span id="input_1_1_6_container" class="name_last">
                                                        <input type="text" name="last_name" id="last_name"  aria-label="Last name" tabindex="2" class="required">
                                                        <label for="last_name">
                                                            <span class="starred">*</span>
                                                            <span>Last Name</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li> 

                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
<!--                                                <label class="gfield_label" for="input_1_2_1">Address</label>    -->
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
                                                        <label for="birth_country" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Birth Country</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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
                                                        <label for="education_level" id="input_1_2_6_label">
                                                            <span class="starred">*</span>
                                                            <span>Education Level</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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
                                                        <label for="country_of_residence" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Country of Residence</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
                                                        <input id="email" name="email" type="email" class="required email" tabindex="6">
                                                        <label for="input_1_2_4" id="input_1_2_4_label">
                                                            <span class="starred">*</span>
                                                            <span>Email</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li>

                                            <li id="field_1_3" class="gfield field_sublabel_below field_description_below">
                                                <label class="gfield_label" for="phone">
                                                    <span class="starred">*</span>
                                                    <span>Phone</span>
                                                    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
												</label>
                                                <div class="ginput_container ginput_container_phone">
                                                    <?php $auto_detected_country = us_get_country_by_ip(); ?>
                                                    <select class="required" name="phone_country" id="phone_country" tabindex="7" style="float: left;margin-right: 5px">
                                                        <option value="">Country name</option>
                                                        <?php
                                                        if( $countries = getCountryList() ) {
                                                            foreach( $countries as $country ) {
                                                                $selected = $country == $auto_detected_country ? 'selected' : '';
                                                                echo '<option value="'.$country.'" '.$selected.'>'.$country.'</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                    <input value="<?php echo get_prefix($auto_detected_country); ?>" id="phone_code" name="phone_code" type="text" class="required medium" tabindex="7" style="width: 55px;float: left;margin-right: 5px" placeholder="Prefix" />
                                                    <input id="phone" name="phone" type="text" class="required medium" tabindex="7" style="max-width: 195px;" placeholder="Number" />
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
                                                        <label for="married_status" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Marital Status</span>
    														<span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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

                                                        <label for="occupation" id="input_1_2_6_label">
                                                            <span class="starred">*</span>
                                                            <span>Occupation</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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
                                                        <label for="annual_income" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Annual Income</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>

                                                    <span class="ginput_right address_state" id="input_1_2_4_container">
													
													<select class="required" name="work_experience" id="work_experience" tabindex="4">
                                                             <option value="">Select Work Experience</option>
                                                        <?php
                                                        if($experiences = getWorkExperienceList()){
                                                            foreach($experiences as $experience){
                                                                echo '<option value="'.$experience.'">'.$experience.'</option>';
                                                            }
                                                        }
                                                        ?>
                                                         </select>
													
                                                        <!--<input id="work_experience" name="work_experience" type="text" class="required" tabindex="4">-->

                                                        <label for="work_experience" id="input_1_2_4_label">
                                                            <span class="starred">*</span>
                                                            <span>Work experience</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">

                                                        <select id="been_to_usa" name="been_to_usa" class="required" tabindex="5">
                                                            <option value="">Select</option> 
                                                            <option value="Yes">Yes</option> 
                                                            <option value="No">No</option> 
                                                        </select>
                                                        <label for="been_to_usa" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Been to USA</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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
                                                        <label for="purpose_of_appliying" id="input_1_2_4_label">
                                                            <span class="starred">*</span>
                                                            <span>Purpose of applying</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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
                                                            <?php
                                                            if($countries = getCountryList()){
                                                                foreach($countries as $coutnry){
                                                                    echo '<option value="'.$coutnry.'">'.$coutnry.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <label for="spouse_birth_country" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Spouse Birth Country</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
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

                                                        <label for="spouse_education_level" id="input_1_2_4_label">
                                                            <span class="starred">*</span>
                                                            <span>Spouse Education Level</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
														</label>
                                                    </span>

                                                    <span class="ginput_left address_zip" id="input_1_2_5_container">
                                                        <select class="required" name="have_children" id="have_children" tabindex="5">
                                                            <option value="no">No</option>
                                                            <option value="Yes">Yes</option>
                                                        </select>
                                                        <label for="have_children" id="input_1_2_5_label">
                                                            <span class="starred">*</span>
                                                            <span>Have children</span>
														    <span class="masterTooltip" title="This field is required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
                                                        </label>
                                                    </span>
                                                    <div id="childrenDiv">
                                                        <span class="ginput_right address_state" id="input_1_2_4_container">
                                                            <select id="no_of_children" name="no_of_children" tabindex="6">
                                                                <option value="">Select</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                            </select>
                                                            <label for="no_of_children" id="input_1_2_4_label">
                                                                <span class="starred">*</span>
                                                                <span>Number of Children</span>
															    <span class="masterTooltip" title="This field is required">
                                                                    <img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>">
                                                                </span>
															</label>
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
                                                <label class="gfield_label" for="input_1_2_1">
                                                    <span about="starred">*</span>
                                                    <span>Contact Details</span>
                                                </label>
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
                                                        <input id="autocomplete" placeholder="Type in your city and country" name="address" onfocus="geolocate()" type="text" autocomplete="off">
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

                                                    <span class="ginput_right address_state additional_phone_container" id="input_1_2_4_container">
                                                        <label for="additional_phone" id="input_1_2_4_label">Additional Phone <!--<span class="starred">*</span>-->
                                                        <span class="masterTooltip" title="This field is not required"><img src="<?php echo get_template_directory_uri().'/images/questionmark.png'; ?>"></span>
                                                        </label> 
                                                        <?php $auto_detected_country = us_get_country_by_ip(); ?>
                                                        <select name="additional_phone_country" id="additional_phone_country" tabindex="7" style="float: left;margin-right: 5px">
                                                            <option value="">Country name</option>
                                                            <?php
                                                            if( $countries = getCountryList() ) {
                                                                foreach( $countries as $country ) {
                                                                    $selected = $country == $auto_detected_country ? 'selected' : '';
                                                                    echo '<option value="'.$country.'" '.$selected.'>'.$country.'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                        <input id="additional_phone_code" name="additional_phone_code" type="text" class="medium" tabindex="7" style="width: 55px;float: left;margin-right: 5px" placeholder="Prefix" />
                                                        <input id="additional_phone" name="additional_phone" type="text" class="" tabindex="6" style="width: 225px" placeholder="Number" />

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
                                        <b>Checking your eligibility, please wait...</b><br/><br/>
                                        
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" alt="Loading...">
										<br/><br/>
										<b>Please wait.</b>
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
<?php 
$_REQUEST['killfooter'] = "1";
get_footer();

?>
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
