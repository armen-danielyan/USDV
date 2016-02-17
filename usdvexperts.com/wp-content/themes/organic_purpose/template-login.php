<?php
/**
 * Template Name: Member Login
 */
get_header();
global $wpdb;

//check login
if (is_user_logged_in()) {
    //wp_redirect( site_url() );
    // exit();
}
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/member/jquery.form.min.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function(){
        jQuery("#member_login_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: "required"
            },
            submitHandler: function(form) {
                jQuery('#memberLoginButton').val('Please wait...');
                var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
                jQuery(form).ajaxSubmit({
                    type: "POST",
                    data: jQuery('#member_login_form').serialize(),
                    url: ajaxurl,
                    success: function (data) {
                        jQuery('#loginResult').html('');
                        if(data == 'success'){
                            window.location = "<?php echo get_permalink(996); ?>"; //redirect if email exists
                            return false;
                        } else{
                            jQuery('#loginResult').html(data);
                        }
                        jQuery('#memberLoginButton').val('Login');
                    },
                    error: function () {
                        jQuery("#loginResult").html('<div class="error">There was an error during login!</div>');
                        jQuery('#memberLoginButton').val('Login');
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

    <div class="row">
        <div class="content<?php if (empty($thumb)) { ?> no-thumb<?php } ?>">

            <!-- BEGIN .sixteen columns -->
            <div class="sixteen columns">
                <!-- BEGIN .postarea full -->
                <div class="postarea member_registration_form clearfix">

                    <?php if (!has_post_thumbnail()) { ?>
                        <h1 class="headline headline2"><?php the_title(); ?></h1>
                    <?php } ?>
                    <div class="article">
                        <div class="gf_browser_chrome gform_wrapper" id="gform_wrapper_1" style="max-width: 50%;">
                            <div id="loginResult"></div>
                            <form style="" action="" id="member_login_form" name="member_login_form" enctype="multipart/form-data" method="post" role="application" class="wizard clearfix">
                                <input type="hidden" id="registrationSuccessStatus" value="0">
                                <input name="action" type="hidden" value="member_login" />
                                <fieldset>
                                    <div class="gform_body">
                                        <ul id="gform_fields_1" class="gform_fields top_label form_sublabel_below description_below">  
                                            <li id="field_1_1" class="gfield field_sublabel_below field_description_below">
                                               <!-- <label class="gfield_label" for="input_1_1_3">Login Access</label>-->
                                                <div class="ginput_complex ginput_container no_prefix has_first_name no_middle_name has_last_name no_suffix gf_name_has_2 ginput_container_name" id="input_1_1">
                                                    <span id="input_1_1_3_container" class="name_first">
                                                        <input type="email" name="email" id="email"  aria-label="E-mail" tabindex="1" class="required email">
                                                        <label for="first_name">E-mail</label>
                                                    </span>
                                                    <span id="input_1_1_6_container" class="name_last">
                                                        <input style="margin:0px;" type="password" name="password" id="password"  aria-label="Password" tabindex="2" class="required">
                                                        <label for="last_name">Password</label>
                                                    </span>
                                                    <div class="gf_clear gf_clear_complex"></div>
                                                </div>
                                            </li>

                                            <li id="field_1_2" class="gfield field_sublabel_below field_description_below">
                                                <div class="gform_footer top_label" style="padding:0px; margin: 0px;">
                                                    <input type="submit" id="memberLoginButton" class="gform_button button" value="Login">
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
<?php get_footer(); ?>