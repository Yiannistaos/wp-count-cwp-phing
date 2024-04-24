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
		add_action('save_post', array($this, 'save_post_counts'), 10, 2);
		add_action('manage_posts_custom_column', array($this, 'fill_new_column'), 10, 2);
		add_filter('manage_posts_columns', array($this, 'add_new_column'));
		add_filter('manage_edit-post_sortable_columns', array($this, 'set_custom_post_sortable_columns'));
		add_action('pre_get_posts', array($this, 'custom_post_orderby'));
	}

	function w357_tinymce_plugin($init) {
		$init['keyup_event'] = plugins_url( 'count-cwp' ) . '/admin/js/tinymce-keyup.min.js';
		return $init;
	}

	function count_words($content) {
		$content = preg_replace("/\s+/", ' ', trim($content)); // Normalize spaces and trim
		return count(explode(' ', $content));
	}

	function count_characters_without_spaces($content) {
		$content = html_entity_decode($content); // Decode HTML entities to their applicable characters
		$content = strip_tags($content); // Remove HTML tags
		$content = preg_replace("/\s+/", '', $content); // Remove all whitespace
		return strlen($content);
	}

	function count_paragraphs($content) {
		$content = trim($content); // Trim leading and trailing whitespace
		if (empty($content)) return 0;
		return substr_count($content, "\n") + 1;
	}

	function count_spaces($content) {
		$content = preg_replace("/\s+/", ' ', trim($content)); // Normalize spaces and trim
		return substr_count($content, ' ');
	}

	function save_post_counts($post_id, $post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
		if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) return;
		if (!current_user_can('edit_post', $post_id)) return;

		$content = $post->post_content;

		$counts = array(
			'words' => $this->count_words($content),
			'characters' => $this->count_characters_without_spaces($content),
			'paragraphs' => $this->count_paragraphs($content),
			'spaces' => $this->count_spaces($content)
		);

	    $total_count = array_sum($counts);

		update_post_meta($post_id, 'post_counts', $counts);
	    update_post_meta($post_id, 'total_count', $total_count);
	}

	function add_new_column($columns) {
		$columns['all_counts'] = 'All Counts';
		return $columns;
	}

	function fill_new_column($column, $post_id) {
		if ('all_counts' === $column) {
			$counts = get_post_meta($post_id, 'post_counts', true);
			$options = (object) get_option('count_cwp_options');

			$show_characters = isset($options->count_cwp_show_characters) ? $options->count_cwp_show_characters : true;
			$show_words = isset($options->count_cwp_show_words) ? $options->count_cwp_show_words : true;
			$show_paragraphs = isset($options->count_cwp_show_paragraphs) ? $options->count_cwp_show_paragraphs : true;
			$show_spaces = isset($options->count_cwp_show_spaces) ? $options->count_cwp_show_spaces : true;

			if (is_array($counts)) {
				echo $show_words ? "Words: " . (isset($counts['words']) ? $counts['words'] : '-') . "<br>" : "";
				echo $show_characters ? "Characters: " . (isset($counts['characters']) ? $counts['characters'] : '-') . "<br>" : "";
				echo $show_paragraphs ? "Paragraphs: " . (isset($counts['paragraphs']) ? $counts['paragraphs'] : '-') . "<br>" : "";
				echo $show_spaces ? "Spaces: " . (isset($counts['spaces']) ? $counts['spaces'] : '-') : "";
			} else {
				echo 'Counts not available';
			}
		}
	}

	function set_custom_post_sortable_columns($columns) {
		$columns['all_counts'] = 'all_counts'; // Key should match the ID of the column
		return $columns;
	}

	function custom_post_orderby($query) {
		if (!is_admin() || !$query->is_main_query()) return;

		if ('all_counts' === $query->get('orderby')) {
			$query->set('meta_key', 'total_count');
        	$query->set('orderby', 'meta_value_num'); // Order by numeric value
		}
	}
}

$plugin = new w357CountCWP___PROCLASS();
$plugin->run();