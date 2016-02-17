<?php
/**
 * Template Name: Member Registration
 */

get_header();
global $wpdb;

//check login
if (is_user_logged_in()) {
    //wp_redirect( site_url() );
   // exit();
}


?>
    <script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.steps.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            var form = $("#member_registration_form").show();
            form.steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",
                titleTemplate: '<span class="number">#index#.</span><span class="headingTitle">#title#</span>',
                /* Labels */
                labels: {
                    current: "",
                    previous: "",
                    finish: "",
                    next: "Step 2",
                    loading: "Loading ..."
                },
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Allways allow previous action even if the current form is not valid!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }
                    //check email already exist in system
                    if (newIndex === 1 && ($("#registrationSuccessStatus").val() == 0))
                    {
                        var email = $('#email').val();
                        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';
                        if(email){
                            $.ajax({
                                type: "POST",
                                url : ajaxurl,
                                data : "action=user_registration_form&email="+email+"&first_name="+$('#first_name').val()+"&last_name="+$('#last_name').val(),
                                success: function(data) {
                                    if(data == 'exists'){
                                        window.location = "<?php echo esc_url( home_url( '/' ) ); ?>"; //redirect if email exists
                                        return false;
                                    }else if(data == 'added'){
                                        $('#registrationSuccessStatus').val(1);
                                        $('#email').prop("readonly", true);
                                    }
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
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 0)
                    {
                        $("a[href^='#next']").text('Step 2');
                    }

                    if (currentIndex === 1)
                    {
                        $("a[href^='#next']").text('Step 3');
                    }

                    if (currentIndex === 2)
                    {
                        $("a[href^='#next']").text('Step 4');
                    }

                    if (currentIndex === 3)
                    {
                        $("a[href^='#next']").text('Check Eligibility Now');
                    }

                    if (currentIndex === 4)
                    {
                        $("a[href^='#next']").text('');
                    }

                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                        return;
                    }

                    //$("input[name='married_status']:checked")
                    if (currentIndex == 2 && ($("#married_status").val() == 'Single'))
                    {
                        $(".body:eq(" + currentIndex + ") .required", form).removeClass("required");
                        form.steps("next");
                    }
                    if (currentIndex === 2 && ($("#married_status").val() == 'Married'))
                    {
                        $(".body:eq(" + currentIndex + ") .married-details", form).addClass("required");
                    }


                    if (currentIndex === 4)
                    {
                        var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ) ?>';

                        $.ajax({
                            type: "POST",
                            url : ajaxurl,
                            data : $("#member_registration_form").serialize(),
                            success: function(data) {
                                $('#eligibilityCheckResult').html(data)
                            }
                        });
                    }

                },
                onFinishing: function (event, currentIndex)
                {

                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                 //alert("Submitted!");
                    //form.submit();
                }
            }).validate({
                errorPlacement: function errorPlacement(error, element) {},
                rules: {
                    confirm: {
                        equalTo: "#password-2"
                    }
                }
            });

            //check children
            $('select[name=\'have_children\']').on('change', function() {
               if (this.value == 'Yes')
                {
                    $('#childrenDiv').html('<label for="email">Number of children</label><input id="number_of_children" name="number_of_children" type="number" class="married-details required">')
                }
                if (this.value == 'no'){
                    $('#childrenDiv').html('')
                }
            });
            $('select[name=\'have_children\']').trigger('change');
        });
    </script>
    <style>
        div.member_registration_form ul li{
            float: left;
			position: relative;
            list-style: none;
            width: 20%;
            text-align: center;
        }
        .member_registration_form .content .headingTitle {
            text-align: center;
        }
        .member_registration_form .content .number {
            background: red;
            padding: 7px;
            border-radius: 80%;
        }
        .member_registration_form .content .title {
            display:none;
        }
        li span.headingTitle{
            display: none;
        }

        li.current span.headingTitle, li.done span.headingTitle{
            display: block;
        }
        input.error{
            border: 1px solid red!important;
        }
    </style>

<?php $thumb = ( '' != get_the_post_thumbnail() ) ? wp_get_attachment_image_src( get_post_thumbnail_id(), 'purpose-featured-large' ) : false; ?>

    <div <?php post_class(); ?> id="page-<?php the_ID(); ?>">
        <?php if ( '' != get_the_post_thumbnail() ) { ?>
            <div class="feature-img page-banner" <?php if ( ! empty( $thumb ) ) { ?> style="background-image: url(<?php echo $thumb[0]; ?>);" <?php } ?>>
                <h1 class="headline img-headline"><?php the_title(); ?></h1>
                <?php the_post_thumbnail( 'purpose-featured-large' ); ?>
            </div>
        <?php } ?>

        <div class="row">

            <div class="content<?php if ( empty( $thumb ) ) { ?> no-thumb<?php } ?>">

                <!-- BEGIN .sixteen columns -->
                <div class="sixteen columns">
                    <!-- BEGIN .postarea full -->
                    <div class="postarea full member_registration_form clearfix">

                        <?php if ( ! has_post_thumbnail() ) { ?>
                            <h1 class="headline"><?php the_title(); ?></h1>
                        <?php } ?>
                        <div class="article">
                         <form style="" action="" id="member_registration_form" name="member_registration_form" enctype="multipart/form-data" method="post" role="application" class="wizard clearfix">
                            <input type="hidden" id="registrationSuccessStatus" value="0">
                            <input name="action" type="hidden" value="check_eligible" />
                            <h3>Personal Information</h3>
                            <fieldset>
                                <label for="first_name">First Name</label>
                                <input id="first_name" name="first_name" type="text" class="required">

                                <label for="last_name">Last Name</label>
                                <input id="last_name" name="last_name" type="text" class="required">

                                <label for="last_name">Birth Country</label>
                                <select class="required" name="birth_country" id="birth_country">
                                    <option value="">Select</option>
                                    <option value="USA">USA</option>
                                    <option value="Canada">Canada</option>
                                    <option value="India">India</option>
                                </select>

                                <label for="last_name">Education Level</label>
                                <select class="required" name="education_level" id="education_level">
                                    <option value="">Select</option>
                                    <option value="MA">MA</option>
                                    <option value="BSc">BSc</option>
                                </select>

                                <label for="last_name">Country of Residence</label>
                                <select class="required" name="country_of_residence" id="country_of_residence">
                                    <option value="">Select</option>
                                    <option value="USA">USA</option>
                                    <option value="Canada">Canada</option>
                                    <option value="India">India</option>
                                </select>

                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" class="required email">

                                <label for="email">Phone Number</label>
                                <input id="phone" name="phone" type="number" class="required">
                            </fieldset>

                            <h3>Profile</h3>
                            <fieldset>
                                <label for="name-2"><strong>Marital Status</strong></label>
                                <select class="required married_status" name="married_status" id="married_status">
                                    <option value="">Select</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                </select>

                                <label for="first_name">Occupation</label>
                                <input id="occupation" name="occupation" type="text" class="required">

                                <label for="first_name">Annual Income</label>
                                <input id="annual_income" name="annual_income" type="text" class="required">

                                <label for="first_name">Work Experience</label>
                                <input id="work_experience" name="work_experience" type="text" class="required">

                                <label for="first_name">Been To USA</label>
                                <input id="been_to_usa" name="been_to_usa" type="text" class="required">

                                <label for="first_name">Purpose of applying</label>
                                <input id="purpose_of_appliying" name="purpose_of_appliying" type="text" class="required">
                            </fieldset>

                            <h3>Spouse details</h3>
                            <fieldset>
                                <label for="first_name">Spouse First Name</label>
                                <input id="spouse_first_name" name="spouse_first_name" type="text" class="married-details required">

                                <label for="last_name">Spouse Last Name</label>
                                <input id="spouse_last_name" name="spouse_last_name" type="text" class="married-details required">

                                <label for="last_name">Spouse Birth Country</label>
                                <select class="married-details required" name="spouse_birth_country" id="spouse_birth_country">
                                    <option value="">Select</option>
                                    <option value="USA">USA</option>
                                    <option value="Canada">Canada</option>
                                    <option value="India">India</option>
                                </select>

                                <label for="last_name">Spouse Education Level</label>
                                <select class="married-details required" name="spouse_education_level" id="spouse_education_level">
                                    <option value="">Select</option>
                                    <option value="MA">MA</option>
                                    <option value="BSc">BSc</option>
                                </select>

                                <label for="email">Have children</label>
                                <select class="married-details required" name="have_children" id="have_children">
                                    <option value="no">No</option>
                                    <option value="Yes">Yes</option>
                                </select>
                                <div id="childrenDiv"></div>

                            </fieldset>

                            <h3>Contact Details</h3>
                            <fieldset>
                                <label for="first_name">Address 1</label>
                                <input id="address1" name="address1" type="text" class="required">

                                <label for="last_name">Address 1</label>
                                <input id="address2" name="address2" type="text" class="required">

                                <label for="last_name">Country of Residence</label>
                                <select class="required" name="contact_country_of_residence" id="contact_country_of_residence">
                                    <option value="">Select</option>
                                   <option value="USA">USA</option>
                                    <option value="Canada">Canada</option>
                                    <option value="India">India</option>
                                </select>

                                <label for="email">City</label>
                                <input id="city" name="city" type="text" class="required">

                                <label for="email">Zip Code</label>
                                <input id="zip" name="zip" type="text" class="required">

                                <label for="email">Additional Phone</label>
                                <input id="additional_phone" name="additional_phone" type="number" class="required">
                            </fieldset>

                            <h3>Eligibility Check</h3>

                            <fieldset>
                                <div id="eligibilityCheckResult">
                                    <b>Checking your eligibility, it take couple of minute.</b><br/>
                                    <b>Please wait.</b>
                                </div>
                            </fieldset>

                        </form>
                        <!-- END .postarea full -->
                        </div>
                        <div class="clear"></div>
                    </div>
                    <!-- END .sixteen columns -->
                </div>

            </div>

        </div>
    </div>
<?php get_footer(); ?>