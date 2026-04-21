<?php
//===================================================================
//	Rich Text & Logo Grid Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Rich Text with Logo Grid';

// Get the ACF fields
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_items			= get_field('section_items') ?? false;			// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;			// array
$section_column			= get_field('section_column') ?? '5';			// string, default 5 columns

$section_config['section_colour']				= get_field('section_colour') ?? '';					// string
$section_config['section_column']				= $section_column;
$section_config['section_grid_spacing']			= get_field('section_grid_spacing') ?? '';				// string
$section_config['section_grid_item_height']		= get_field('section_grid_item_height') ?? '';			// string
$section_config['section_grid_image_size']		= get_field('section_grid_image_size') ?? '';			// string
$section_config['section_grid_image_color']		= get_field('section_grid_image_color') ?? '';			// string
$section_config['section_grid_image_bg']		= get_field('section_grid_image_bg') ?? '';				// string
$section_config['section_grid_image_bg_round']	= get_field('section_grid_image_bg_round') ?? false;	// boolean

if (!$section_config['section_grid_image_bg']) {
	$section_config['section_grid_image_bg_round']	= false;
}

$image_size = (intval($section_column) <= 3) ? 'large' : ((intval($section_column) > 5) ? 'thumbnail' : 'medium');

// Define section element class names
$section_config['section_classname']			= 'cdb-richtext_logo_grid';		// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

	$grid_content = '';
	// check if the tiles has any tile
	if ($has_items) {
		$grid_content .= '<div class="small-grid-container'. cd_get_logo_grid_class($section_config) .'">';

		// Loop through all the slides
		foreach( $section_items as $item ) {

			// Get the ACF fields
			// Front end, set to false or empty by default
			$item_image			= $item['item_image'] ?? 0;				// integer
			$item_title			= $item['item_title'] ?? '';			// string
			$item_link			= $item['item_link'] ?? '';				// string

			// check the link
			$link_open_tag = '';
			$link_close_tag = '';
			
			$alt_text = '';
			if (!empty($item_image)) {
				$alt_text = get_post_meta($item_image, '_wp_attachment_image_alt', true);
			}

			if (!empty($item_link)) {
				$item_title = !empty($item_title) ? $item_title : $alt_text;
				$link_open_tag = '<a href="' . esc_url($item_link) . '"' . (!empty($item_title) ? ' title="' . esc_attr($item_title) . '"' : '') . '>';
				$link_close_tag = '</a>';
			}

			$grid_content .= '<div class="grid-item logo_grid__tile">';
				$grid_content .= $link_open_tag;

				$bgImage = cd_bgimage(array(
					'image_desktop'	=> $item_image,
					'image_size'	=> $image_size,	// set the image size to retrieve, default 'full'
					'image_class'	=> '',		// Custom class name
					'image_loading' => 'lazy'
				));
				$grid_content .= $bgImage;
				
				if (empty($bgImage)) {
					// Check if item_title exists and is not empty
					if (!empty($item_title)) {
						$grid_content .= '<div class="logo_grid__tile_content">';
						$grid_content .= 	esc_html($item_title);
						$grid_content .= '</div>';
					}
				}

				$grid_content .= $link_close_tag;
			$grid_content .= '</div>';
		}
		
		$grid_content .= '</div>';
	}
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container">
			<div class="content-container">
				
				<div class="content-wrapper">
					<?php

						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							echo cd_title($section_title);
						}
								
						// Check if section_description exists
						if ($section_description) {
							echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
						}

						// Ensure section_button_row exists and is an array
						if (isset($section_button_row) && is_array($section_button_row)) {
							echo cd_button_row($section_button_row);
						}

					?>
				</div>
			
				<div class="logo-grid-wrapper">
					<?php
						echo $grid_content;
					?>
				</div>

			</div>
		</div>
	</section>
<?php } ?>