<?php
//===================================================================
//	Rich Text & Featured Tiles Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Add Richtext & Featured Tiles';
	
// Get the ACF fields
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_items			= get_field('section_items') ?? false;			// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;			// array
$section_config['section_colour']		= get_field('section_colour') ?? '';		// string

$section_no_stacking = get_field('section_no_stacking') ?? false;	// boolean

// Define section element class names
$section_config['section_classname']	= 'cdb-richtext_featured_tiles';			// section block class name

$section_additional_classes = '';
if ($section_no_stacking) {
	$section_additional_classes .= ' cdb-richtext_featured_tiles--no-stacking';
}

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the featured tiles has any tile
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

	// init the variables to store the contents and nav
	$tiles_content = '';
	$tiles_nav = '';

	// check if the tiles has any tile
	if ($has_items) {
		// Loop through all the slides
		foreach( $section_items as $item ) {

			// Get the ACF fields
			// Front end, set to false or empty by default
			$item_anchor_id		= $item['item_anchor_id'] ?? '';		// string
			$item_image			= $item['item_image'] ?? 0;				// integer
			$item_title			= $item['item_title'] ?? false;			// array
			$item_description	= $item['item_description'] ?? '';		// string
			$item_link			= $item['item_link'] ?? '';				// string
			$item_link_text		= $item['item_link_text'] ?? '';		// string

			// Set default title in admin area
			if (is_admin()) {
				// Ensure 'title_text' is set with a default value in the admin area
				$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Title';
			}
			
			$anchor_id = '';
			if (!empty($item_anchor_id)) {
				// Get the anchor ID and sanitize it
				$anchor = esc_attr(sanitize_html_class($item_anchor_id));
				$anchor_id = ' id="' . $anchor . '"';
				
				if (!empty($item_title)) {
					$tiles_nav .= '<li><a href="#'.$anchor.'">'.$item_title['title_text'].'</a></li>';
				}
			}

			$tiles_content .= '<div class="grid-item richtext_featured_tiles__tile"' . $anchor_id . '>';
			$tiles_content .=	'<div class="grid-item-content richtext_featured_tiles__tile_container">';

			// icon
			$tiles_content .=		'<div class="richtext_featured_tiles__tile_icon">';
			$tiles_content .=			'<div class="icon_wrapper">';
			$tiles_content .=				wp_get_attachment_image($item_image, 'full');
			$tiles_content .=			'</div>';
			$tiles_content .=		'</div>';

			$tiles_content .=		'<div class="richtext_featured_tiles__tile_content">';
					
				// Check if item_title exists and is not empty
				if (!empty($item_title)) {
					$item_title['title_class'] = 'richtext_featured_tiles__tile_title';
					$tiles_content .= cd_title($item_title);
				}
				
				// Check if item_description exists
				if (!empty($item_description)) {


					if (!empty($item_link) && !empty($item_link_text)) {
						$item_description .= '<div class="richtext_featured_tiles__tile-button">';
						$item_description .= cd_button(array(
							'text'		=> $item_link_text,
							'link'		=> $item_link,
							'style'		=> 'secondary',
							'size'		=> '',
							'icon'		=> 'r-arrow',
						));
						$item_description .= '</div>';
					} else {
						// Check if item_link exists
						if (!empty($item_link)) {
							$item_description .= ' <span class="richtext_featured_tiles__tile_link_wrapper">';
							$item_description .=	'<a href="'.$item_link.'" class="richtext_featured_tiles__tile_link"><span class="link-text">read more</span></a>';
							$item_description .= '</span>';
						}

					}

				$tiles_content .= cd_print_richtext($item_description, '<div class="richtext_featured_tiles__tile_description list-checklist">', '</div>');
				}

			$tiles_content .=		'</div>';

			$tiles_content .=	'</div>';
			$tiles_content .= '</div>';
		}
	}
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> <?php echo $section_additional_classes; ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">
				
				<div class="content-wrapper">
					<?php

						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							echo cd_title($section_title);
						}
								
						// Check if section_description exists
						if ($section_description) {
							if (!empty($tiles_nav)) {
								$section_description .= '<ul class="tile_nav">'.$tiles_nav.'</ul>';
							}
							echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
						}

						// Ensure section_button_row exists and is an array
						if (isset($section_button_row) && is_array($section_button_row)) {
							echo cd_button_row($section_button_row);
						}

					?>
				</div>
			
				<div class="featured-wrapper">
					<?php
						echo $tiles_content;
					?>
				</div>

			</div>
		</div>
	</section>
<?php }?>