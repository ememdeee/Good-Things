<?php
/**
 * UnderStrap functions and definitions
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

define('CD_DISABLE_BLOG_ARCHIVES', false);

// UnderStrap's includes directory.
$understrap_inc_dir = get_template_directory() . '/inc';

// Array of files to include.
$understrap_includes = array(
	'/utilities.php',
	'/theme-settings.php',					// Initialize theme default settings.
	'/setup.php',							// Theme setup and custom theme supports.
	'/enqueue.php',							// Enqueue scripts and styles.
	'/template-tags.php',					// Custom template tags for this theme.
	'/pagination.php',						// Custom pagination for this theme.
	'/hooks.php',							// Custom hooks.
	'/extras.php',							// Custom functions that act independently of the theme templates.
	'/class-wp-bootstrap-navwalker.php',	// Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.

	'/nav.php',								// register nav locations
	'/shortcodes.php',						// shortcodes
	'/acf.php',								// ACF
	'/gutenberg-blocks.php',				// gutenberg custom section blocks and settings
);

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once $understrap_inc_dir . $file;
}






// workaround for WP All Import http_request_failed";a:1:{i:0;s:78:"cURL error 60: SSL certificate problem: unable to get local issuer
// when trying to import images from remote https url
add_filter( 'https_local_ssl_verify', '__return_false' );
add_filter( 'https_ssl_verify', '__return_false');



/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
	 }
	 add_action( 'init', 'disable_emojis' );
	 
	 /**
	* Filter function used to remove the tinymce emoji plugin.
	* 
	* @param array $plugins 
	* @return array Difference betwen the two arrays
	*/
	 function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
	return array();
	}
	 }
	 
	 /**
	* Remove emoji CDN hostname from DNS prefetching hints.
	*
	* @param array $urls URLs to print for resource hints.
	* @param string $relation_type The relation type the URLs are printed for.
	* @return array Difference betwen the two arrays.
	*/
	 function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
	/** This filter is documented in wp-includes/formatting.php */
	$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
	 
	 $urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
	 
	 return $urls;
}


function dequeue_jquery_migrate( $scripts ) {
	if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
		$scripts->registered['jquery']->deps = array_diff(
			$scripts->registered['jquery']->deps,
			[ 'jquery-migrate' ]
		);
	}
}
add_action( 'wp_default_scripts', 'dequeue_jquery_migrate' );	 


function default_product_image_id() {
	return 438;
}

// exceprt length
function cd_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'cd_excerpt_length' );

function cd_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'cd_excerpt_more' );


/*remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );*/


// order by display_order
function custom_taxonomy_orderby_display_order( $query ) {
	if ( is_tax( 'ap_category' ) && $query->is_main_query() ) {
		$query->set( 'meta_key', 'display_order' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
	}
}
add_action( 'pre_get_posts', 'custom_taxonomy_orderby_display_order' );




// default image insert as full size
function cd_custom_image_size() {
	// Set default values for the upload media box
	update_option('image_default_size', 'full' );

}
add_action('after_setup_theme', 'cd_custom_image_size');

// this is just for debugging, to load css as separate files instead of inline
add_filter( 'should_load_separate_core_block_assets', '__return_true' );
add_filter( 'styles_inline_size_limit', '__return_zero' );


// ClueEdit: disable wordpress search, as clue doesn't seem to offer search functionality
function disable_search($query, $error = true)
{
    if (is_search() && !is_admin()) {
        $query->is_search = false;
        $query->query_vars['s'] = false;
        $query->query['s'] = false;

        // to error

        if ($error == true) $query->is_404 = true;
    }
}

// add_action('parse_query', 'disable_search');
// add_filter('get_search_form', '__return_null');


function cd_disable_archives()
{
    if(is_tag() || is_category() || is_date() || is_author())
    {
        // global $wp_query;
        // $wp_query->set_404();
				wp_redirect(home_url('/blog'));
        exit;				
    }
}
function cd_remove_taxonomy_archives_from_menus($items, $args) {
	foreach ($items as $key => $item) {
			if (strpos($item->url, 'category') !== false || strpos($item->url, 'tag') !== false) {
					unset($items[$key]);
			}
	}
	return $items;
}

if (CD_DISABLE_BLOG_ARCHIVES) {
	add_action('template_redirect', 'cd_disable_archives');
	add_filter('wp_nav_menu_objects', 'cd_remove_taxonomy_archives_from_menus', 10, 2);
}

// // ClueEdit: disable pagination on blog page
// function disable_paging_on_blog_page() {
//     if (is_paged() && is_page('blog')) {
//         // Get the current URL without pagination
//         $current_url = get_permalink(get_queried_object_id());

//         // Redirect to the main URL without pagination
//         wp_redirect($current_url, 302);
//         exit;
//     }
// }
// add_action('template_redirect', 'disable_paging_on_blog_page');

add_filter('paginate_links', function($link) {
    return untrailingslashit($link);
});