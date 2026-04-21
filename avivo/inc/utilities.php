<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$cd_allowed_tags = [
    'a' => [
        'href' => [],
        'title' => []
    ],
    'br' => [],
    'em' => [],
    'u' => [],
		'i'	=> array(
				'class' => true,
				'style' => true,
		),
    'strong' => [],
	'span' => [],
	'img' => array(
        'src'    => true,
        'alt'    => true,
        'width'  => true,
        'height' => true,
        'class'  => true,
        'style'  => true,
    ),
		'span' => array(
				'class' => true,
				'style' => true,
		),
];


function cd_print_text($text) {
    global $cd_allowed_tags;
    // echo wpautop( $value['title'] );
    // echo esc_html( $value['title'] );
    // echo apply_filters( 'the_content', $value['title'] );

    return wp_kses($text, $cd_allowed_tags);
}

// print escape with wrap
function cd_print_wrap($text, $before, $after) {
    if ($text) {
        return $before . esc_html( $text ) . $after;
    } else {
        return '';
    }
}

// print kses with wrap
function cd_print_wrap_tags($text, $before, $after) {
    global $cd_allowed_tags;
    if ($text) {
        return $before . wp_kses($text, $cd_allowed_tags) . $after;
    } else {
        return '';
    }
}

// print richtext
function cd_print_richtext($text, $before, $after) {
    if ($text) {
        return $before . apply_filters( 'the_content', $text ) . $after;
    } else {
        return '';
    }
}

// for www.example.com/user/account you will get 'user'
function cd_get_second_segment_url() {
    $uri_segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    
    if (isset($uri_segments[0])) {
        return $uri_segments[0];
    } else {
        return false;
    }    
}

// for www.example.com/user/account you will get array 'user' and 'account'
function cd_get_segments_url() {
    $uri_segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    
    if (isset($uri_segments) && count($uri_segments) > 0) {
        return $uri_segments;
    } else {
        return false;
    }    
}


function cd_random_number($digits = 3) {
    // $digits = 3;
    return rand(pow(10, $digits-1), pow(10, $digits)-1);    
}

function text_max_charlength($text, $charlength) {
    $charlength++;
    $output = '';

	if ( mb_strlen( $text ) > $charlength ) {
		$subex = mb_substr( $text, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$output .= mb_substr( $subex, 0, $excut );
		} else {
			$output .= $subex;
		}
		$output .= '...';
	} else {
		$output .= $text;
    }
    
    return $output;
}


if (!function_exists('cd_render')) {
	/**
	 * @param string $path
	 * @param array $arguments
	 * @param bool $echo
	 */
	function cd_render($path, array $vars = [], bool $echo = true) {
		// Extract variables if $vars is not empty
		if (!empty($vars)) {
			extract($vars);
		}
	
		// Handle output based on $echo flag
		if ($echo) {
			include locate_template($path);
		} else {
			ob_start();
			include locate_template($path);
			$output = ob_get_clean(); // Simplifies ob_get_contents() and ob_end_clean()
			return $output;
		}
	}	
}

// get array item, if not exists return ''
if (!function_exists('cd_get_array_item')) {
	function cd_get_array_item($var, $index)
	{
		if (is_array($var)){
			return (array_key_exists($index, $var) ? $var[$index] : '');
		}
		return '';
	}
}

function cd_empty_content($str) {
    return trim(str_replace('&nbsp;','',strip_tags($str))) == '';
}

if ( ! function_exists( 'get_section_config_class' ) ) {
    function get_section_config_class($section_config) {
        // section_class;
        // section_style;
        // section_margin_top;
        // section_margin_bottom;
        // section_no_mb
        // section_bb
        $sizes = array(
            'xs' => array(0,1,2,2,3,4,4,5,6),
            'md' => array(0,1,2,3,4,5,5,6,7)
        );

        // var_dump($section_margin_bottom);
        $classes = array();
        // var_dump($section_config['section_margin_bottom']);
        if (isset($section_config['section_margin_bottom']) && is_numeric($section_config['section_margin_bottom'])) {
            $classes[] = 'mb-' . $sizes['xs'][$section_config['section_margin_bottom']];
            $classes[] = 'mb-md-' . $sizes['md'][$section_config['section_margin_bottom']];
            $classes[] = 'mb-lg-' .$section_config['section_margin_bottom'];
        } 
        
        if (isset($section_config['section_margin_top']) && is_numeric($section_config['section_margin_top'])) {
            $classes[] = 'mt-' . $sizes['xs'][$section_config['section_margin_top']];
            $classes[] = 'mt-md-' . $sizes['md'][$section_config['section_margin_top']];
            $classes[] = 'mt-lg' .$section_config['section_margin_top'];
        } 

        if (isset($section_config['section_hide_section']) && $section_config['section_hide_section'] === true) {
            $classes[] = 'sc-hide'; // 'd-none';
        }

        if (isset($section_config['section_class']) && $section_config['section_class'] !== '') {
            $classes[] = $section_config['section_class'];
        }

        if (isset($section_config['section_no_mb']) && $section_config['section_no_mb'] === true) {
            $classes[] = 'mb-0';
        }

        if (isset($section_config['section_bb']) && $section_config['section_bb'] === true) {
            $classes[] = 'section--bb';
        }

        return join( ' ', $classes );
    }
}

if ( ! function_exists( 'cd_get_width_class' ) ) {
    function cd_get_width_class($width, $breakpoint = 'md') {
        $class = 'col-'. $breakpoint .'-6 col-lg-3';
        if ($width === '100') {
            $class = 'col-12';
        } else if ($width === '50') {
            $class = 'col-'. $breakpoint .'-6';
        } else if ($width === '33.3') {
            $class = 'col-'. $breakpoint .'-4';
        } else if ($width === '25') {
            $class = 'col-'. $breakpoint .'-6 col-lg-3';
        } else if ($width === '20') {
            $class = 'col-'. $breakpoint .'-6 col-lg-fifth';
        } else {
            // default is 50%
            $class = 'col-'. $breakpoint .'-6';            
        }

        return $class;
    }
}

if ( ! function_exists( 'cd_au_state_code_to_name' ) ) {
	function cd_au_state_code_to_name($code) {
		$states = array(
			'WA'	=> 'Western Australia',
			'QLD'	=> 'Queensland',
			'VIC'	=> 'Victoria',
			'NSW'	=> 'New South Wales',
			'TAS'	=> 'Tasmania',
			'ACT'	=> 'Australian Capital Territory',
			'SA'	=> 'South Australia',
			'NT'	=> 'Northern Territory'
		);
	
		return isset($states[$code]) ? $states[$code] : '';
	}	
}

if ( ! function_exists( 'cd_current_paged' ) ) {
    function cd_current_paged( $var = '' ) {
        if( empty( $var ) ) {
            global $wp_query;
            if( !isset( $wp_query->max_num_pages ) )
                return;
            $pages = $wp_query->max_num_pages;
        }
        else {
            global $$var;
                if( !is_a( $$var, 'WP_Query' ) )
                    return;
            if( !isset( $$var->max_num_pages ) || !isset( $$var ) )
                return;
            $pages = absint( $$var->max_num_pages );
        }
        if( $pages < 1 )
            return;
        $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
        return 'Page ' . $page . ' of ' . $pages;
    }
}


if ( ! function_exists( 'cd_get_terms_value' ) ) {
    function cd_get_terms_value($term) {
        return $term->name;
    }
}

function get_term_depth($term, $taxonomy) {
    $depth = 0;
    $parent = $term->parent;
    while ($parent) {
        $depth++;
        $parent_term = get_term_by('id', $parent, $taxonomy);
        $parent = $parent_term->parent;
    }
    return $depth;
}

class Collapsible_Category_Walker extends Walker_Category {
    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"collapse\" id=\"collapse-$depth\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        // $indent = str_repeat("\t", $depth);
        // $has_children = !empty($args['has_children']);
        // $toggle = $has_children ? '<span class="toggle">+</span>' : '';
        // // $output .= "$indent<li>$toggle<a href=\"" . esc_url(get_category_link($category->term_id)) . "\">" . esc_html($category->name) . "</a>";
        // $output .= "$indent<li data-slug=\"" . esc_attr($category->slug) . "\">$toggle<a href=\"" . esc_url(get_category_link($category->term_id)) . "\">" . esc_html($category->name) . "</a>";

        $indent = str_repeat("\t", $depth);
        $has_children = !empty($args['has_children']);
        $toggle = $has_children ? '<span class="toggle">+</span>' : '';
        $class = $has_children ? 'has-children' : '';
        $output .= "$indent<li data-slug=\"" . esc_attr($category->slug) . "\" class=\"$class\"><a href=\"" . esc_url(get_category_link($category->term_id)) . "\">" . esc_html($category->name) . "</a>$toggle";

    }

    function end_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        $output .= "</li>\n";
    }
}



function cd_pluralize($count, $singular, $plural) {
    return sprintf("%s", ($count == 1 ? $singular : $plural));
}

// echo cd_pluralize(1, 'bathroom', 'bathrooms'); // Outputs: 1 bathroom
// echo cd_pluralize(2, 'bathroom', 'bathrooms'); // Outputs: 2 bathrooms



if ( ! function_exists( 'cd_get_section_config_class' ) ) {
	/**
	 * Generates a class string based on the provided configuration and custom class.
	 *
	 * @param array $config Configuration array containing section-related classes.
	 * @return string A space-separated string of classes to be applied to a section.
	 */
	function cd_get_section_config_class($config) {

		// Ensure $config is an array
		if ( ! is_array( $config ) ) {
			return '';
		}

		$classes = array();
		$classes[] = 'section';	// '.section' apply the section class

		// Add section classname if provided
		if (!empty($config['section_classname'])) {
			$classes[] = $config['section_classname']; // section block class naming, eg: cdb-content
		}

		// Add section color class if set, add prefix 'sc-'
		if (!empty($config['section_colour']) /*&& $config['section_colour'] !== 'default'*/) {
			$classes[] = 'sc-' . $config['section_colour'];
		}

		// Add section image first if the radio button is set to '1'
		if (!empty($config['section_image_first']) && $config['section_image_first'] === '1') {
			$classes[] = 'imagefirst';
		}

		// Add section column class if set, add prefix 'sco-'
		if (!empty($config['section_column'])) {
			$classes[] = 'sco-' . $config['section_column'];
		}

		// Add section column spacing class if set, add prefix 'scs-', default is 'no' spacing
		if (!empty($config['section_column_spacing']) && $config['section_column_spacing'] !== 'no') {
			$classes[] =  'scs-' . $config['section_column_spacing'];
		}
		
		// Default margin is none ('smt-no', 'smb-no'), so no need to show these classes
		if (isset($config['section_margin']) && is_array($config['section_margin'])) {
			if (isset($config['section_margin']['top']) && $config['section_margin']['top'] !== 'smt-no') {
				$classes[] = $config['section_margin']['top'];
			}
			if (isset($config['section_margin']['bottom']) && $config['section_margin']['bottom'] !== 'smb-no') {
				$classes[] = $config['section_margin']['bottom'];
			}
		}

		// Default padding is medium ('spt-md', 'spb-md'), so no need to show these classes
		if (isset($config['section_padding']) && is_array($config['section_padding'])) {
			if (isset($config['section_padding']['top']) && $config['section_padding']['top'] !== 'spt-md') {
				$classes[] = $config['section_padding']['top'];
			}
			if (isset($config['section_padding']['bottom']) && $config['section_padding']['bottom'] !== 'spb-md') {
				$classes[] = $config['section_padding']['bottom'];
			}
		}

		// Add section-specific class if set by user
		if (!empty($config['section_class'])) {
			// $classes[] = sanitize_html_class($config['section_class']);

			// ClueEdit: support multiple classes
			$raw_classes = $config['section_class'];
			$raw_classes_array = explode(' ', $raw_classes);
			$sanitized_classes = array_map('sanitize_html_class', $raw_classes_array);

			$classes_string = join(' ', $sanitized_classes);

			$classes[] = $classes_string;
		}

		// Determine if the section should be a standard image based on 'section_image_type' config
		if (isset($config['section_image_type']) && $config['section_image_type'] === 'I') {
			$classes[] = 'ss-image';
		}
		// Determine if the section should be boxed based on 'section_fullwidth' config
		$isBoxed = false;
		if (isset($config['section_fullwidth']) && $config['section_fullwidth'] === false) {
			$classes[] = 'ss-boxed';
			$isBoxed = true;
		}
		
		// Determine if the section should be rounded based on 'section_image_rounded' config
		if (isset($config['section_image_rounded']) && $config['section_image_rounded'] === true) {
			$classes[] = 'ss-rounded';
		}

		// Determine if the section should be rounded based on 'section_video_rounded' config
		if (isset($config['section_video_rounded']) && $config['section_video_rounded'] === true) {
			$classes[] = 'ss-rounded';
		}

		// Determine if the section should be rounded based on 'section_rounded' config
		if (isset($config['section_rounded']) && $config['section_rounded'] === true) {
			$classes[] = 'sl-rounded';
		}

		// Add section layout style if set, add prefix 'sl-'
		if (!empty($config['section_layout_style'])) {
			$classes[] = 'sl-' . $config['section_layout_style'];

			if ( in_array($config['section_layout_style'], array('bx1', 'bx2', 'bx3')) ) {
				$isBoxed = true;
			}
		}

		// Add section content width if set, add prefix 'scw-'
		if (!empty($config['section_content_width']) && $config['section_content_width'] !== 'default') {
			$classes[] = 'scw-' . $config['section_content_width'];
		}

		// Add section content position if set, add prefix 'scp-'
		if (!empty($config['section_content_position']) && $config['section_content_position'] !== 'default') {
			$classes[] = 'scp-' . $config['section_content_position'];
		}

		// Add section video width if set, add prefix 'ssv-'
		if (!empty($config['section_video_width']) && $config['section_video_width'] !== 'fullwidth') {
			$classes[] = 'ssv-' . $config['section_video_width'];
		}
		// Add top border class if 'section_border[top]' is set to true
		if (isset($config['section_border']['top']) && $config['section_border']['top'] === true) {
			$classes[] = 'sbt';
		}

		// Add bottom border class if 'section_border[bottom]' is set to true
		if (isset($config['section_border']['bottom']) && $config['section_border']['bottom'] === true) {
			$classes[] = 'sbb';
		}

		// If the section is boxed, check for left and right borders
		if ($isBoxed) {
			// Add left border class if 'section_border[left]' is set to true
			if (isset($config['section_border']['left']) && $config['section_border']['left'] === true) {
				$classes[] = 'sbl';
			}

			// Add right border class if 'section_border[right]' is set to true
			if (isset($config['section_border']['right']) && $config['section_border']['right'] === true) {
				$classes[] = 'sbr';
			}
		}

		// Add section aspect ration if set, add prefix 'sar-d-' for desktop, 'sar-m-' for mobile 
		if (isset($config['section_aspect_ratio']) && is_array($config['section_aspect_ratio'])) {
			if (isset($config['section_aspect_ratio']['desktop'])) {
				$classes[] = 'sar-d-' . $config['section_aspect_ratio']['desktop'];
			}
			if (isset($config['section_aspect_ratio']['mobile'])) {
				$classes[] = 'sar-m-' . $config['section_aspect_ratio']['mobile'];
			}
		}		
		// Return the space-separated string of classes
		return join(' ', $classes);
	}

}


if ( ! function_exists( 'cd_get_simple_section_config_class' ) ) {
	/**
	 * simple version, only section_classname and section_class, for wrapper section
	 */
	function cd_get_simple_section_config_class($config) {

		// Ensure $config is an array
		if ( ! is_array( $config ) ) {
			return '';
		}

		$classes = array();

		// Add section classname if provided
		if (!empty($config['section_classname'])) {
			$classes[] = $config['section_classname']; // section block class naming, eg: cdb-content
		}		

		// Add section-specific class if set by user
		if (!empty($config['section_class'])) {
			$classes[] = sanitize_html_class($config['section_class']);
		}

		// Return the space-separated string of classes
		return join(' ', $classes);
	}

}


if ( ! function_exists( 'cd_section_user_custom_css' ) ) {
	/**
	 * Generates a class string based on the provided configuration and custom class.
	 *
	 * @param array $config Configuration array containing section-related classes.
	 * @return string Inside <style>...</style> with custom CSS to be applied to a section.
	 */
	function cd_section_user_custom_css($config) {

		// Ensure $config is an array
		if ( ! is_array( $config ) ) {
			return '';
		}
		
		// Check if custom CSS is provided
		if (!empty($config['section_custom_css'])) {
			// Get the custom CSS content
			$custom_css = $config['section_custom_css'];
	
			// Sanitize the custom CSS content to ensure it is safe
			// Strip HTML tags and escape special characters
			$custom_css = wp_strip_all_tags($custom_css);
			$custom_css = htmlspecialchars($custom_css, ENT_QUOTES, 'UTF-8');
	
			// Remove dangerous IE-specific attributes and functions
			$custom_css = preg_replace('/(expression|behavior|url\s*\(\s*data:|progid:|behavior\s*:\s*[^;]+|-moz-binding|javascript|data|vbscript|file|chrome|about|mocha)/i', '', $custom_css);
	
			// Remove any remaining non-CSS content (although wp_strip_all_tags should handle this)
			$custom_css = preg_replace('/<\/?[^>]+>/', '', $custom_css);
	
			return '<style>' . $custom_css . '</style>';
		}
	
		// Return an empty string if no custom CSS is provided
		return '';
	}
	
}

if ( ! function_exists( 'cd_get_section_id' ) ) {
	/**
	 * Generates an id attribute string based on the provided configuration.
	 *
	 * @param array $config Configuration array containing section-related ID.
	 * @return string An id attribute string to be used in HTML, or an empty string if no ID is provided.
	 */
	function cd_get_section_id($config) {

		// Ensure $config is an array
		if ( ! is_array( $config ) ) {
			return '';
		}
		
		// Check if section ID is provided
		if (!empty($config['section_id'])) {
			// Get the section ID and sanitize it
			$section_id = sanitize_html_class($config['section_id']);
			return ' id="' . esc_attr($section_id) . '"';
		}
	
		// Return an empty string if no section ID is provided
		return '';
	}
}

if ( ! function_exists( 'cd_get_section_style' ) ) {
	/**
	 * Generates a style attribute string based on the provided configuration.
	 *
	 * @param array $config Configuration array containing section-related properties.
	 * @return string A style attribute string to be used in HTML, or an empty string if no height is provided.
	 */
	function cd_get_section_style($config) {

		// Ensure $config is an array
		if ( ! is_array( $config ) ) {
			return '';
		}
		
		// Check if section height is provided
		if (!empty($config['section_height']) && $config['section_height'] !== '0') {
			// Get the section height and sanitize it
			$section_height = sanitize_html_class($config['section_height']);
			return ' style="min-height:' . esc_attr($section_height) . (empty($config['section_height_unit']) ? 'vh' : esc_attr($config['section_height_unit'])) . ';"';
		}
	
		// Return an empty string if no section height is provided
		return '';
	}
}


if ( ! function_exists( 'cd_get_section_grid_class' ) ) {
	/**
	 * Generates a class string based on the provided configuration and custom class.
	 *
	 * @param mixed $config Configuration array containing section-related classes.
	 * @return string A space-separated string of classes to be applied to a section.
	 */
	function cd_get_section_grid_class($config = array()) {

		// Set default values
		$default_style		= 'sgl-rnd';
		$default_spacing	= 'sgs-md';
		$default_padding	= 'sgp-md';

		// Ensure $config is an array, if not, use an empty array
		if ( ! is_array( $config ) ) {
			$config = array();
		}

		$classes = array();

		// Grid Style: set default 'sgl-rnd' if empty
		$style = ! empty( $config['section_grid_style'] ) ? $config['section_grid_style'] : $default_style;
		$classes[] = esc_attr( $style );

		// Grid Spacing: set default 'sgs-md' if empty
		$spacing = ! empty( $config['section_grid_spacing'] ) ? $config['section_grid_spacing'] : $default_spacing;
		$classes[] = esc_attr( $spacing );

		// Grid Padding: set default 'sgp-md' if empty
		$padding = ! empty( $config['section_grid_padding'] ) ? $config['section_grid_padding'] : $default_padding;
		$classes[] = esc_attr( $padding );

		// Return the space-separated string of classes
		return ! empty( $classes ) ? ' ' . join( ' ', $classes ) : '';
	}
}


if ( ! function_exists( 'cd_get_logo_grid_class' ) ) {
	/**
	 * Generates a class string based on the provided configuration and custom class.
	 *
	 * @param mixed $config Configuration array containing section-related classes.
	 * @return string A space-separated string of classes to be applied to a section.
	 */
	function cd_get_logo_grid_class($config = array()) {

		// Set default values
		$default_spacing		= 'sgs-md';
		$default_height			= '5';
		$default_image_size		= 'fit';

		// Ensure $config is an array, if not, use an empty array
		if ( ! is_array( $config ) ) {
			$config = array();
		}

		$classes = array();

		// Grid Spacing: set default 'sgs-md' if empty
		$spacing = ! empty( $config['section_grid_spacing'] ) ? $config['section_grid_spacing'] : $default_spacing;
		$classes[] = esc_attr( $spacing );

		// Grid Item Height: set default 'sgh-5' if empty, add prefix 'sgh-'
		$height = ! empty( $config['section_grid_item_height'] ) ? $config['section_grid_item_height'] : $default_height;
		$classes[] = 'sgh-' . esc_attr( $height );

		// Grid Image Size: set default 'bgz-fit' if empty, add prefix 'bgz-'
		$image_size = ! empty( $config['section_grid_image_size'] ) ? $config['section_grid_image_size'] : $default_image_size;
		$classes[] = 'bgz-' . esc_attr( $image_size );

		// Grid Image Color: if set, add prefix 'sgc-'
		if (!empty($config['section_grid_image_color']) && $config['section_grid_image_color'] !== 'default') {
			$classes[] = 'sgc-' . $config['section_grid_image_color'];
		}

		// Determine if the grid image should have background color 'section_grid_image_bg' config
		if (isset($config['section_grid_image_bg']) && $config['section_grid_image_bg'] === true) {
			$classes[] = 'sgb-fill';
		}

		// Determine if the grid image should have rounded corner 'section_grid_image_bg_round' config
		if (isset($config['section_grid_image_bg_round']) && $config['section_grid_image_bg_round'] === true) {
			$classes[] = 'sgb-rnd';
		}

		// Determine if the grid is display as flex 'section_grid_flex' config
		if (isset($config['section_grid_flex']) && $config['section_grid_flex'] === true) {
			$classes[] = 'sg-flex';
		}
		
		// Return the space-separated string of classes
		return ! empty( $classes ) ? ' ' . join( ' ', $classes ) : '';
	}
}

/**
 * Convert standard YouTube and Vimeo URLs to their embed URLs.
 *
 * This function takes a video URL as input and checks if it is a YouTube or Vimeo link.
 * If it is a YouTube URL, it extracts the video ID and returns the corresponding
 * embed URL in the format: https://www.youtube.com/embed/VIDEO_ID.
 * If it is a Vimeo URL, it extracts the video ID and returns the corresponding
 * embed URL in the format: https://player.vimeo.com/video/VIDEO_ID.
 * If the URL is neither a YouTube nor a Vimeo link, the function returns the original URL.
 *
 * @param string $url The video URL to be converted.
 * @return string The corresponding embed URL or the original URL if no match is found.
 */
function cd_get_embed_url($url) {
    // Convert YouTube URLs
    if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
        // Check for standard YouTube URL
        if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|(?:youtu\.be\/))([^&\n]{11})/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
    }

    // Convert Vimeo URLs
    if (strpos($url, 'vimeo.com') !== false) {
        // Extract the video ID
        if (preg_match('/(?:https?:\/\/)?(?:www\.)?vimeo\.com\/(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }
    }

    // Return original URL if no match
    return $url;
}


/**
 * Get the MIME type based on the video file extension.
 *
 * @param string $file_extension The file extension of the video.
 * @return string The MIME type corresponding to the file extension or an empty string if not recognized.
 */
function cd_get_video_mime_type($file_extension) {
    // Define MIME types for supported video file extensions
    $mime_types = [
        'mp4'   => 'video/mp4',
        'ogg'   => 'video/ogg',
        'ogv'   => 'video/ogg',
        'webm'  => 'video/webm',
        'mov'   => 'video/quicktime'
    ];

    // Return the corresponding MIME type or an empty string if not found
    return isset($mime_types[$file_extension]) ? $mime_types[$file_extension] : '';
}

/**
 * Generate a list of social media links with optional text display.
 *
 * @param array $socmed An array of arrays containing 'type' and 'url' values.
 * @param bool $showText Whether to show the social media name or not for all entries.
 * @return string The generated HTML list of social media links.
 *
 * @note Example usage:
 * $socmed = [
 *     ['type' => 'fb', 'url' => 'https://www.facebook.com/clueperth/'],
 *     ['type' => 'ig', 'url' => 'https://www.instagram.com/clueperth/'],
 *     ['type' => 'in', 'url' => 'https://www.linkedin.com/company/clueperth'],
 *     ['type' => 'tt', 'url' => 'https://www.tiktok.com/@clueperth/'],
 * ];
 *
 * echo cd_generate_social_links($socmed, true);  // Show text
 * echo cd_generate_social_links($socmed, false); // Hide text
 */
function cd_generate_social_links($socmed, $classname, $showText) {
	
	// Check if $socmed is an array and not empty
    if (!is_array($socmed) || empty($socmed)) {
        return ''; // Return empty string for invalid or empty input
    }

	// Combined array of social media types with their corresponding icon classes and names
	$socialMedia = [
		'in' => ['icon' => 'ic-linkedin', 'name' => 'LinkedIn'],
		'ig' => ['icon' => 'ic-instagram', 'name' => 'Instagram'],
		'fb' => ['icon' => 'ic-facebook', 'name' => 'Facebook'],
		'tt' => ['icon' => 'ic-tiktok', 'name' => 'TikTok'],
	];

    // Set up class names array and add default class
    $classes = ['cdb-socmed'];
    
    // Add custom class if provided
    if (!empty($classname)) {
        $classes[] = $classname;
    }

	$output = '<ul class="' . join( ' ', $classes ) . '">';

	// Loop through each social media entry
	foreach ($socmed as $entry) {
		$type = $entry['type'];
		$url = $entry['url'];

		// Check if the type exists in the $socialMedia array
		if (isset($socialMedia[$type])) {
			$iconClass = $socialMedia[$type]['icon'];
			$name = $socialMedia[$type]['name'];

			// Generate the list item with optional text display
			$output .= '<li><a class="cdb-icon" href="' . esc_url($url) . '">';
			$output .= '<i class="' . esc_attr($iconClass) . '"></i>';
			if ($showText) {
				$output .= '<span class="icon-text">' . esc_html($name) . '</span>';
			}
			$output .= '</a></li>';
		}
	}

	$output .= '</ul>';
	return $output;
}

// Custom Block's Placeholder
// This function generates a placeholder for custom blocks in the block editor
// when required fields are missing. It outputs a basic section structure with a title.
// Parameters:
// - $title (string): The placeholder title text to display.
// - $config (array): Configuration array to customize the section class and other attributes.
function cd_cdb_placeholder($title, $config) {
	// Check that $title is a non-empty string; if not, provide a default message
	if (empty($title) || !is_string($title)) {
		$title = 'Placeholder Title';
	}

	// Check that $config is an array; if not, set it to an empty array
	if (!is_array($config)) {
		$config = [];
	}

	// Generate the placeholder section HTML
	return '<section class="' . cd_get_section_config_class($config) . '">
				<div class="container section-container">
					<div class="content-container">
						<div class="title_wrapper placeholder">
							<h3>' . esc_html($title) . '</h3>
						</div>
					</div>
				</div>
			</section>';
}

function cd_cdb_isEmptyfields($fields) {
    foreach ($fields as $field) {
        if (empty($field)) {
            return true; // Return true if any field is empty
        }
    }
    return false; // Return false if all fields are non-empty
}

function cd_cdb_isEmptyArray($field) {
    if (is_array($field) && count($field) > 0) {
        return true;
    }
    return false;
}

function cd_getStarRating($sRating) {
	$rating = (float)$sRating;
    $maxStars = 5; // Total number of stars
    $html = '<div class="starRating">';

    for ($i = 1; $i <= $maxStars; $i++) {
        if ($rating >= $i) {
            $html .= '<span class="sFull"></span>'; // Full star
        } elseif ($rating > $i - 1) {
            $html .= '<span class="sHalf"></span>'; // Half star
        } else {
            $html .= '<span class="sEmpty"></span>'; // Empty star
        }
    }

    $html .= '</div>';
    return $html;
}


/**
 * Generates breadcrumb navigation for WordPress themes.
 *
 * This function dynamically creates a breadcrumb trail based on the current context,
 * including categories, single posts, static pages (with or without parents), archives,
 * search results, and 404 pages. It provides a clear navigation path for users.
 *
 * Features:
 * - Displays a "Home" link at the start of the breadcrumb trail.
 * - Supports category and single post hierarchy.
 * - Handles parent-child relationships for static pages.
 * - Displays the current archive title, search query, or 404 message as appropriate.
 * - Customizable separator and "Home" link title.
 * - Includes support for custom post type 'work'.
 *
 * Usage:
 * Call this function in the desired location within your WordPress theme templates, e.g.,
 * inside `header.php`, `single.php`, or `page.php`.
 */
function cd_breadcrumbs() {
	// Settings
	$separator = '<span class="sep">/</span>'; // Breadcrumb separator
	$home_title = 'Home'; // Text for the "Home" link

	// Get the query & post information
	global $post;
	$home_url = home_url();

	// Begin the breadcrumb
	if (!is_front_page()) {
		echo '<nav class="breadcrumbs">';
		echo '<a href="' . $home_url . '">' . $home_title . '</a>' . $separator;

		if (is_category()) {
			// Blog page
			echo '<a href="' . $home_url . '/blog">Blog</a>' . $separator;

			// Category page
			echo '<span>' . single_cat_title('', false) . '</span>';
		} elseif (is_single()) {
			// Single post
			if ('case-study' === get_post_type()) {
				// Custom post type 'work'
				echo '<a href="' . $home_url . '/work/">Work</a>' . $separator;
				echo '<span>' . get_the_title() . '</span>';
			} else {
				// Blog page
				echo '<a href="' . $home_url . '/blog">Blog</a>' . $separator;

				// $category = get_the_category();
				// if ($category) {
				// 	$category_link = get_category_link($category[0]->term_id);
				// 	echo '<a href="' . $category_link . '">' . $category[0]->name . '</a>' . $separator;
				// }
				echo '<span>' . get_the_title() . '</span>';
			}
		} elseif (is_page() && !$post->post_parent) {
			// Static page without parent
			echo '<span>' . get_the_title() . '</span>';
		} elseif (is_page() && $post->post_parent) {
			// Static page with parent
			$parent_id = $post->post_parent;
			$breadcrumbs = [];
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) {
				echo $crumb . $separator;
			}
			echo '<span>' . get_the_title() . '</span>';
		} elseif (is_post_type_archive('work')) {
			// Archive for custom post type 'work'
			echo '<span>Work</span>';
		} elseif (is_archive()) {
			// Other archive pages
			echo '<span>' . post_type_archive_title('', false) . '</span>';
		} elseif (is_search()) {
			// Search results page
			echo '<span>Search results for "' . get_search_query() . '"</span>';
		} elseif (is_404()) {
			// 404 page
			echo '<span>Page not found</span>';
		}

		echo '</nav>';
	}
}


/**
 * Get the adjacent case study post (previous or next) based on menu_order.
 *
 * This function retrieves the adjacent case study (custom post type) ordered by 
 * the menu_order field. It wraps around if the current post is the first or last 
 * in the menu_order sequence. For example, if the current post is the first in 
 * the sequence, the "previous" post will be the last, and if the current post is 
 * the last, the "next" post will be the first.
 *
 * @param int $current_post_id The ID of the current post.
 * @param string $direction The direction to fetch: 'next' for the next post or 'prev' for the previous post.
 *
 * @return WP_Post|null The adjacent post object or null if no adjacent post is found.
 *
 * Usage:
 * - To get the next post: cd_get_adjacent_case_study($current_post_id, 'next');
 * - To get the previous post: cd_get_adjacent_case_study($current_post_id, 'prev');
 *
 * Notes:
 * - This function assumes all posts of type 'case-study' are properly assigned a unique 
 *   `menu_order` value.
 * - If there is only one case study post, the function will return null for both directions.
 * - The function automatically wraps around for seamless navigation.
 */
function cd_get_adjacent_case_study($current_post_id, $direction = 'next') {
	// Get the current post's menu_order
	$current_post = get_post($current_post_id);
	if (!$current_post) {
		return null; // Ensure a valid post ID is provided
	}
	$current_menu_order = $current_post->menu_order;

	// Fetch all case studies ordered by menu_order
	$args = array(
		'post_type'      => 'case-study',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC', // Order by ascending menu_order
	);

	$query = new WP_Query($args);
	if (!$query->have_posts()) {
		wp_reset_postdata();
		return null; // No posts found
	}

	// Return null if there's only one case study post
	if ($query->found_posts === 1) {
		return null;
	}

	$posts = $query->posts; // Fetch all posts in the query
	$total_posts = count($posts);

	// Locate the current post and determine adjacent posts
	$prev_post = null;
	$next_post = null;

	foreach ($posts as $index => $post) {
		if ($post->ID === $current_post_id) {
			$prev_index = ($index === 0) ? $total_posts - 1 : $index - 1; // Wrap to the last post if at the start
			$next_index = ($index === $total_posts - 1) ? 0 : $index + 1; // Wrap to the first post if at the end

			$prev_post = $posts[$prev_index];
			$next_post = $posts[$next_index];
			break;
		}
	}

	// Clean up the query
	wp_reset_postdata();

	// Return the appropriate adjacent post based on the direction
	return ($direction === 'next') ? $next_post : $prev_post;
}
