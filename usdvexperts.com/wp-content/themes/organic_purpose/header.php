<?php
/**
* The Header for our theme.
* Displays all of the <head> section and everything up till <div id="wrap">
*
* @package Purpose
* @since Purpose 1.0
*
*/
?><!DOCTYPE html>

<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>
	<link rel="Shortcut Icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
	
	<?php get_template_part( 'style', 'options' ); ?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/entypo.css" type='text/css'>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/formsmain.min.css" type='text/css'>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php echo esc_url( bloginfo('pingback_url') ); ?>">
	
	<?php wp_head(); ?>

<style type="text/css">
 .miniMenu{border: 1px solid #002868;
    color: white;
    text-align: right;
    background: #002868;
    border-radius:4px;
    padding: 5px 10px;
    margin-right: 6px;
    line-height: 18px;
    display: inline-block;
    float: right;
	    font-size: 13px;
    text-transform: capitalize;
	margin-top:4px;
 }
 .miniMenu a{display:inline-block;color:#fff}
 .topnav .dropdown-menu > li > a{padding:4px 2px;font-size:10px;}
 .dropdown img,.topnav .dropdown-menu > li img{margin-right:3px;}
 .topnav{margin:0px; height:auto;background:none;padding-top:6px;width:auto;float:right;display:inline-block;}
</style>
</head>

<body <?php body_class(); ?>>

<!-- BEGIN #wrap -->
<div id="wrap">

	<!-- BEGIN .container -->
	<div class="container">
	
		<!-- BEGIN #header -->
		<div id="header" class="header-large<?php $header_image = get_header_image(); $slider = get_theme_mod( 'category_slideshow_home' ); if (
			// Conditionals for displaying dark text 
			is_page() && ! has_post_thumbnail() && ! is_page_template( 'template-slideshow.php' ) 
			|| is_single() && ! has_post_thumbnail() && ! has_post_format('gallery') 
			|| is_archive() && empty( $header_image ) || is_search() && empty( $header_image ) 
			|| is_home() && empty( $slider ) 
			|| is_404()
			|| class_exists( 'Woocommerce' ) && is_woocommerce() 
			) { ?> text-dark<?php } ?>">
		
			<!-- BEGIN .row -->
			<div class="row">
				<?php if ( 
				// Conditionals for displaying logo
				is_home() && ! empty( $slider ) && get_theme_mod( 'purpose_logo_light' ) && get_theme_mod( 'purpose_logo_dark' ) 
				|| is_page_template( 'template-slideshow.php' ) 
				|| is_single() && has_post_format('gallery')
				|| is_archive() && ! class_exists( 'Woocommerce' ) && ! empty( $header_image ) 
				|| is_archive() && class_exists( 'Woocommerce' ) && ! is_woocommerce() && ! empty( $header_image ) 
				|| is_search() && ! empty( $header_image ) 
				|| is_page() && has_post_thumbnail() && get_theme_mod( 'purpose_logo_light' ) && get_theme_mod( 'purpose_logo_dark' ) 
				|| is_single() && ! class_exists( 'Woocommerce' ) && has_post_thumbnail() && get_theme_mod( 'purpose_logo_light' ) && get_theme_mod( 'purpose_logo_dark' ) 
				|| is_single() && class_exists( 'Woocommerce' ) && ! is_woocommerce() && has_post_thumbnail() && get_theme_mod( 'purpose_logo_light' ) && get_theme_mod( 'purpose_logo_dark' ) 
				) { ?>
				
				<!-- BEGIN .four columns -->
				<div class="four columns">
						
					<!-- BEGIN #logo-title -->
					<div id="logo-title">
					
						<div id="logo">
							<img class="logo-light" src="<?php echo esc_url( get_theme_mod( 'purpose_logo_light' ) ); ?>" alt="" />
							<img class="logo-dark hidden" src="<?php echo esc_url( get_theme_mod( 'purpose_logo_dark' ) ); ?>" alt="" />
						</div>
					
						<div id="masthead">
						
							<h1 class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo wp_kses_post( get_bloginfo( 'name' ) ); ?></a>
							</h1>
							
							<h2 class="text-hide">
								<?php echo wp_kses_post( get_bloginfo( 'description' ) ); ?>
							</h2>
							
						</div>
					
					<!-- END #logo-title -->
					</div>
				
				<!-- END .four columns -->
				</div>
					
				<?php } elseif ( 
				// Conditionals for displaying only black logo
				is_home() && empty( $slider )
				|| is_archive() && empty( $header_image ) 
				|| is_archive() && class_exists( 'Woocommerce' ) && is_woocommerce() && ! empty( $header_image ) 
				|| is_search() && empty( $header_image ) 
				|| is_single() && ! has_post_thumbnail() && get_theme_mod( 'purpose_logo_dark' ) 
				|| is_single() && class_exists( 'Woocommerce' ) && is_woocommerce() && has_post_thumbnail() && get_theme_mod( 'purpose_logo_dark' ) 
				|| is_page() && ! has_post_thumbnail() && get_theme_mod( 'purpose_logo_dark' )
				|| is_404() && get_theme_mod( 'purpose_logo_dark' ) 
				) { ?>
				
				<!-- BEGIN .four columns -->
				<div class="four columns">
				
					<!-- BEGIN #logo-title -->
					<div id="logo-title">
				
						<div id="logo">
							<img src="<?php echo esc_url( get_theme_mod( 'purpose_logo_dark' ) ); ?>" alt="" />

                        </div>
					
						<div id="masthead">
						
							<h1 class="site-title">
								<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo wp_kses_post( get_bloginfo( 'name' ) ); ?></a>
							</h1>
							
							<h2 class="text-hide">
								<?php echo wp_kses_post( get_bloginfo( 'description' ) ); ?>
							</h2>
							
						</div>
					
					<!-- END #logo-title -->
					</div>
				
				<!-- END .four columns -->
				</div>
			
				<?php } else { ?>
				
				<!-- BEGIN #logo-title -->
				<div id="logo-title">
			
					<div id="masthead" class="no-logo">
					
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo wp_kses_post( get_bloginfo( 'name' ) ); ?></a>
						</h1>
						
						<h2 class="text-hide">
							<?php echo wp_kses_post( get_bloginfo( 'description' ) ); ?>
						</h2>
						
					</div>
				
				<!-- END #logo-title -->
				</div>
					
				<?php } ?>
				
				<span class="menu-toggle"></span>
			
				<!-- BEGIN #navigation -->
				<nav id="navigation" class="navigation-main" role="navigation">
					<!--lang swicher-->
					<?php get_sidebar('languagesite'); ?>
					<?php if (is_user_logged_in()) {
						$user_id = get_current_user_id();
						//$full_name = get_user_meta($user_id, 'first_name', true).' '.get_user_meta($user_id, 'last_name', true);?>
						<div class="miniMenu">
							<a href="<?php echo get_permalink(996); ?>">Back To Profile</a> <!--|
							<a href="<?php /*echo wp_logout_url( home_url() ); */?>"><?php /*_e('Log Out', 'organicthemes'); */?></a>-->
						</div>
					<?php }else{?>
						<div class="miniMenu">
							<a href="<?php echo get_permalink(979); ?>">Applicant Login</a>
<!--							<a href="--><?php //echo admin_url(); ?><!--">Admin Login</a>-->
						</div>
					<?php } ?>
					<div style="clear:both"></div>
					<?php if ( has_nav_menu( 'header-menu' ) ) {
						wp_nav_menu( array(
							'theme_location' => 'header-menu',
							'title_li' => '',
							'depth' => 4,
							'container_class' => '',
							'menu_class'      => 'menu'
							)
						);
					} else { ?>
						<div class="menu-container"><ul class="menu"><?php wp_list_pages('title_li=&depth=4'); ?></ul></div>
					<?php } ?>
				
				<!-- END #navigation -->
				</nav>

			<!-- END .row -->
			</div>
			
			<span class="header-bg"></span>
		
		<!-- END #header -->
		</div>