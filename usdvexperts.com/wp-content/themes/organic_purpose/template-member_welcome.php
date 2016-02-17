<?php
/**
 * Template Name: Member Welcome Page
 */
get_header('client');
?>
  <style type="text/css">
		.col-md-8{padding-left:0px;}
		.sidebar{padding-bottom: 0px;}
    </style>
	<?php
global $wpdb;

//check login
$user_id = get_current_user_id();
if ($user_id == 0) { ?>
    <script>
        window.location = "<?php echo esc_url(home_url('/')); ?>"; //redirect if email exists
    </script>
<?php
}

$user = new WP_User($user_id);
?>
<?php $thumb = ('' != get_the_post_thumbnail()) ? wp_get_attachment_image_src(get_post_thumbnail_id(), 'purpose-featured-large') : false; ?>

<div <?php post_class(); ?> id="page-<?php the_ID(); ?>">
    <?php if ('' != get_the_post_thumbnail()) { ?>
        <div
            class="feature-img page-banner" <?php if (!empty($thumb)) { ?> style="background-image: url(<?php echo $thumb[0]; ?>);" <?php } ?>>
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
                <div class="postarea right member_registration_form clearfix profileContent" style="color:#333333">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php ///if (!has_post_thumbnail()) { ?>
                        <div id="welcome-message" class="header-text">
						<h2 class="headline"><?php _e('Welcome to US DV Experts Application', 'organicthemes') //the_title(); ?></h2>
						</div>
                    <?php //} ?>
                    <div class="row">
    <div class="col-md-8">
        <div id="welcome_text"><p style="padding:0px;">
<!--             The GUSGC Web Application will assist you in completing and submitting your application for the Green Card Lottery.
            <br>
            You can access the fields for submission on the left toolbar or via the icons below.<br> Please fill in all required details and upload your personal photo.
            <br>
            Once all fields have been completed, the "<strong>Submit Application</strong>" button will be enabled.</p>
            <h3>Complete your appliaction in 2 easy steps:</h3> -->

            Welcome to the US DV Experts Green Card Application
            <br><br>
            The US DV Experts form will assist you to update all your application details. Based on the personal information you will update here; our experts will craft your successful entry.
            <br>
            Please make sure you update all the required fields correctly, upload your photos and then click on <strong>Submit Application</strong>.
        </div>
        <div id="first-row" class="row morespace" >


		<a class="boxess" href="<?php echo get_permalink(981); ?>">
            <?php $css_class = is_ready_to_apply() ? 'tile-green' : 'tile-red'; ?>
            <div class="dashboard-box col-sm-7 col-xs-12" data-section="application" data-href="">
                <div class="tile-stats tile-first <?php echo $css_class; ?>">
                    <div class="num">
                        <!-- <span class="icoPersonal">k</span> -->
                        <span class="icos icos1"></span>
                        <?php _e('Personal Information', 'organicthemes'); ?>
                    </div>
                    <p>Click here to fill in your application</p>
                </div>
            </div>
		</a>
		
		<a class="boxess" href="<?php echo get_permalink(983); ?>">
            <?php $css_class = is_photo_ready_to_apply() ? 'tile-green' : 'tile-red'; ?>
		<div class="dashboard-box col-sm-7 col-xs-12" data-section="photo" data-href="" style="padding-left:0px;">	
		<div class="tile-stats <?php echo $css_class; ?>" style="padding-bottom:23px;">
		<div class="num">
            <!-- <span class="icoPersonal">p</span> -->
            <span class="icos icos2"></span>
            <?php _e('Photos', 'organicthemes'); ?></div>
		<p>Click here to upload your photos</p>
		</div>
		</div>
		</a>
		
		</div>
		<p style="margin: 0 0 8.5px;font-size: 12px;">
            Please feel free to <a href="https://usdvexperts.com/language/en/contact/">contact us</a> if you have any question or require assistance.
            <!-- *Our automated system will help you with the preliminary steps of the Green Card Lottery application. However, input and formatting errors may go undetected by this system, and thus we cannot guarantee a successful submission through our automated service alone. -->
        </p>
        <div id="second-row"></div>
    </div>
    <div class="col-md-4 homepage_img" style="padding-right:0px;">
	<img src="<?php echo get_template_directory_uri(); ?>/images/family_img.jpg">
       
    </div>
</div>
                    <div class="clear"></div>
<?php endwhile; endif; ?>
                </div>
                <!-- END .sixteen columns -->
            </div>

        </div>

    </div>
</div>

<?php get_footer('client'); ?>