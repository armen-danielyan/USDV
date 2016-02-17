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
	
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="Shortcut Icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
	
	<?php get_template_part( 'style', 'options' ); ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" type='text/css'>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/entypo.css" type='text/css'>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/formsmain.min.css" type='text/css'>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php echo esc_url( bloginfo('pingback_url') ); ?>">
	
	<?php wp_head(); ?>
	<style type="text/css">
	html,body,#wrap,.container,.type-page,.row,.content,.row .three{height:100%;}
	html{margin-top:0px !important;}

		.three{background: #009bff;}
		.content{padding:0px 0px;}
		.sidebar{
		margin: 0px;
		padding: 0px 0px 0px 24px;
		background: #009bff;
		color: #fff;
		padding-top: 0px;}
		.sidebar a{color:#fff}
		.sidebar.left {
		padding: 20px 24px 0px 0px;
		}

		.postarea.right{padding: 20px 38px 0px 38px;}
		
		.homepage_img img {
		width: 100%;
		border: 2px solid #E4DFDF;
		}
	
	#wpadminbar{display:none;}
	.container{width:100% !important;}
	.content.no-thumb, .no-thumb{padding-top:0px;}
	.row .three{width: 18.5%;}
	.row .thirteen {
    width: 81.5%;
}
#welcome_text p{font-size:15px;}
div.member_registration_form .steps ul li span.number{width:30px; height:30px;}
body.page-template-template-profile form .content{padding:0px 9%;}
.container form{font-size:15px;}
.blog-holder{background: none;box-shadow: none; margin-bottom:0px;}
table td.label{border:0px; background:none; color:#666666;}

   span.fcirle{ width: 24px !important;
    height: 24px;
    border-radius: 50%;
    float: right !important; 
    margin: 7px 12px 0px 0px !important;
    border: 2px solid #fff;
   }
   .sidebar ul li span.finner{
		font-size: 32px !important;
		line-height: .9em;
		padding-right: 13px !important;
	}
	.sidebar .left .widget .innerul li a:hover span.fcirle{border:2px solid #000;}
	.logo a:hover{text-decoration:none;}
	</style>
</head>

<body <?php body_class(); ?>>

<!-- BEGIN #wrap -->
<div id="wrap">

	<!-- BEGIN .container -->
	<div class="container">
		<!-- BEGIN #header -->
		