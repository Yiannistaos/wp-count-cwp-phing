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
class CountCWP_settings___PROCLASS {

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
		$this->version = $version;
		$this->fields = new CountCWP_fields___PROCLASS();
	}

	/**
	 * Adds the option in WordPress Admin menu
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function options_page() 
	{
		add_options_page( 
			esc_html__( 'Count CWP settings', 'count-cwp'),
			'Count CWP',
			'manage_options', 
			'count-cwp',
			array($this, 'options_page_content') 
		);
	}

	/**
	 * Adds the admin page content
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function options_page_content() 
	{
		include_once(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings-view.php');
	}

	/**
	 * Function that will validate all fields.
	 */
	public function validateSettings( $fields ) 
	{ 
		$options = get_option( 'count_cwp_options' );
		$valid_fields = array();
		$message = null;
		$type = null;

		// Validate "count_cwp_show_characters" Field
		$count_cwp_show_characters = trim( $fields['count_cwp_show_characters'] );
		$count_cwp_show_characters = strip_tags( stripslashes( $count_cwp_show_characters ) );
		$valid_fields['count_cwp_show_characters'] = $count_cwp_show_characters;

		// Validate "count_cwp_show_words" Field
		$count_cwp_show_words = trim( $fields['count_cwp_show_words'] );
		$count_cwp_show_words = strip_tags( stripslashes( $count_cwp_show_words ) );
		$valid_fields['count_cwp_show_words'] = $count_cwp_show_words;

		// Validate "count_cwp_show_paragraphs" Field
		$count_cwp_show_paragraphs = trim( $fields['count_cwp_show_paragraphs'] );
		$count_cwp_show_paragraphs = strip_tags( stripslashes( $count_cwp_show_paragraphs ) );
		$valid_fields['count_cwp_show_paragraphs'] = $count_cwp_show_paragraphs;

		// Validate "count_cwp_show_spaces" Field
		$count_cwp_show_spaces = trim( $fields['count_cwp_show_spaces'] );
		$count_cwp_show_spaces = strip_tags( stripslashes( $count_cwp_show_spaces ) );
		$valid_fields['count_cwp_show_spaces'] = $count_cwp_show_spaces;

		// Validate "count_cwp_show_copyright_link" Field
		$count_cwp_show_copyright_link = trim( $fields['count_cwp_show_copyright_link'] );
		$count_cwp_show_copyright_link = strip_tags( stripslashes( $count_cwp_show_copyright_link ) );
		$valid_fields['count_cwp_show_copyright_link'] = $count_cwp_show_copyright_link;

		return apply_filters( 'validateSettings', $valid_fields, $fields);
	}

	/**
	 * Initialize the settings link
	 *
	 * @access   public
	 */
	public function settings_link($links) 
	{
		$link = 'options-general.php?page=' . 'count-cwp';
		$settings_link = '<a href="'.esc_url($link).'">'.esc_html__( 'Settings', 'count-cwp' ).'</a>';
		array_push( $links, $settings_link );
		return $links;
	}

	/**
	 * Initialize the settings page
	 *
	 * @since    3.2.0
	 * @access   public
	 */
	public function settings_init() 
	{
		/**
		 * REGISTER SETTINGS
		 */
		register_setting( 'count-cwp', 'count_cwp_options', array($this, 'validateSettings'));

		/**
		 * SECTIONS
		 */
		add_settings_section(
			'base_settings_section', 
			'', 
			'',
			'count-cwp'
		);

		/**
		 * Define Vars
		 */
		$options = get_option( 'count_cwp_options' );

		/**
		 * FIELDS
		 */		
		add_settings_field( 
			'count_cwp_show_characters', 
			esc_html__( 'Show Characters', 'count-cwp' ), 
			array($this->fields, 'selectField'),
			'count-cwp', 
			'base_settings_section',
			[
				'id' => 'count_cwp_show_characters',
				'default_value' => '1',
				'options' => [
					['id' => '1', 'label' => esc_html__('Yes', 'count-cwp'), 'value' => '1'],
					['id' => '0', 'label' => esc_html__('No', 'count-cwp'), 'value' => '0'],
				],
				'desc' => __('Choose if you want to display the count of characters below each HTML textarea tag.', 'count-cwp'),
			]
		);

		add_settings_field( 
			'count_cwp_show_words', 
			esc_html__( 'Show Words', 'count-cwp' ), 
			array($this->fields, 'selectField'),
			'count-cwp', 
			'base_settings_section',
			[
				'id' => 'count_cwp_show_words',
				'default_value' => '1',
				'options' => [
					['id' => '1', 'label' => esc_html__('Yes', 'count-cwp'), 'value' => '1'],
					['id' => '0', 'label' => esc_html__('No', 'count-cwp'), 'value' => '0'],
				],
				'desc' => __('Choose if you want to display the count of words below each HTML textarea tag.', 'count-cwp'),
			]
		);

		add_settings_field( 
			'count_cwp_show_paragraphs', 
			esc_html__( 'Show Paragraphs', 'count-cwp' ), 
			array($this->fields, 'selectField'),
			'count-cwp', 
			'base_settings_section',
			[
				'id' => 'count_cwp_show_paragraphs',
				'default_value' => '1',
				'options' => [
					['id' => '1', 'label' => esc_html__('Yes', 'count-cwp'), 'value' => '1'],
					['id' => '0', 'label' => esc_html__('No', 'count-cwp'), 'value' => '0'],
				],
				'desc' => __('Choose if you want to display the count of paragraphs below each HTML textarea tag.', 'count-cwp'),
			]
		);

		add_settings_field( 
			'count_cwp_show_spaces', 
			esc_html__( 'Show Spaces', 'count-cwp' ), 
			array($this->fields, 'selectField'),
			'count-cwp', 
			'base_settings_section',
			[
				'id' => 'count_cwp_show_spaces',
				'default_value' => '0',
				'options' => [
					['id' => '1', 'label' => esc_html__('Yes', 'count-cwp'), 'value' => '1'],
					['id' => '0', 'label' => esc_html__('No', 'count-cwp'), 'value' => '0'],
				],
				'desc' => __('Choose if you want to display the count of spaces below each HTML textarea tag.', 'count-cwp'),
			]
		);

		add_settings_field( 
			'count_cwp_show_copyright_link', 
			esc_html__( 'Show Copyright link', 'count-cwp' ), 
			array($this->fields, 'selectField'),
			'count-cwp', 
			'base_settings_section',
			[
				'id' => 'count_cwp_show_copyright_link',
				'default_value' => '1',
				'options' => [
					['id' => '1', 'label' => esc_html__('Yes', 'count-cwp'), 'value' => '1'],
					['id' => '0', 'label' => esc_html__('No', 'count-cwp'), 'value' => '0'],
				],
				'desc' => __('Help the developer of this free WordPress plugin and display the copyright link below the counter.', 'count-cwp'),
			]
		);
	}
}
