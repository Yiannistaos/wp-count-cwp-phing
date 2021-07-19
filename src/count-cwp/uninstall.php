<?php
/* ======================================================
 # [EXTENSION_REAL_NAME] for [CMS] - v[VERSION] ([FREE_PRO_VERSION] version)
 # -------------------------------------------------------
 # [FOR_CMS]
 # Author: [AUTHOR]
 # [COPYRIGHT]
 # License: [LICENSE]
 # Website: [WEBSITE]
 # Demo: [DEMO]
 # Support: [SUPPORT_EMAIL]
 # Last modified: [LAST_MODIFIED]
 ========================================================= */
 
/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if (
	!defined( 'WP_UNINSTALL_PLUGIN' )
	||
	!WP_UNINSTALL_PLUGIN
	||
	dirname( WP_UNINSTALL_PLUGIN ) != dirname( plugin_basename( __FILE__ ) )
) {
	status_header( 404 );
	exit;
}

// Delete the options from database
// delete_option('count_cwp_options');