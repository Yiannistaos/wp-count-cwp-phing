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
 * Fired during plugin activation
 */
class CountCWP_Activator___PROCLASS {

	public static function activate() {
		self::populate_post_counts_on_activation();
	}

	public static function populate_post_counts_on_activation() {
		require_once plugin_dir_path(__FILE__) . 'class-w357-count-cwp.php';
		$plugin = new w357CountCWP___PROCLASS();

		// Fetch all posts
		$args = array(
			'post_type'      => 'post', // Adjust if you need to include custom post types
			'posts_per_page' => 100,    // Number of posts to process per batch
			'post_status'    => 'publish', // Fetch only published posts, adjust if necessary
			'fields'         => 'ids'   // Retrieve only the IDs for performance
		);

		$post_ids = get_posts($args);

		foreach ($post_ids as $post_id) {
			// Fetch the post content
			$post_content = get_post_field('post_content', $post_id);

			// Calculate counts
			$counts = array(
				'words' => $plugin->count_words($post_content),
				'characters' => $plugin->count_characters_without_spaces($post_content),
				'paragraphs' => $plugin->count_paragraphs($post_content),
				'spaces' => $plugin->count_spaces($post_content)
			);

			$total_count = array_sum($counts);

			// Update post meta
			update_post_meta($post_id, 'post_counts', $counts);
			update_post_meta($post_id, 'total_count', $total_count);
		}

		// Check if there are more posts to process
		$total_posts = count($post_ids);
		$posts_processed = 0;
		while ($total_posts > $posts_processed) {
			// Fetch next batch of posts
			$args['offset'] = $posts_processed;
			$next_post_ids = get_posts($args);

			// Process next batch of posts
			foreach ($next_post_ids as $post_id) {
				// Fetch the post content
				$post_content = get_post_field('post_content', $post_id);

				// Calculate counts
				$counts = array(
					'words' => $plugin->count_words($post_content),
					'characters' => $plugin->count_characters_without_spaces($post_content),
					'paragraphs' => $plugin->count_paragraphs($post_content),
					'spaces' => $plugin->count_spaces($post_content)
				);

				$total_count = array_sum($counts);

				// Update post meta
				update_post_meta($post_id, 'post_counts', $counts);
				update_post_meta($post_id, 'total_count', $total_count);
			}

			// Update processed post count
			$posts_processed += count($next_post_ids);
		}
	}
}
