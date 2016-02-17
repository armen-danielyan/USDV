<?php
/**
 * Template Name: Member change password
 */
get_header('client');
global $wpdb;
$user_id = get_current_user_id();
if ($user_id == 0) {?>
    <script>
        window.location = "<?php echo esc_url(home_url('/')); ?>"; //redirect if email exists
    </script>
    <?php
}
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.form.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function(){
        jQuery("#member_password_form").validate({
            rules: {
                cpassword: {
                    required: true,
                    equalTo: "#password"
                },
                password: "required",
            },
            submitHandler: function(form) {
                jQuery('#memberChangePassword').val('Please wait...');
                var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                jQuery(form).ajaxSubmit({
                    type: "POST",
                    data: jQuery('#member_password_form').serialize(),
                    url: ajaxurl,
                    success: function (data) {
                        jQuery('#formResult').html('');
                        if(data == 'success'){
                            jQuery("#formResult").html('<div class="success">Password change successfully.</div>');
                            jQuery('#memberChangePassword').val('Update');
                        } else{
                            jQuery('#formResult').html(data);
                        }
                        jQuery('#memberChangePassword').val('Update');
                    },
                    error: function () {
                        jQuery("#formResult").html('<div class="error">There was an error during login!</div>');
                        jQuery('#memberChangePassword').val('Update');
                    }
                    //target: "#loginFormSubmit"
                });

            }
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

    <style type="text/css">
		.sidebar{padding-bottom: 0px;}
		.postarea.right{padding: 64px 9%;}  
    </style>

    <div class="row">
        <div class="content<?php if (empty($thumb)) { ?> no-thumb<?php } ?>">
            <!-- BEGIN .three columns -->
            <div class="three columns">
                <?php get_sidebar('member'); ?>
                <!-- END .three columns -->
            </div>

            <div class="thirteen columns">
                <!--lang swicher-->
                <?php get_sidebar('language'); ?>
                <!-- BEGIN .postarea full -->
                <div class="postarea right member_registration_form clearfix profileContent">

                    <?php if (!has_post_thumbnail()) { ?>
                        <h1 class="headline headline2"><?php the_title(); ?></h1>
                    <?php } ?>
                    <div class="blog-holder">
                        <div class="gf_browser_chrome gform_wrapper" id="gform_wrapper_1">
                            <div id="formResult"></div>
                            <form style="" action="" id="member_password_form" name="member_password_form" enctype="multipart/form-data" method="post" role="application" class="wizard clearfix">
                                <input type="hidden" id="registrationSuccessStatus" value="0">
                                <input name="action" type="hidden" value="member_change_password" />
                                <fieldset>
                                    <div class="gform_body">
                                        <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below">  
                                            <li id="field_1_1" class="gfield field_sublabel_below field_description_below">
                                               <!-- <label class="gfield_label" for="input_1_1_3">Login Access</label>-->
                                                <div class="ginput_complex ginput_container no_prefix has_first_name no_middle_name has_last_name no_suffix gf_name_has_2 ginput_container_name" id="input_1_1">
                                                    <span id="input_1_1_3_container" class="name_first">
                                                        <input type="password" name="password" id="password"  tabindex="1" class="required">
                                                        <label for="first_name">New Password</label>
                                                    </span>
                                                    <span id="input_1_1_6_container" class="name_last">
                                                        <input style="margin:0px;" type="password" name="cpassword" id="cpassword" tabindex="2" class="required">
                                                        <label for="first_name">Confirm Password</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li>

                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <div class="gform_footer top_label" style="padding:0px; margin: 0px;">
                                                    <input type="submit" id="memberChangePassword" class="gform_button button" value="Update">
                                                </div>
                                            </li>
                                        </ul>
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