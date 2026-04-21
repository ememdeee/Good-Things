<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function cd_get_post_ids($post) {
    if (isset($post->ID)) {
        return $post->ID;
    }
}

// show sub pages like in mintox, usage [cd_childpages]
// attributes
// notitle="true"
// class="" additional class eg: "submenu-landing"
// depth="1"
// fromroot="1" (default) 0 = not from root
function cd_list_child_pages($atts) { 
 
    global $post; 

    if (!is_object($post)) {
        return '';
    }
    
	// Attributes
	$atts = shortcode_atts(
		array(
            'notitle' => '0',
            'mode' => 'normal',
            'class' => '',
            'depth' => '',
            'fromroot' => '0',
		),
		$atts,
		'cd_childpages'
	);

    $title ='';

    // var_dump($post);

    // decide which post to be set as parent (the root of sidebar)
    $post_parent = $post;

    // check if its under 4 child sites
    $parent_slug = cd_get_second_segment_url();

        // if this is 2nd level child
        if ($post->post_parent === 0) {
            // do nothing
        } else {
            // track parent until 2nd level
            while ( $post_parent->post_parent ) {
                $post_parent = get_post( $post_parent->post_parent );
                if ($post_parent->post_parent === 0) {
                    break;
                }
            }    
            // var_dump($post_parent);
        }


    
    

    $depth_att = '';
    if ($atts['depth']) {
        $depth_att = '&depth='.$atts['depth'];
    }

    if ( is_page() ) {
        // child of parent
        // $post_parent = $post->post_parent;

        // need to exclude pages that marked as 'exclude from sidenav'

        $the_query = new WP_Query( array(
            'post_type'=>'page',
						'meta_query'=>array(
							array(
								'key' => 'sidenav_exclude', // ACF true/false field
								'value' => '1', // ACF stores true as '1'
								'compare' => '=',
							),
            ),
        ) );
        $excluded_pages = $the_query->posts;

        // // while ( $the_query->have_posts() ) :
        // //     // $the_query->the_post();

        // // endwhile;
        // // Reset post data
        // wp_reset_postdata();
        $excluded_page_ids = array_map('cd_get_post_ids', $excluded_pages);
            
        // var_dump(implode(',',$excluded_page_ids));
        $excluded_att = count($excluded_page_ids)?'&exclude='.implode(',',$excluded_page_ids):'';        

        $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post_parent->ID . '&echo=0'. $depth_att . $excluded_att );
        $title = get_the_title($post_parent->ID);
        // $parent_link = get_permalink($post_parent->ID);  
		$parent_link = untrailingslashit(get_permalink($post_parent->ID));
    }    
    
    $submenu_class = 'submenu-normal';
    // if ($atts['mode'] === 'dropdown') {
    //     $submenu_class = 'submenu-dropdown';
    // }
    // else if ($atts['mode'] === 'auto') {
    //     $submenu_class = 'submenu-auto';
    // }

    if ($atts['class']) {
        $submenu_class .= ' '. $atts['class'];
    }

    $string = '';
    if ( $childpages ) {
		// remove trailing slash from wp_list_pages links
    	$childpages = preg_replace('/href="([^"]+)\/"/', 'href="$1"', $childpages);
        $string = '<div class="subnav"><div class="submenu '.$submenu_class.'">';
        if ($atts['notitle'] === '0') {
            $string .= '<div class="h4 submenu-header"><a href="'.$parent_link.'">'.$title.'</a></div>';
        }
		$childpages = preg_replace('/href="([^"]+)\/"/', 'href="$1"', $childpages);
        $string .= '<ul>' . $childpages . '</ul>';
        $string .= '</div></div>';
    }
    
    return $string;
 
}
 
add_shortcode('cd_childpages', 'cd_list_child_pages');


// blog shortcode
// parameters:
//  quantity: quantity
//  category: all
// operator: default, AND
// usage [cd-post-grid quantity="3"]
// Add Shortcode
function cd_post_grid_shortcode( $atts , $content = null ) {
	// Attributes
	$atts = shortcode_atts(
		array(
            'quantity' => '3',
            'category' => 'all',
            'operator' => 'default',
		),
		$atts,
		'project'
	);

  // wp query args
  $args = array ( 
    'posts_per_page' => $atts['quantity'],
    'post_type' => 'post',
  ); 

  $category = $atts['category'];

  if ($atts['operator'] === 'AND' && $category && $category !== 'all') {
    $category_slugs_array = explode(',', $category);    
    if (count($category_slugs_array) > 0) {
        $category_ids = array();
        foreach ($category_slugs_array as $slug) {
            $category_ids[] = get_category_by_slug($slug)->term_id;
        }   
        
        $args['category__and'] = $category_ids;
    }
  } else {
    if ($category !== 'all') {
        $args['category_name'] = $category;
      }    
  }

  $the_query = new WP_Query( $args );


	// Posts
    $output = '<div class="posts-grid">';
    // make it slider, change post-grid__slider to row
    $output .= '<div class="post-grid__slider">';
    $i = 1;
    // Loop through the projects, displaying the title and content for each
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
        
		$img = get_the_post_thumbnail( get_the_ID(), 'large', array(  ) );
        if (!$img) {
            // TODO: add default image if needed
		}

        $excerpt = text_max_charlength(wp_filter_nohtml_kses(get_the_excerpt()),200);
 
        // $output .= '<div class="col-lg-4" data-aos="fade-up" data-aos-delay="'. ($i*150) .'" data-aos-duration="750">';

        // make it slider, change col-md-4 with post-grid__slide
        $output .= '<div class="post-grid__slide">';
        $output .= '<article class="post-card card post-card--color-purple" id="post-'.get_the_ID() .'">';
        $output .= '<div class="card-img-wrapper">';
        $output .= '<a href="'.get_permalink().'" title="'. get_the_title() .'">'.$img.'</a>';
        $output .= '  <div class="entry-cat">'.cd_display_category().'</div>';
        $output .= '</div>';
        $output .= '<div class="card-body">';
        $output .= '  <a href="'.esc_url( get_permalink() ) .'" rel="bookmark" class="card-body-link">';
        $output .= '  <header class="entry-header">';
        $output .= '<h3 class="entry-title card-title h4">'.get_the_title().'</h3>';
        $output .= '<div class="entry-meta">'.get_the_date().'</div>';
        $output .= '  </header>';
        $output .= '  <div class="card-text entry-content">';
         $output .= $excerpt;
        // $output .='<a href="'.get_permalink().'" title="'. get_the_title() .'" class="read-more-link">Read the Story</a>';
        $output .= '';
        $output .= '<p class=""><a class="read-more-link btn-text" href="'.esc_url( get_permalink() ) .'">Read more</a></p>';
        $output .= '  </div>';
        $output .= '';
        $output .= '</div>';
        $output .= '</a>';
        $output .= '</article>';
        $output .= '</div>';

        $i++;

	endwhile;
    $output .= '</div>';
    $output .= '<div class="post-grid__nav">
                    <div class="post-grid__arrows"></div>
                    './*'<div class="post-grid__pager"></div>'*/''.
                '</div>
                ';
    $output .= '</div>';
    
	// Reset post data
	wp_reset_postdata();
	
	return $output;
}
add_shortcode( 'cd-post-grid', 'cd_post_grid_shortcode' );



/**
 * Social Links
 * Uses Social URLs specified in Yoast SEO. See SEO > Social
 * 
 * template = menu-items = echo as menu items
 */
function cd_social_links($atts) {

	$atts = shortcode_atts(
		array(
            'template' => '', 
		),
		$atts,
		'social_links'
	);

	$options = array(
		'facebook' 		=> array(
			'key' 		=> 'facebook_site',
		),
		'twitter' 		=> array(
			'key' 		=> 'twitter_site',
			'prepend' 	=> 'https://twitter.com/',
		),
		'instagram' 	=> array(
			'key' 		=> 'instagram_url',
		),
		'linkedin' 		=> array(
			'key' 		=> 'linkedin_url',
		),
		'myspace' 		=> array(
			'key' 		=> 'myspace_url',
		),
		'pinterest' 	=> array(
			'key' 		=> 'pinterest_url',
		),
		'youtube' 		=> array(
			'key' 		=> 'youtube_url',
		),
		'googleplus' 	=> array(
			'key' 		=> 'google_plus_url',
		)
	);

	$output = array();

	$seo_data = get_option( 'wpseo_social' );
    
	foreach( $options as $social => $settings ) {

		$url = !empty( $seo_data[ $settings['key'] ] ) ? $seo_data[ $settings['key'] ] : false;
		if( !empty( $url ) && !empty( $settings['prepend'] ) )
			$url = $settings['prepend'] . $url;

		if( $url )
			$output[] = '<li class="social-'.$social.'"><a href="' . esc_url_raw( $url ) . '" class="social-link-'.$social.'">' . '<span>' . $social . '</span></a></li>';
	}

    // $contact_email = get_field('contact_email','option');

    // if ($contact_email) {
    //     $output[] = '<li><a href="mailto:' . $contact_email . '" class="social-link-email">' . '<span>' . 'Email Us' . '</span></a></li>';        
    // }

    // other social media
    $other_urls = $seo_data['other_social_urls'];
    // var_dump($other_urls);
    if ( $other_urls && count( $other_urls ) ) {
        foreach ( $other_urls as $other_url ) {
            $other_social = '';
            if ( strpos( $other_url, 'youtube.com' ) !== false ) {
                $other_social = 'youtube';
            } elseif ( strpos( $other_url, 'instagram.com' ) !== false ) {
                $other_social = 'instagram';
            } elseif ( strpos( $other_url, 'linkedin.com' ) !== false ) {
                $other_social = 'linkedin';
            }

            $output[] = '<li class="social-'.$other_social.'"><a href="' . esc_url_raw( $other_url ) . '" class="social-link social-link-' . $other_social . '" title="' . $other_social . '">' . '<span>' . $other_social . '</span></a></li>';
        }
    }

	if ( !empty( $output ) ) {
        if ($atts['template'] == 'menu-items') {
            return join( ' ', $output );
        } else {
            return '<ul class="social-links social-links--icons">' . join( ' ', $output ) . '</ul>';
        }


    }
}
add_shortcode( 'cd_social_links', 'cd_social_links' );

//*************************************************************/
// create a button shortcode
// basic > [button href="#"]Hello[/button]
// complete usage:
// [button href="#" style="dark" size="large" icon="r-arrow"]Click Me[/button]
//-------------------------------------------------------------/
/* to call the function directly
	cd_button(array(
		'text'		=> 'Click Me',
		'href'		=> '#',
		'style'		=> 'dark',
		'size'		=> 'large',
		'icon'		=> 'r-arrow',
	));
*/
//*************************************************************/
function cd_button($args = array()) {
	// Define default values
	$defaults = array(
		'text'		=> '',
		'link'		=> '#',
		'style'		=> '',	        // dark, light, h-dark, h-light, t-dark, t-light
		'size'		=> '',			// small, medium (default/empty), large, xlarge
		'icon'		=> '',			// none, r-arrow, l-arrow
	);

	// Merge user-defined arguments with defaults
	$args = wp_parse_args($args, $defaults);

	// If 'text' is empty, return an empty string
	if (empty($args['text'])) {
		return '';
	}

	// Build the class string based on the arguments
	$button_class = 'btn';
	if (!empty($args['style']) && $args['style'] !== 'default') {
		$button_class .= ' ' . esc_attr($args['style']);
	}
	if (!empty($args['size']) && $args['size'] !== 'medium') {
		$button_class .= ' ' . esc_attr($args['size']);
	}

	$button_icons = [
		'r-arrow'	=> 'ic-arrow-right',
		'l-arrow'	=> 'ic-arrow-left',
		'calendar'	=> 'ic-calendar',
		'phone' => 'ic-phone',
	];

	// check button icon is set and exists in the icons array
	$button_icon = '';
	$button_text = '<span class="link-text">' . esc_html($args['text']) . '</span>';
	if (!empty($args['icon']) && $args['icon'] !== 'none' && array_key_exists($args['icon'], $button_icons)) {
		$button_class .= ' cdb-icon';
		$button_icon = '<i class="'. esc_attr($button_icons[$args['icon']]) .'"></i>';

		// // left positioned icon
		// if ($args['icon'] === 'l-arrow') {
			$button_class .= ' sw-left';
			$button_text = $button_icon . $button_text;
		// } else {
		// 	$button_text = $button_text . $button_icon;
		// }
	}

	// Generate and return the HTML output for the button
	return '<a href="' . esc_url($args['link']) . '" class="' . esc_attr($button_class) . '">' . $button_text . '</a>';
}

// Shortcode handler function
function cd_button_shortcode($atts, $content = '') {
	// Merge attributes with defaults
	$args = shortcode_atts(
		array(
			'text'		=> $content,
			'link'		=> '#',
			'style'		=> '',
			'size'		=> '',
			'icon'		=> '',
		),$atts
	);

	// Call the function to generate and return the HTML output for the button
	return cd_button($args);
}
// Register the shortcode with WordPress
add_shortcode('button', 'cd_button_shortcode');

//*************************************************************/
// Create Button Row Function
//-------------------------------------------------------------/
// Parameters:
// - 'section_buttons': An array of button configurations. Check cd_button function
// - 'section_buttons_alignment': Optional alignment class for the button row (e.g., 'left', 'center', 'right').
// - 'section_buttons_class': Optional additional custom class for the button row container.
//
// This function generates a row of buttons with specified alignment and custom classes.
//*************************************************************/
function cd_button_row($args = array()) {
	// Define default values
	$defaults = array(
		'section_buttons_alignment'	=> '',
		'section_buttons_class'		=> '',		// custom class name
		'section_buttons'			=> array(),
	);

	// Merge user-defined arguments with defaults
	$args = wp_parse_args($args, $defaults);

	// Initialize output
	$output = '';

	// Check if buttons exists and is an array
	if ($args['section_buttons'] && is_array($args['section_buttons'])) {

		// Build the class string
		$btnrow_class = 'btn-row';
		if (!empty($args['section_buttons_alignment']) && $args['section_buttons_alignment'] !== 'left') {
			$btnrow_class .= ' ' . esc_attr($args['section_buttons_alignment']);
		}
		if (!empty($args['section_buttons_class'])) {
			$btnrow_class .= ' ' . esc_attr($args['section_buttons_class']);
		}

		// Start building the output
		$output = '<div class="' . $btnrow_class . '">';

		// Add buttons
		foreach ($args['section_buttons'] as $button) {
			$output .= cd_button(array(
				'text'       => isset($button['button_text']) ? trim($button['button_text']) : '',
				'link'       => isset($button['button_link']) ? trim($button['button_link']) : '',
				'style'      => isset($button['button_style']) ? $button['button_style'] : '',
				'size'       => isset($button['button_size']) ? $button['button_size'] : '',
				'icon'       => isset($button['button_icon']) ? $button['button_icon'] : '',
			));
		}

		// Close the div
		$output .= '</div>';
	}
	
	// return the HTML output
	return $output;
}

//*************************************************************/
// create heading shortcode
// basic > [heading title="My Title" tag="h1"]
//*************************************************************/
function cd_title($args = array()) {
	// Define default values
	$defaults = array(
		'title_text'						=> '',
		'title_tag'							=> 'h1',
		'title_size'						=> '',
		'title_alignment'					=> '',
		'title_class'						=> '', // custom class name, e.g., entry_title
		'title_subheading'					=> '',
		'title_subheading_text'				=> '',
		'title_subheading_tag'				=> 'div',
		'title_subheading_size'				=> '',
		'title_subheading_icon'				=> 0,
		'title_subheading_icon_location'	=> false,	// false - Left, true - Top
		'title_no_mb'						=> false, // true to remove bottom margin
	);

	// Merge user-defined arguments with defaults
	$args = wp_parse_args($args, $defaults);

	// ClueEdit: need to know title heading size or heading class size, and add to wrapper, to allow relative sizing of subheading to title
	$heading_sizes = array('h1','h2','h3','h4','h5','h6');
	$wrapper_size_class = '';
	if (!empty($args['title_size']) && $args['title_size'] !== 'default') {
		if (in_array($args['title_size'], $heading_sizes)) {
			$wrapper_size_class = ' title_wrapper--' . esc_attr($args['title_size']);
		}
	}
	if (!empty($args['title_tag'])) {
		if (in_array($args['title_tag'], $heading_sizes)) {
			$wrapper_size_class = ' title_wrapper--' . esc_attr($args['title_tag']);
		}
	}

	// Build the class string based on the arguments
	$wrapper_class = 'title_wrapper';
	if (!empty($args['title_alignment']) && $args['title_alignment'] !== 'left') {
		$wrapper_class .= ' ' . esc_attr($args['title_alignment']);
	}
	if (!empty($args['title_class'])) {
		$wrapper_class .= ' ' . esc_attr($args['title_class']);
	}
	if (!empty($wrapper_size_class)) {
		$wrapper_class .= $wrapper_size_class;
	}

	// no margin bottom
	if (!empty($args['title_no_mb']) && $args['title_no_mb'] === true) {
		$wrapper_class .= ' title_wrapper--no-mb';
	}

	// icon
	$icon = '';
	if (!empty($args['title_subheading_icon']) && is_numeric($args['title_subheading_icon'])) {
		// Get the image HTML
		$icon = wp_get_attachment_image($args['title_subheading_icon'], 'medium');
	}

	// icon location
	$icon_on_top = $args['title_subheading_icon_location'];

	// Heading
	$output_head = '';
	if (!empty($args['title_text'])) {
		$heading_class = 'title';	 // '.title' apply the heading title class
		if (!empty($args['title_size']) && $args['title_size'] !== 'default') {
			$heading_class .= ' ' . esc_attr($args['title_size']);
		}

		// Convert spaces to non-breaking spaces to preserve spacing
		$title_text = str_replace('  ', ' &nbsp;', $args['title_text']);

		$tag = esc_attr($args['title_tag']);
		$output_head = cd_print_wrap_tags($title_text, '<'.$tag.' class="'.$heading_class.'">', '</'.$tag.'>');
	}

	// Subheading
	$output_sub = '';
	if (!empty($args['title_subheading']) && $args['title_subheading'] !== 'none' && !empty($args['title_subheading_text'])) {
		$subheading_text = $args['title_subheading_text'];
		if (!empty($icon) && !$icon_on_top) {
			$subheading_text = '<span class="title_icon">'.$icon.'</span>'.$subheading_text;
		}
		
		$subclass = 'subtitle';
		if (!empty($args['title_subheading_size']) && $args['title_subheading_size'] !== 'default') {
			$subclass .= ' ' . esc_attr($args['title_subheading_size']);
		} else {
			$subclass .= ' subtitle--default';
		}
		$subclass .= ' '. $args['title_subheading'];

		$subtag = (!empty($args['title_subheading_tag']) && $args['title_subheading_tag'] !== 'default') ? esc_attr($args['title_subheading_tag']) : 'div';
		$output_sub = cd_print_wrap_tags($subheading_text, '<'.$subtag.' class="'.trim($subclass).'">', '</'.$subtag.'>');
	}

	// Initialize output
	$output = '';
	if ($output_head || $output_sub) {
		$output  = '<div class="' . $wrapper_class . '">';

		// check if the icon located on top of the title
		if (!empty($icon) && $icon_on_top) {
			$output .= '<div class="title_icon_top">'.$icon.'</div>';
		}

		$output .= ($args['title_subheading'] === 'above') ? $output_sub . $output_head : $output_head . $output_sub;
		$output .= '</div>';
	}

	// Return the HTML output for the heading
	return $output;
}
// Shortcode handler function
function cd_title_shortcode($atts) {
	// Merge attributes with defaults
	$defaults = array(
		'title'				=> '',  // Title text
		'tag'				=> 'h1', // HTML tag for the title
		'size'				=> '',  // Size class for the title
		'alignment'			=> '',  // Alignment class for the title
		'class'				=> '',  // Custom class name, e.g., entry_title
		'subheading'		=> '',  // Subheading text
		'subheading_text'	=> '',  // Subheading additional text
		'subheading_tag'	=> 'div', // HTML tag for the subheading
		'subheading_size'	=> '',  // Size class for the subheading
		'subheading_icon'	=> 0,  // sub heading icon
	);

	// Merge user attributes with defaults
	$atts = shortcode_atts($defaults, $atts);

	// Prepare arguments array to send
	$args = array(
		'title_text'			=> $atts['title'],
		'title_tag'				=> $atts['tag'],
		'title_size'			=> $atts['size'],
		'title_alignment'		=> $atts['alignment'],
		'title_class'			=> $atts['class'],
		'title_subheading'		=> $atts['subheading'],
		'title_subheading_text'	=> $atts['subheading_text'],
		'title_subheading_tag'	=> $atts['subheading_tag'],
		'title_subheading_size'	=> $atts['subheading_size'],
		'title_subheading_icon'	=> $atts['subheading_icon'],
	);

	// Call the function to generate and return the HTML output for the heading
	return cd_title($args);
}
// Register the shortcode with WordPress
add_shortcode('heading', 'cd_title_shortcode');

//*************************************************************/
// create an image shortcode
// basic > [bgimage id="99"]
// complete usage:
// [bgimage id="99" mobile="89" opacity="0.5"]
//-------------------------------------------------------------/
/* to call the function directly
	cd_bgimage(array(
		'image_desktop'		=> 99,
		'image_mobile'		=> 89,
		'image_opacity'		=> '0.5',
		'image_fit'			=> 'fill',
		'image_position'	=> 'cc',
		'image_overlay'		=> '0',
		'image_class'		=> '',
		'image_size'		=> 'thumbnail'
	));
*/
//*************************************************************/
function cd_bgimage($args = array()) {
	// Define default values
	$defaults = array(
		'image_desktop'		=> 0,		// Desktop image ID (expects an image ID)
		'image_mobile'		=> 0,		// Mobile image ID (expects an image ID)
		'image_opacity'		=> '0',		// CSS opacity value (as a string)
		'image_fit'			=> 'fill',	// Image fit size: Fit: Contain, Fill: Cover
		'image_position'	=> 'cc',	// Image anchor position
		'image_overlay'		=> '0',		// Image Overlay percentage (opacity)
		'image_class'		=> '',		// Custom class name
		'image_size'		=> 'full',	// image size to retrieve
		'image_fetch_priority' => '',
		'image_loading' => '',
	);

	// Merge user-defined arguments with defaults
	$args = wp_parse_args($args, $defaults);

	// Ensure image_size is not empty, set to 'full' if it is
	$image_size = !empty($args['image_size']) ? $args['image_size'] : 'full';

	// Get the image URLs and srcset from the IDs
	$desktop_img_url = wp_get_attachment_image_url($args['image_desktop'], $image_size);
	$mobile_img_url = wp_get_attachment_image_url($args['image_mobile'], $image_size);
	$desktop_srcset = wp_get_attachment_image_srcset($args['image_desktop'], $image_size);
	$mobile_srcset = wp_get_attachment_image_srcset($args['image_mobile'], $image_size);

	// If the desktop image is not found, use the mobile image as a fallback
	if (!$desktop_img_url) {
		$desktop_img_url = $mobile_img_url;
		$desktop_srcset = $mobile_srcset;
	}

	// If no image is found at all, return an empty string
	if (!$desktop_img_url) {
		return '';
	}

	// Get the alt text from the desktop image (or fallback mobile image)
	$alt_text = get_post_meta($args['image_desktop'] ? $args['image_desktop'] : $args['image_mobile'], '_wp_attachment_image_alt', true);

	$classes[] = 'cdb-bgimage';

	// Set the custom class name if provided
	if (!empty($args['image_class'])) {
		$classes[] = esc_attr($args['image_class']);
	}

	// Set the image position class if provided, default is 'cc', add prefix 'bgz-'
	if (!empty($args['image_fit'])) {
		$classes[] = 'bgz-' . esc_attr($args['image_fit']);
	}

	// Set the image position class if provided, default is 'cc', add prefix 'bgp-'
	if (!empty($args['image_position']) && $args['image_position'] !== 'cc') {
		$classes[] = 'bgp-' . esc_attr($args['image_position']);
	}

	// Set the image overlay class if provided, default is '0', add prefix 'bgo-'
	if (!empty($args['image_overlay']) && $args['image_overlay'] !== '0') {
		$classes[] = 'bgo-' . esc_attr($args['image_overlay']);
	}

	// Set the style for the opacity if provided
	$style = '';
	if (!empty($args['image_opacity']) && $args['image_opacity'] !== '0') {
		$style = ' style="opacity: ' . esc_attr($args['image_opacity']) . ';"';
	}

	// Build the HTML output
	$html = '<picture class="' . trim( join( ' ', $classes )) . '"' . $style . '>';

	if ($mobile_img_url) {
		$html .= '<source srcset="' . esc_attr($mobile_srcset) . '" media="(max-width: 767px)" />';
	}

	if ($desktop_srcset) {
		$html .= '<source srcset="' . esc_attr($desktop_srcset) . '" media="(min-width: 768px)" />';
	}

	$html .= '<img src="' . esc_url($desktop_img_url) . '"';
	if ($desktop_srcset) {
		$html .= ' srcset="' . esc_attr($desktop_srcset) . '"';
	}
	if ($alt_text) {
		$html .= ' alt="' . esc_attr($alt_text) . '"';
	}
	if ($args['image_fetch_priority'] === 'high') {
		$html .= ' fetchpriority="high"';
	}
	if ($args['image_loading'] === 'lazy' || $args['image_loading'] === 'eager') {
		$html .= ' loading="'.$args['image_loading'].'"';
	}
	$html .= 'data-imagesize="' . $image_size . '" />';
	$html .= '</picture>';

	return $html;
}

// Shortcode handler function
function cd_bgimage_shortcode($atts) {
	// Merge attributes with defaults
	$defaults = array(
		'id'		=> 0,
		'mobile'	=> 0,
		'opacity'	=> '0',
		'class'		=> '',		// Custom class name, e.g., image_featured
		'fit'		=> 'fill',	// 'fit':contain or 'fill':cover
		'position'	=> '',		// tl, tc, tr, cl, cc, cr, bl, bc, br
		'overlay'	=> '0',		// 0 - 10
		'size'		=> 'full',	// image size to retrieve
	);

	// Merge user attributes with defaults
	$atts = shortcode_atts($defaults, $atts);

	// Prepare arguments array to send
	$args = array(
		'image_desktop'		=> $atts['id'],
		'image_mobile'		=> $atts['mobile'],
		'image_opacity'		=> $atts['opacity'],
		'image_fit'			=> $atts['fit'],
		'image_position'	=> $atts['position'],
		'image_overlay'		=> $atts['overlay'],
		'image_class'		=> $atts['class'],
		'image_size'		=> $atts['size']
	);

	// Call the function to generate and return the HTML output for the image
	return cd_bgimage($args);
}
// Register the shortcode with WordPress
add_shortcode('bgimage', 'cd_bgimage_shortcode');

//*************************************************************/
// create a background video shortcode
// basic > [bgvideo url="video_url"]
// complete usage:
// [bgvideo url="video_url" image="image_url" opacity="0.5"]
//-------------------------------------------------------------/
/* to call the function directly
	cd_bgvideo(array(
		'video_remote'		=> false, 
		'video_url'			=> '',
		'video_file'		=> '',
		'video_file_mobile'	=> '',
		'video_image'		=> ''
		'video_opacity'		=> '0.5',
		'video_class'		=> '',
	));
*/
//*************************************************************/
function cd_bgvideo($args = array()) {
	// Define default values
	$defaults = array(
		'video_remote'		=> false,
		'video_url'			=> '',
		'video_file'		=> '',
		'video_file_mobile'	=> '',
		'video_autoplay'	=> true,
		'video_controls'	=> false,
		'video_image'		=> '',
		'video_opacity'		=> '1', // Default opacity to fully visible
		'video_class'		=> ''
	);

	// Merge user-defined arguments with defaults
	$args = wp_parse_args($args, $defaults);

	// Get the poster image URLs
	$poster_img_url = wp_get_attachment_image_url($args['video_image'], 'full');

	// Set the custom class name if provided
	$class = !empty($args['video_class']) ? esc_attr($args['video_class']) : '';

	// Set the style for the opacity if provided
	$style = '';
	if (!empty($args['video_opacity']) && $args['video_opacity'] !== '0') {
		$style = ' style="opacity: ' . esc_attr($args['video_opacity']) . ';"';
	}

	$html = '';
	
	if ($args['video_remote']) {
		// For Remote video, e.g., YouTube, Vimeo
		$video_url = esc_url($args['video_url']);

		// Check if it's a YouTube or Vimeo URL
		$is_youtube = strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false;
		$is_vimeo = strpos($video_url, 'vimeo.com') !== false;

		// Autoplay & Controls
		$autoplay = $args['video_autoplay'] ? 'autoplay=1' : 'autoplay=0';
		$controls = $args['video_controls'] ? 'controls=1' : 'controls=0';

		// Add extra parameters to the URL
		if ($is_youtube) {
			$video_url = cd_get_embed_url($video_url) . '?'.$autoplay.'&'.$controls.'&mute=1&rel=0&modestbranding=1&showinfo=0';
			
		} elseif ($is_vimeo) {
			$video_url = cd_get_embed_url($video_url) . '&'.$autoplay.'&'.$controls.'&muted=1&dnt=1&title=0&byline=0&portrait=0';
		}

		// only support Youtube and Vimeo, need more work when it's not
		if ($is_youtube || $is_vimeo) {
			$html .= '<div class="' . $class . '"' . $style . '>';
			$html .=	'<iframe width="100%" height="100%"';
			$html .=		' src="' . $video_url . '"';
			$html .=		' frameborder="0"';
			$html .=		' allow="autoplay; fullscreen"';
			$html .=		' allowfullscreen>';
			$html .=	'</iframe>';
		//	$html .= 	'<div class="video_overlay"></div>';
			$html .= '</div>';
		}
	} else {
		// Self-host local video
		$video_url = esc_url($args['video_file']);
		$video_mobile_url = esc_url($args['video_file_mobile']); // Mobile video URL

		// Get the file extension for the mobile video
		$mobile_class = ''; // Default class for mobile video
		if ($video_mobile_url) {
			$mobile_file_extension = pathinfo($video_mobile_url, PATHINFO_EXTENSION);
			$mobile_mime_type = cd_get_video_mime_type($mobile_file_extension);

			// Only assign 'mobile' class if mobile MIME type is valid
			if ($mobile_mime_type) {
				$mobile_class = 'mobile';
			}
		}

		// Get the file extension for the desktop video
		$desktop_class = ''; // Default class for desktop video
		if ($video_url) {
			$file_extension = pathinfo($video_url, PATHINFO_EXTENSION);
			$mime_type = cd_get_video_mime_type($file_extension);

			// Only assign 'desktop' class if desktop MIME type is valid
			if ($mime_type) {
				$desktop_class = $mobile_class ? 'desktop' : 'desktop-only'; // Use 'desktop-only' class when there's no mobile version
			}
		}

		// Autoplay & Controls
		$autoplay = $args['video_autoplay'] ? 'autoplay ' : '';
		$controls = $args['video_controls'] ? 'controls ' : '';
		$params = '" width="100%" loop '.$autoplay.$controls.'muted playsinline preload="auto"';
		$not_support_msg = 'Your browser does not support the video tag.';

		// Only render if either video URL is not empty and has a valid MIME type
		if ($desktop_class || $mobile_class) {
			$html .= '<div class="' . $class . '"' . $style . '>';

			$html .= '<div class="' . $class . '-preloader"><span>Loading...</span></div>';
			
			// Render the desktop video if it has a valid MIME type
			if ($desktop_class) {
				$html .= '<video class="' . esc_attr($desktop_class) . '" poster="' . esc_url($poster_img_url) . $params . '>';
				$html .= '<source src="' . esc_url($video_url) . '" type="' . esc_attr($mime_type) . '">';
				$html .= $not_support_msg;
				$html .= '</video>';
			} else {
				if ($mobile_class) {
					$mobile_class = 'mobile-only';
				}
			}

			// Render the mobile video if it has a valid MIME type
			if ($mobile_class) {
				$html .= '<video class="' . esc_attr($mobile_class) . '" poster="' . esc_url($poster_img_url) . $params . '>';
				$html .= '<source src="' . esc_url($video_mobile_url) . '" type="' . esc_attr($mobile_mime_type) . '">';
				$html .= $not_support_msg;
				$html .= '</video>';
			}

		//	$html .= '<div class="video_overlay"></div>';
			$html .= '</div>';
		}

	}

	return $html;
}


// Shortcode handler function
function cd_bgvideo_shortcode($atts) {
	// Merge attributes with defaults
	$defaults = array(
		'url'		=> '',	// video url
		'image'		=> '',	// poster image id, the fallback image for the video
		'opacity'	=> '0',
		'class'		=> '',	// Custom class name, e.g., video_featured
	);

	// Merge user attributes with defaults
	$atts = shortcode_atts($defaults, $atts);

	// Prepare arguments array to send
	$args = array(
		'video_remote'	=> true,
		'video_url'		=> $atts['url'],
		'video_image'	=> $atts['image'],
		'video_opacity'	=> $atts['opacity'],
		'video_class'	=> $atts['class']
	);

	// Call the function to generate and return the HTML output for the image
	return cd_bgvideo($args);
}
// Register the shortcode with WordPress
add_shortcode('bgvideo', 'cd_bgvideo_shortcode');


function cd_megamenu_featured_case_study_shortcode() {
		$args = array(
			'post_type'      => 'case-study',
			'posts_per_page' => 1,
			'orderby'        => 'rand',
			'post_status'    => 'publish',
			'meta_query'     => array(
				array(
					'key'   => 'case_study_featured',
					'value' => '1',
				),
			),
		);

    // Query the posts
    $query = new WP_Query($args);

		// if not found, just get the most recent
		if (!$query->have_posts()) {
			$args = array(
				'post_type'      => 'case-study',
				'posts_per_page' => 1,
				'orderby'        => 'rand',
				'post_status'    => 'publish',
			);
			$query = new WP_Query($args);
		}

    // Check if we have posts
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get the post data
            $post_id = get_the_ID();
            $title = get_the_title();
            $permalink = get_permalink();
						$subtitle = strtoupper(get_field('case_study_client', $post_id));
            $image_id = get_field('case_study_cover_image', get_the_ID()) ?? false;
						if (!$image_id) {
							$image_id = get_post_thumbnail_id($post_id);
						}
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            $image_srcset = wp_get_attachment_image_srcset($image_id, 'full');
						$output = '';

            // Build the HTML output
            $output .= '<a href="' . esc_url($permalink) . '" class="megamenu__featured_case" title="' . esc_attr($title) . '">';
            $output .= '<div class="megamenu__featured_image">';
            $output .= '<picture class="cdb-bgimage carousel__bgimage bgz-reg" style="opacity: 1;">';
            $output .= '<source srcset="' . esc_attr($image_srcset) . '" media="(min-width: 768px)">';
            $output .= '<img decoding="async" src="' . esc_url($image_url) . '" srcset="' . esc_attr($image_srcset) . '" data-imagesize="full">';
            $output .= '</picture>';
            $output .= '</div>';
            $output .= '<div class="title_wrapper"><div class="subtitle sm above"><u>' . esc_html($subtitle) . '</u></div><div class="title h3">' . esc_html($title) . '</div></div>';
            $output .= '<div class="megamenu__featured__link"><span class="link-text">read more</span></div>';
            $output .= '</a>';

            // Reset post data
            wp_reset_postdata();

            return $output;
        }
    } else {
        return '<p>No featured case study found.</p>';
    }
}
add_shortcode('cd_megamenu_featured_case_study', 'cd_megamenu_featured_case_study_shortcode');



function featured_faq_list($section_items, $section_toggle_icon = 'plus', $section_faq_schema = false, $numbered = false, $icon_classes = '', $classes = '' ) {
	global $all_faqs;
	?>
					<dl class="featured_faq__list<?php echo ' toggle-'.$section_toggle_icon; ?> <?php echo esc_attr($classes); ?>">
					<?php
						$number = 0;

						// var_dump($numbered);

						// Loop through all the slides
						foreach( $section_items as $item ) {

							// Get the ACF fields
							$item_anchor_id		= $item['item_anchor_id'] ?? '';		// string
							$item_question		= $item['item_question'] ?? '';			// string
							$item_question_tag	= $item['item_question_tag'] ?? '';		// string
							$item_question_size	= $item['item_question_size'] ?? '';	// string
							$item_answer		= $item['item_answer'] ?? '';			// string
							$item_icon			= $item['item_icon'] ?? false;				
							$item_link 		= $item['item_link'] ?? '';

							$number++;

							if (is_admin()) {
								// Set default values on admin area only
								$item_question = !empty($item_question) ? $item_question : 'Add the title';
							}

							// add the FAQ to globale varibale when it's not in the editor, and if Generate FAQ Schema is true
							if (!is_admin() && $section_faq_schema) {
								$all_faqs[] = [
									"question" => htmlspecialchars(strip_tags($item_question), ENT_QUOTES, 'UTF-8'),
									"answer" => htmlspecialchars(strip_tags(str_replace(["\n", "\r"], " ", $item_answer)), ENT_QUOTES, 'UTF-8')
								];
							}
							
							$anchor_id = '';
							if (!empty($item_anchor_id)) {
								// Get the anchor ID and sanitize it
								$anchor_id = ' id="' . esc_attr(sanitize_html_class($item_anchor_id)) . '"';
							}

							$faq_item_classes = '';
							if ($numbered) {
								$faq_item_classes .= ' featured-faq__item--numbered';
							}
							if ($item_icon) {
								$faq_item_classes .= ' featured-faq__item--icon';
							}

							$empty_answer = false;
							if (empty($item_answer)) {
								$empty_answer = true;
								$faq_item_classes .= ' featured-faq__item--noanswer';
							}

							// Check if item_question exists and is not empty
							if (!empty($item_question)) {
								echo '<div class="featured_faq__item '. esc_attr($faq_item_classes) .'"' . $anchor_id . '>';
								echo	'<dt class="featured_faq__question">';


								if ($numbered) {
									$icon_classes = !empty($icon_classes) ? $icon_classes : 'sc-teal';
									echo '<div class="featured-faq__number '. esc_attr($icon_classes) .'">';
									echo '<span>'.sprintf("%02d", $number) . '</span>';
									echo '</div>';
								} else if ($item_icon) { 
									$icon_classes = !empty($icon_classes) ? $icon_classes : 'sc-lavender';
									echo '<div class="featured-faq__icon '. esc_attr($icon_classes) .'">';
									echo wp_get_attachment_image($item_icon, 'full');
									echo '</div>';
								}

								echo	cd_title(array(
											'title_text'	=> $item_question,
											'title_tag'		=> $item_question_tag,
											'title_size'	=> $item_question_size,
										));
								echo	'<span class="toggle sc-orange"></span></dt>';
								echo	'<dd class="featured_faq__answer"><div class="faq-container">';
								echo wp_kses_post($item_answer);

								if ($item_link) {
									echo '<div class="featured_faq__link">';
									echo '<a href="' . esc_url($item_link) . '" class="btn t-tagline"><span class="link-text">Learn more</span></a>';
									echo '</div>';
								}

								echo  '</div></dd>';
								echo '</div>';
							}

						}
					//	if (!empty($all_faqs)) {
					//		error_log(json_encode($all_faqs, JSON_PRETTY_PRINT));
					//	}
					?>
					</dl>
					<?php

}