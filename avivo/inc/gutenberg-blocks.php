<?php
//=============================================================================
// Gutenberg Blocks Setup
//-----------------------------------------------------------------------------
// Custom Gutenberg blocks created using Advanced Custom Fields (ACF).
// Includes additional settings and configurations for the Gutenberg editor.
// Specific configurations related to custom blocks and their functionality.
//=============================================================================


// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Add a custom block category for the Gutenberg editor
function cd_theme_block_categories( $categories ) {
	return array_merge(
		array(
			array(
				'slug'	=> 'theme-blocks',
				'title'	=> __( 'Custom Sections', 'theme-text-domain' ),
				'icon'	=> 'star-filled', // Optional icon (uses Dashicons)
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'cd_theme_block_categories', 10, 2 );

/**
 * Registers custom ACF blocks with WordPress.
 *
 * This function registers custom ACF blocks by looping through an array of block directories.
 * Each directory should contain a `block.json` file, which defines the block's attributes, 
 * scripts, styles, and other settings.
 *
 * The block directories are specified relative to the theme directory. You can update the paths
 * in the `$block_directories` array to match the locations of your block directories.
 *
 * Ensure that this function is hooked to the `init` action to register the blocks during the
 * WordPress initialization phase.
 *
 * Example block directories:
 * - '/blocks/carousel'
 * - '/blocks/intro-text'
 *
 * @return void
 */
function cd_register_acf_blocks() {
    // Array of block directories using relative paths
    $block_directories = array(
		'/blocks/hero-banner',
		'/blocks/featured-banner',
		'/blocks/heading-bar',
		'/blocks/intro-text',
		'/blocks/quick-links',
		'/blocks/page-title-banner',
		'/blocks/featured-statement',
		'/blocks/featured-tiles',
		'/blocks/icon-grid',
		'/blocks/flip-cards',
		'/blocks/featured-links',
		'/blocks/featured-list',
		'/blocks/richtext-featured-tiles',
		'/blocks/richtext-image-blob',
		'/blocks/logo-grid',
		'/blocks/logo-slider',
		'/blocks/richtext-logo-grid',
		'/blocks/featured-image',
		'/blocks/video-banner',
		'/blocks/richtext-image',
		'/blocks/featured-slider',
		'/blocks/carousel',
		'/blocks/timeline-slider',
		'/blocks/workflow-slider',
		'/blocks/testimonial-slider',
		'/blocks/testimonial-slider-small',
		'/blocks/featured-faq',
		'/blocks/richtext-toggle',
		'/blocks/profile-grid',
		'/blocks/richtext-form',
		'/blocks/calendly-form',
		'/blocks/post-grid',
		'/blocks/featured-posts',
		'/blocks/post-slider',
		'/blocks/case-study-grid',
		'/blocks/case-study-slider',
		'/blocks/case-study-info',
		'/blocks/richtext-chapter',
		'/blocks/key-stats',
		'/blocks/button-row',
		'/blocks/hero-slider',
		'/blocks/content-slider',
		'/blocks/card-slider',
		'/blocks/hero-animation',
		'/blocks/tab-group',
		'/blocks/tab-panel',
		'/blocks/content-sidebar',
		'/blocks/availability-finder',
		'/blocks/card-grid',
		'/blocks/video-lightbox',
		'/blocks/article-spotlight',
		'/blocks/text-image',
		'/blocks/tiles-slider',
		);

	// Define the template directory path
	$template_directory_path = get_template_directory();

	// Loop through each directory and register the block type
	foreach ( $block_directories as $dir ) {
		register_block_type( $template_directory_path . $dir );
	}
}
// Hook the function to the 'init' action
add_action( 'init', 'cd_register_acf_blocks' );

/**
 * Filter allowed blocks for specific parent blocks
 * This enforces block restrictions for ACF blocks since innerBlocks.allowedBlocks doesn't work reliably with ACF
 */
function cd_filter_allowed_blocks( $allowed_blocks, $block_editor_context ) {
    // Check if we're in the block editor and have a parent block
    if ( isset( $block_editor_context->post ) ) {
        // Get the current post content to check for parent blocks
        $post_content = $block_editor_context->post->post_content;
        
        // If we're inside a tab-group block, only allow tab-panel blocks
        if ( strpos( $post_content, 'wp:acf/tab-group' ) !== false ) {
            // You can also check for more specific conditions here
            // For now, we'll return the restricted list when tab-group is present
            return array( 'acf/tab-panel' );
        }
    }
    
    return $allowed_blocks;
}
add_filter( 'allowed_block_types_all', 'cd_filter_allowed_blocks', 10, 2 );

/**
 * Enqueues and registers assets for the block editor.
 *
 * This function handles the enqueuing and registration of CSS and JS assets needed for
 * the block editor. It includes styles and scripts for various blocks, ensuring they are
 * loaded with correct dependencies and versioning.
 *
 * Assets are registered with version numbers based on file modification times to ensure
 * browsers load the latest versions. The registered assets are then enqueued for use in
 * the block editor.
 *
 * @return void
 */
function cd_enqueue_block_editor_assets() {
	// Define asset handles and paths
	$template_directory_uri = get_template_directory_uri();
	$template_directory_path = get_template_directory();

	$assets = array(
		// The editor JS and CSS
		'theme-editor-script' => array(
			'type'		=> 'script',
			'src'		=> $template_directory_uri . '/js/editor-script.min.js',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/js/editor-script.min.js'),
			'in_footer'	=> true
		),
		'theme-editor-styles' => array(
			'type'		=> 'style',
			'src'		=> $template_directory_uri . '/css/custom-editor-style.min.css',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/css/custom-editor-style.min.css')
		),

		// Splide Slider JS and CSS - library
		'splide-slider-script' => array(
			'type'		=> 'script',
			'src'		=> $template_directory_uri . '/js/splide.min.js',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/js/splide.min.js'),
			'in_footer'	=> true
		),
		'splide-slider-style' => array(
			'type'		=> 'style',
			'src'		=> $template_directory_uri . '/css/splide.min.css',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/css/splide.min.css')
		),
		'splide-slider-autoscroll-script' => array(
			'type'		=> 'script',
			'src'		=> $template_directory_uri . '/js/splide-extension-auto-scroll.min.js',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/js/splide-extension-auto-scroll.min.js'),
			'in_footer'	=> true,
		),

		// noUiSlider JS and CSS - library
		'nouislider-script' => array(
			'type'		=> 'script',
			'src'		=> $template_directory_uri . '/js/nouislider.min.js',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/js/nouislider.min.js'),
			'in_footer'	=> true,
		),
		'nouislider-style' => array(
			'type'		=> 'style',
			'src'		=> $template_directory_uri . '/css/nouislider.min.css',
			'deps'		=> array(),
			'version'	=> filemtime($template_directory_path . '/css/nouislider.min.css'),
		),

	);

	// Register and enqueue assets
	foreach ($assets as $handle => $data) {
		if ($data['type'] === 'style') {
			wp_enqueue_style($handle, $data['src'], $data['deps'], $data['version']);
		} elseif ($data['type'] === 'script') {
			wp_enqueue_script($handle, $data['src'], $data['deps'], $data['version'], $data['in_footer']);
		}
	}
}
// Hook the function to the 'enqueue_block_editor_assets' action
add_action('enqueue_block_editor_assets', 'cd_enqueue_block_editor_assets');


// Remove Gutenberg default patterns
function cd_remove_block_patterns() {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'cd_remove_block_patterns' );

// Define allowed block types
function cd_allowed_block_types($allowed_blocks, $post) {
	// List of blocks to keep
	$blocks_to_keep = array(
		// for reusable block - create pattern
		'core/block',
		
		// Text Blocks
		'core/paragraph',
		'core/heading',
		'core/list',
		'core/list-item',
		'core/quote',
		'core/table',
		'core/classic',

		// Media Blocks
		'core/image',
		'core/video',

		// Design Blocks
		'core/column',
		'core/columns',
		'core/group',
		'core/row',
		'core/stack',
		'core/grid',
		'core/separator',
		'core/spacer',

		// Widget Blocks
		'core/html',
		'core/shortcode',

		// Embed Blocks
		'gravityforms/form',

		// Custom Sections
		'acf/hero-banner',
		// 'acf/featured-banner',
		// 'acf/heading-bar',
		'acf/intro-text',
		'acf/quick-links',
		'acf/page-title-banner',
		'acf/featured-statement',
		'acf/featured-tiles',
		'acf/icon-grid',
		'acf/flip-cards',
		'acf/featured-links',
		'acf/featured-list',
		'acf/richtext-featured-tiles',
		'acf/richtext-image-blob',
		'acf/logo-grid',
		'acf/logo-slider',
		// 'acf/richtext-logo-grid',
		// 'acf/featured-image',
		// 'acf/video-banner',
		// 'acf/richtext-image',
		// 'acf/featured-slider',
		// 'acf/carousel',
		// 'acf/timeline-slider',
		// 'acf/workflow-slider',
		// 'acf/testimonial-slider',
		'acf/testimonial-slider-small',
		'acf/featured-faq',
		// 'acf/richtext-toggle',
		'acf/profile-grid',
		'acf/richtext-form',
		// 'acf/calendly-form',
		// 'acf/post-grid',
		// 'acf/featured-posts',
		'acf/post-slider',
		// 'acf/case-study-grid',
		'acf/case-study-slider',
		// 'acf/case-study-info',
		// 'acf/richtext-chapter',
		// 'acf/key-stats',
		'acf/button-row',
		'acf/hero-slider',
		'acf/card-slider',
		//	'acf/content-slider',
		'acf/hero-animation',
		'acf/tab-group',
		'acf/tab-panel',
		'acf/content-sidebar',
		'acf/availability-finder',
		'acf/card-grid',
		'acf/video-lightbox',
		'acf/article-spotlight',
		'acf/text-image',
		'acf/tiles-slider',
	);

	// Add support for patterns (WordPress 5.8+)
//	if (function_exists('register_block_pattern_category')) {
//		$blocks_to_keep[] = 'core/pattern'; // Allow the pattern block
//
//		// Ensure patterns can be registered and saved
//		register_block_pattern_category(
//			'custom-patterns',
//			array('label' => __('Custom Patterns', 'text-domain'))
//		);
//	}
	
	// Return the list of allowed blocks
	return $blocks_to_keep;
}
add_filter('allowed_block_types_all', 'cd_allowed_block_types', 10, 2);

/*
function cd_add_default_carousel_item( $post_id ) {
    // Check if this is an autosave
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }

    // Check if this is a valid post and of type 'acf'
    if ( get_post_type($post_id) !== 'acf') {
        return;
    }

    // Check if the block is of type 'acf/carousel'
    if ( get_post_meta($post_id, '_edit_lock', true) || get_post_meta($post_id, '_edit_last', true) ) {
        $block_type = get_post_meta($post_id, 'block_type', true);
        if ($block_type !== 'acf/carousel') {
            return;
        }
    }

    // Get the repeater field value
    $repeater_field_key = 'section_content_slider'; // Adjust to your repeater field key
    $values = get_field($repeater_field_key, $post_id);

    // Check if the repeater field is empty
    if ( empty($values) ) {
        // Add a default item to the repeater field
        $default_item = array(
            'slide_title'       => 'Slide Title',
            'slide_description' => 'Slide description',
        );

        // Add the default item
        add_row($repeater_field_key, $default_item, $post_id);
    }
}

add_action('acf/save_post', 'cd_add_default_carousel_item', 20);
*/

// Wrap non-custom blocks in <div class="container">
function cd_wrap_non_custom_blocks_in_container( $block_content, $block ) {
	// Define your custom block names to skip wrapping
	$custom_blocks = array(
		'acf/hero-banner',
		'acf/featured-banner',
		'acf/heading-bar',
		'acf/intro-text',
		'acf/quick-links',
		'acf/page-title-banner',
		'acf/featured-statement',
		'acf/featured-tiles',
		'acf/icon-grid',
		'acf/flip-cards',
		'acf/featured-links',
		'acf/featured-list',
		'acf/richtext-featured-tiles',
		'acf/richtext-image-blob',
		'acf/logo-grid',
		'acf/logo-slider',
		'acf/richtext-logo-grid',
		'acf/featured-image',
		'acf/video-banner',
		'acf/richtext-image',
		'acf/featured-slider',
		'acf/carousel',
		'acf/timeline-slider',
		'acf/workflow-slider',
		'acf/testimonial-slider',
		'acf/testimonial-slider-small',
		'acf/featured-faq',
		'acf/richtext-toggle',
		'acf/profile-grid',
		'acf/richtext-form',
		'acf/calendly-form',
		'acf/post-grid',
		'acf/featured-posts',
		'acf/post-slider',
		'acf/case-study-grid',
		'acf/case-study-slider',
		'acf/case-study-info',
		'acf/richtext-chapter',
		'acf/key-stats',
		'acf/button-row',
		'acf/hero-slider',
		'acf/card-slider',
		'acf/hero-animation',
		'acf/tab-group',
		'acf/tab-panel',
		'acf/content-sidebar',
		'acf/availability-finder',
		'acf/card-grid',
		'acf/video-lightbox',
		'acf/article-spotlight',
		'acf/text-image',
		'acf/tiles-slider',
	);

	// Skip wrapping if blockName is null (e.g., <p> elements without a blockName)
	if ( is_null( $block['blockName'] ) || trim( $block_content ) === '' ) {
		return $block_content;
	}

	// Skip wrapping for custom blocks
	if ( in_array( $block['blockName'], $custom_blocks ) ) {
		return $block_content;
	}

	// Check if the block is part of a pattern
	if ( isset( $block['attrs']['ref'] ) ) {
		// This indicates a reusable block or a pattern
		return $block_content;
	}

	// skip if block is custom html
	if ( $block['blockName'] === 'core/html' ) {
		return $block_content;
	}

	return '<div class="container wpdblock">' . $block_content . '</div>';
}

// Apply filter
// add_filter( 'render_block', 'cd_wrap_non_custom_blocks_in_container', 10, 2 );

// Helper function to retrieve content from specified Gutenberg blocks with optional total length limit
function cd_get_acf_block_content($limit_length = false, $max_length = 3000) {
	$article_body = '';
	$current_length = 0; // Track the current length of the article body

	// Get the post content
	$post_content = get_the_content();

	// Parse the blocks in the content
	$blocks = parse_blocks($post_content);
//	var_dump($blocks);

	// Define the blocks to process
	$allowed_blocks = [
		'acf/hero-banner',
		'acf/featured-banner',
		'acf/heading-bar',
		'acf/intro-text',
		'acf/quick-links',
		'acf/page-title-banner',
		'acf/featured-statement',
		'acf/featured-tiles',
		'acf/icon-grid',
		'acf/flip-cards',
		'acf/featured-links',
		'acf/featured-list',
		'acf/richtext-featured-tiles',
		'acf/richtext-image-blob',
		'acf/richtext-logo-grid',
		'acf/richtext-image',
		'acf/featured-slider',
		'acf/carousel',
		'acf/timeline-slider',
		'acf/workflow-slider',
		'acf/richtext-toggle',
		'acf/profile-grid',
		'acf/richtext-form',
		'acf/richtext-chapter',
		'acf/hero-slider',
		'acf/content-slider',
		'acf/hero-animation',
		'acf/tab-group',
		'acf/tab-panel',
		'acf/content-sidebar',
		'acf/availability-finder',
		'acf/card-grid',
		'acf/video-lightbox',
		'acf/article-spotlight',
		'acf/text-image',
		'acf/tiles-slider',
	];

	// Process each block
	foreach ($blocks as $block) {
		if (in_array($block['blockName'], $allowed_blocks, true)) {
			$block_name = str_replace('acf/', '', $block['blockName']);
			$attrs = $block['attrs'];

			// Check for 'data' key in the attributes
			if (isset($attrs['data'])) {
				$data = $attrs['data'];

				// Extract relevant content based on block type
				switch ($block_name) {
					case 'hero-banner':
					case 'page-title-banner':
					case 'intro-text':
					case 'quick-links':
					case 'richtext-featured-tiles':
					case 'richtext-image-blob':
					case 'richtext-logo-grid':
					case 'richtext-image':
					case 'richtext-toggle':
					case 'richtext-form':
					case 'richtext-chapter':
					case 'featured-statement':
					case 'timeline-slider':
					case 'workflow-slider':
						// Check if title text exists and output it
						if (!empty($data['title_text'])) {
							$article_title .= '<h1>' . htmlspecialchars(strip_tags($data['title_text']), ENT_QUOTES, 'UTF-8') . '</h1> ';
							$article_body .= $article_title;
							$current_length += strlen($article_title);
						}
						
						// Check if subtitle exists and output it
						if (!empty($data['title_subheading_text'])) {
							$article_subtitle .= '<h2>' . htmlspecialchars(strip_tags($data['title_subheading_text']), ENT_QUOTES, 'UTF-8') . '</h2> ';
							$article_body .= $article_subtitle;
							$current_length += strlen($article_subtitle);
						}

						// Check description
						if (!empty($data['section_description'])) {
							$description = '<p>' . htmlspecialchars(strip_tags(str_replace(["\n", "\r"], " ", $data['section_description'])), ENT_QUOTES, 'UTF-8') . '</p>';
							
							// Limit content length if parameter is set
							if ($limit_length) {
								$remaining_length = $max_length - $current_length;

								// Use wp_html_excerpt to safely truncate HTML content without breaking tags
								if (strlen($description) > $remaining_length) {
									$description = wp_html_excerpt($description, $remaining_length) . '...'; // Truncate and add ellipsis
								}
							}

							$article_body .= $description . ' ';
							$current_length += strlen($description);
						}

						break;
						
					case 'carousel':
					case 'featured-banner':
					case 'featured-tiles':
					case 'icon-grid':
					case 'flip-cards':
					case 'profile-grid':
						// Initialize block body content
						$block_body = '';
					
						// Iterate over the data keys and extract repeater fields
						foreach ($data as $key => $value) {
							// Check if the key contains 'section_items' and ends with '_title_text' or '_item_profile_name'
							if (!empty($value) && strpos($key, 'section_items_') === 0 && preg_match('/_(title_text|item_profile_name)$/', $key)) {
								$block_body .= '<h2>' . htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8') . '</h2> ';
							}

							// Check if the key contains 'section_items' and ends with '_item_description', etc
							if (!empty($value) && strpos($key, 'section_items_') === 0 && preg_match('/_(item_description|section_description|item_profile_role|item_profile_description)$/', $key)) {
								$block_body .= '<p>' . htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8') . '</p> ';
							}
						}
					
						// Limit content length if parameter is set
						if ($limit_length) {
							$remaining_length = $max_length - $current_length;
					
							// Use wp_html_excerpt to safely truncate HTML content without breaking tags
							if (strlen($block_body) > $remaining_length) {
								$block_body = wp_html_excerpt($block_body, $remaining_length) . '...'; // Truncate and add ellipsis
							}
						}
						
						$article_body .= $block_body . ' ';
						$current_length += strlen($block_body);
						
						break;

				//	case 'featured-slider':
				//	case 'heading-bar':
					default:
						// others
						break;

				}
			}
		}

		// If the article body has exceeded the max length, stop processing further blocks
		if ($limit_length && $current_length >= $max_length) {
			break;
		}
	}

	return $article_body;
}

/* --- This is not working --- */
/*
function cd_append_acf_block_content($content) {
    if (is_singular('post') || is_page()) {
        // Get the ACF block content
        $acf_content = cd_get_acf_block_content(true, 3000);
        
        // Append it to the existing content
        $content .= $acf_content;
    }
    return $content;
}
add_filter('the_content', 'cd_append_acf_block_content');


add_filter('wpseo_pre_analysis_post_content', 'cd_append_acf_for_yoast');
function cd_append_acf_for_yoast($content) {
    if (is_singular('post') || is_page()) {
        // Get ACF block content
        $acf_content = cd_get_acf_block_content(true, 3000);
        
        // Append ACF content to the existing content
        $content .= ' ' . $acf_content;
    }
    return $content;
}
*/