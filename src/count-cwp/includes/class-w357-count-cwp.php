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
 
class w357CountCWP___PROCLASS
{
	/**
	 * Sets up all the filters and actions.
	 */
	public function run()
	{
		add_filter( 'mce_external_plugins', array($this, 'w357_tinymce_plugin') );
	}

	function w357_tinymce_plugin($init) {
		$init['keyup_event'] = plugins_url( 'count-cwp' ) . '/admin/js/tinymce-keyup.js';
		return $init;
	}
}

$plugin = new w357CountCWP___PROCLASS();
$plugin->run();