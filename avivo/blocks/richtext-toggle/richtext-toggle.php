<?php
//===================================================================
//	Rich Text & Toggle Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Rich Text with Toggle';

// Get the ACF fields for content slider
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_items			= get_field('section_items') ?? false;			// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;					// array
$section_toggle_icon	= get_field('section_toggle_icon') ?? 'plus';			// string
$section_toggle_state	= get_field('section_toggle_state') ?? false;			// boolean

$section_config['section_colour']		= get_field('section_colour') ?? '';	// string

// Define section element class names
$section_config['section_classname']	= 'cdb-richtext_toggle';				// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	$toggle_content = '';

	// check if the toggle has any item
	if ($has_items) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);

		$toggle_content .= '<dl class="richtext-toggle__list toggle-'.$section_toggle_icon.'">';

		// Loop through all the items
		foreach( $section_items as $item ) {

			// Get the ACF fields
			// Front end, set to false or empty by default
			$item_anchor_id		= $item['item_anchor_id'] ?? '';		// string
			$item_title			= $item['item_title'] ?? false;			// array
			$item_description	= $item['item_description'] ?? '';		// string

			if (is_admin()) {
				// Set default values on admin area only
				$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add the title';
			}

			$anchor_id = '';
			if (!empty($item_anchor_id)) {
				// Get the anchor ID and sanitize it
				$anchor_id = ' id="' . esc_attr(sanitize_html_class($item_anchor_id)) . '"';
			}

			// Check if item_title exists and is not empty
			if (isset($item_title) && is_array($item_title)) {
				$toggle_content .= '<div class="richtext-toggle__item"' . $anchor_id . '>';
				$toggle_content .=	'<dt class="richtext-toggle__title">';
				$toggle_content .=		cd_title($item_title);
				$toggle_content .=	'<span class="toggle"></span></dt>';
				$toggle_content .=	'<dd class="richtext-toggle__description"><div class="toggle-container">' . wp_kses_post($item_description) . '</div></dd>';
				$toggle_content .= '</div>';
			}
		}
		
		$toggle_content .= '</dl>';
	}
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> data-toggle-state="<?php echo ($section_toggle_state) ? 'open' : 'close'; ?>">
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
			
				<div class="toggle-wrapper">
					<?php echo $toggle_content; ?>
				</div>

			</div>
		</div>
	</section>
<?php } ?>