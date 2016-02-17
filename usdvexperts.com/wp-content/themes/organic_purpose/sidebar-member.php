<div class="sidebar">

    <?php

    $current_user = wp_get_current_user();
    $current_user->display_name ;
    $user_id = get_current_user_id();
    $accordion_active = 0;
    $accordion_page = array(981,989,983,996,1034,1036,1038,1457);

    if ( $current_page_id = get_the_ID() ) {
        if ( in_array($current_page_id, $accordion_page ) ) {
            $accordion_active = 1;
        }
    }

    $current_language = get_locale();

    if ( $current_language == 'en_US' ) {
        $about_us_page_id = 1034;
        $our_service_page_id = 1036;
        $usdv_info_page_id = 1038;
    } elseif ( $current_language == 'it_IT' ) {
        $about_us_page_id = 1052;
        $our_service_page_id = 1059;
        $usdv_info_page_id = 1065;
    } elseif ( $current_language == 'es_ES' ) {
        $about_us_page_id = 1040;
        $our_service_page_id = 1057;
        $usdv_info_page_id = 1063;
    } elseif ( $current_language == 'ar' ) {
        $about_us_page_id = 1054;
        $our_service_page_id = 1061;
        $usdv_info_page_id = 1067;
    }

    $about_us_page_id = 1034;
    $our_service_page_id = 1036;
    $usdv_info_page_id = 1038;
    $submit_application_page = 1449;

    if( !$member_photo_url = get_user_meta( $user_id, 'photo_url', true ) ) {
        $member_photo_url = get_template_directory_uri().'/images/no_image.png';
    }

    ?>

    <header class="profile-info">
        <i id="useravatar">
            <img onerror="loadblank(this);" src="<?php echo $member_photo_url; ?>" alt="" class="avatar img-circle" width="35" height="35">
            <span><?php echo get_user_meta($user_id, 'first_name', true).' '.get_user_meta($user_id, 'last_name', true); ?></span>
        </i>
    </header>


    <header class="logo-env">
        <!-- logo -->
        <div class="logo">
            <a href="index.php">
                <h4 style="color:#fff;padding:0px; margin:0px;margin-top:12px;"> <img src="<?php echo get_template_directory_uri(); ?>/images/USDVEXP-Logo-2.png" alt="logo" height="60">&nbsp;US DV Experts</h4>
            </a>
        </div>
    </header>

    <div class="sidebar left">
        <div class="widget widget_pages" id="pages-2">

            <div class="accordion">
                <div class="accordion-section">
                    <ul>
                        <li style="border-bottom:0px;"><a class="accordion-section-title <?php echo $accordion_active == 1 ? 'active' : ''; ?>" href="#accordion-1"><span>/</span><?php _e('My Application', 'organicthemes'); ?></a></li>
                        <div id="accordion-1" class="accordion-section-content <?php echo $accordion_active == 1 ? 'open' : ''; ?>" style="<?php echo $accordion_active == 1 ? 'display: block;' : ''; ?>">
                            <ul class="innerul">
                                <li class="page_item page-item-148 <?php echo !empty($current_page_id) && $current_page_id == 996 ? 'active' : ''; ?>">
                                    <a href="<?php echo get_permalink(996); ?>"><span>ï</span><?php _e('Home Page', 'organicthemes'); ?></a>
                                </li>
                                <li class="page_item page-item-148 <?php echo !empty($current_page_id) && $current_page_id == 981 ? 'active' : ''; ?>">
                                    <a href="<?php echo get_permalink(981); ?>"><span>k</span><?php _e('Personal Information', 'organicthemes'); ?>
                                    <span class="fcirle"><span class="finner">&</span></span></a>
                                </li>
                                <li class="page_item page-item-530 <?php echo !empty($current_page_id) && $current_page_id == 983 ? 'active' : ''; ?>">
                                    <a href="<?php echo get_permalink(983); ?>"><span>p</span><?php _e('Photos', 'organicthemes'); ?>
                                        <span class="fcirle"><span class="finner">&</span></span>
                                    </a>
                                </li>
                                <li class="page_item page-item-530 <?php echo !empty($current_page_id) && $current_page_id == 1457 ? 'active' : ''; ?>">
                                    <a href="<?php echo get_permalink(1457); ?>"><span>p</span><?php _e('Scans', 'organicthemes'); ?>
                                        <span class="fcirle"><span class="finner">&</span></span>
                                    </a>
                                </li>
                                <li class="page_item page-item-530 <?php echo !empty($current_page_id) && $current_page_id == 989 ? 'active' : ''; ?>">
                                    <a href="<?php echo get_permalink(989); ?>"><span>h</span><?php _e('Change Password', 'organicthemes'); ?>
                                        <span class="fcirle"><span class="finner">&</span></span>
                                    </a>
                                </li>
                                <li class="page_item page-item-530"  style="border-bottom:0px;"><a href="<?php echo wp_logout_url( home_url() ); ?>"><span>g</span><?php _e('Log Out', 'organicthemes'); ?></a></li>
                            </ul>
                        </div>

                        <?php $ready_class =  is_photo_ready_to_apply() && is_ready_to_apply() ? 'ready_apply' : ''; ?>

                        <div class="submit-application <?php echo $ready_class; ?>">
                            <ul>
                                <li><a href="<?php echo get_permalink($submit_application_page); ?>"><?php echo __( 'Submit application', 'organicthemes' ); ?></a></li>
                            </ul>
                        </div>
                </div>
                <ul>
                     <li class="page_item page-item-530 <?php echo !empty($current_page_id) && $current_page_id == $about_us_page_id ? 'active' : ''; ?>"><a href="<?php echo get_permalink($about_us_page_id); ?>"><span>.</span><?php _e('About Us', 'organicthemes'); ?></a></li>
                     <li class="page_item page-item-530 <?php echo !empty($current_page_id) && $current_page_id == $our_service_page_id ? 'active' : ''; ?>"><a href="<?php echo get_permalink($our_service_page_id); ?>"><span>l</span><?php _e('Our Services', 'organicthemes'); ?></a></li>
                     <li class="page_item page-item-530 <?php echo !empty($current_page_id) && $current_page_id == $usdv_info_page_id ? 'active' : ''; ?>"><a href="<?php echo get_permalink($usdv_info_page_id); ?>"><span>`</span><?php _e('US DV Information', 'organicthemes'); ?></a></li>
                     <!--<li class="page_item page-item-530"><a href="<?php //echo wp_logout_url( home_url() ); ?>"><span>g</span>Logout</a></li>-->
                </ul>
            </div>

        </div>
    </div>
</div>


<style type="text/css">

/*------------------------------------*\

-------- DEMO Code: accordion
\*------------------------------------*/

/*----- Section Titles -----*/
.accordion-section-title {
	width:100%;
	display:inline-block;
	/* Type */
	color:#fff;
}

.accordion-section-title.active, .accordion-section-title:hover {
	/* Type */
	text-decoration:none;
}

.accordion-section:last-child .accordion-section-title {
	border-bottom:none;
}

/*----- Section Content -----*/
.accordion-section-content {
	display:none;
}

</style>

<script>
jQuery(document).ready(function() {
	function close_accordion_section() {
		jQuery('.accordion .accordion-section-title').removeClass('active');
		jQuery('.accordion .accordion-section-content').slideUp(300).removeClass('open');
	}

	jQuery('.accordion-section-title').click(function(e) {
		// Grab current anchor value
		var currentAttrValue = jQuery(this).attr('href');

		if(jQuery(e.target).is('.active')) {
			close_accordion_section();
		}else {
			close_accordion_section();

			// Add active class to section title
			jQuery(this).addClass('active');
			// Open up the hidden content panel
			jQuery('.accordion ' + currentAttrValue).slideDown(300).addClass('open'); 
		}

		e.preventDefault();
	});
});
</script>