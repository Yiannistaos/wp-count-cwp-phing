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
class CountCWP_Admin___PROCLASS {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * This fields
	 *
	 * @var [class]
	 */
	public $fields;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->plugin_name_clean = 'count-cwp';
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) 
	{
        if ('edit.php' === $hook || 'post-new.php' === $hook || 'post.php' === $hook || 'settings_page_count-cwp' === $hook) {
            wp_enqueue_style($this->plugin_name_clean, plugin_dir_url(__FILE__) . 'css/admin.min.css', array(), $this->version, 'all');
        }
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) 
	{
		if ('edit.php' === $hook || 'post-new.php' === $hook || 'post.php' === $hook){
			wp_enqueue_script( $this->plugin_name_clean, plugin_dir_url( __FILE__ ) . 'js/admin.min.js', array(), null, true );

			// Get options
			$options = (object) get_option( 'count_cwp_options' );
			$count_cwp_show_characters_option = (isset($options->count_cwp_show_characters)) ? $options->count_cwp_show_characters : true;
			$count_cwp_show_words_option = (isset($options->count_cwp_show_words)) ? $options->count_cwp_show_words : true;
			$count_cwp_show_paragraphs_option = (isset($options->count_cwp_show_paragraphs)) ? $options->count_cwp_show_paragraphs : true;
			$count_cwp_show_spaces_option = (isset($options->count_cwp_show_spaces)) ? $options->count_cwp_show_spaces : true;
			$count_cwp_show_copyright_link_option = (isset($options->count_cwp_show_copyright_link)) ? $options->count_cwp_show_copyright_link : true;

			// Localize the script with new data
			$translation_array = array(
				// Options
				'show_characters' => $count_cwp_show_characters_option,
				'show_words' => $count_cwp_show_words_option,
				'show_paragraphs' => $count_cwp_show_paragraphs_option,
				'show_spaces' => $count_cwp_show_spaces_option,
				'show_copyright_link' => $count_cwp_show_copyright_link_option,
				
				// Strings
				'words' => __( 'Words', 'count-cwp' ),
				'characters' => __( 'Characters', 'count-cwp' ),
				'paragraphs' => __( 'Paragraphs', 'count-cwp' ),
				'spaces' => __( 'Spaces', 'count-cwp' ),
			);
  			wp_localize_script( $this->plugin_name_clean, 'w357CountCWP', $translation_array);

		}
	}
}