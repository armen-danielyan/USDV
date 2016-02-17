<?php

/*-----------------------------------------------------------------------------------------------------//
/*	Theme License and Updater
/*-----------------------------------------------------------------------------------------------------*/

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://organicthemes.com', // Site where EDD is hosted
		'item_name' => 'Purpose Theme + Support & Updates Subscription', // Name of theme
		'theme_slug' => 'purpose', // Theme slug
		'version' => '1.3', // The current version of this theme
		'author' => 'Organic Themes', // The author of this theme
		'download_id' => '168400', // Optional, used for generating a license renewal link
		'renew_url' => '' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license' => __( 'Theme License', 'organicthemes' ),
		'enter-key' => __( 'Enter your theme license key.', 'organicthemes' ),
		'license-key' => __( 'License Key', 'organicthemes' ),
		'license-action' => __( 'License Action', 'organicthemes' ),
		'deactivate-license' => __( 'Deactivate License', 'organicthemes' ),
		'activate-license' => __( 'Activate License', 'organicthemes' ),
		'status-unknown' => __( 'License status is unknown.', 'organicthemes' ),
		'renew' => __( 'Renew?', 'organicthemes' ),
		'unlimited' => __( 'unlimited', 'organicthemes' ),
		'license-key-is-active' => __( 'License key is active.', 'organicthemes' ),
		'expires%s' => __( 'Expires %s.', 'organicthemes' ),
		'%1$s/%2$-sites' => __( 'You have %1$s / %2$s sites activated.', 'organicthemes' ),
		'license-key-expired-%s' => __( 'License key expired %s.', 'organicthemes' ),
		'license-key-expired' => __( 'License key has expired.', 'organicthemes' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'organicthemes' ),
		'license-is-inactive' => __( 'License is inactive.', 'organicthemes' ),
		'license-key-is-disabled' => __( 'License key is disabled.', 'organicthemes' ),
		'site-is-inactive' => __( 'Site is inactive.', 'organicthemes' ),
		'license-status-unknown' => __( 'License status is unknown.', 'organicthemes' ),
		'update-notice' => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'organicthemes' ),
		'update-available' => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'organicthemes' )
	)

);
