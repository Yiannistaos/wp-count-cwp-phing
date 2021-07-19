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
 * Define the internationalization functionality
 */
class CountCWP_i18n___PROCLASS {

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'count-cwp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages'
		);

	}
}