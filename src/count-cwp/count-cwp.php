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
 * Plugin Name:       Count Characters, Words and Paragraphs while typing[SHOW_PRO_ONLY_IF_IS_PRO]
 * Plugin URI:        https://www.web357.com/product/count-words-characters-paragraphs-wordpress-plugin
 * Description:       [WP_PLUGIN_SHORT_DESCRIPTION]
 * Version:           [WP_PLUGIN_VERSION]
 * Author:            Web357
 * Author URI:        https://www.web357.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       count-cwp[TEXTDOMAIN_SUFFIX_FOR_PRO]
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
if ( !defined( 'COUNTCWP_VERSION' ) ) {
	define( 'COUNTCWP_VERSION', '[WP_PLUGIN_VERSION]' );
}

/**
 * The code that runs during plugin activation.
 */
function activate_CountCWP___PROCLASS() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activator.php';
	CountCWP_Activator___PROCLASS::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_CountCWP___PROCLASS() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivator.php';
	CountCWP_Deactivator___PROCLASS::deactivate();
}

register_activation_hook( __FILE__, 'activate_CountCWP___PROCLASS' );
register_deactivation_hook( __FILE__, 'deactivate_CountCWP___PROCLASS' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-main.php';

/**
 * Begins execution of the plugin.
 */
function run_CountCWP___PROCLASS() 
{
	$plugin = new CountCWP___PROCLASS();
	$plugin->run();
}
run_CountCWP___PROCLASS();

// Load the main functionality of plugin
require_once (plugin_dir_path( __FILE__ ) . 'includes/class-w357-count-cwp.php');