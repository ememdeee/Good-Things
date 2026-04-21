<?php
//===================================================================
//	Rich Text & Image
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Rich Text with Image';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_image			= get_field('section_image') ?? false;			// array
$section_image_first	= get_field('section_layout') ?? '0';			// string
$section_layout_style	= get_field('section_layout_style') ?? 'fw2';	// string, default fw2 - fullwidth with large image

// Get ACF fields for setting
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string

if ( in_array($section_layout_style, array('fw3', 'fw4', 'fw6', 'bx1', 'bx2', 'bx3')) ) {
	$section_config['section_rounded']		= get_field('section_rounded') ?? false;			// boolean
}

if ( !in_array($section_layout_style, array('fw5', 'fw6', 'bx3')) ) {
	$section_config['section_height']		= get_field('section_height') ?? '30';				// string
	$section_config['section_height_unit']	= 'vh';												// string
}
$section_config['section_image_first']		= $section_image_first;								// string
$section_config['section_layout_style']		= $section_layout_style;							// string
//	$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
//	$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string
$section_config['section_padding']			= get_field('section_padding') ?? '';				// array
$section_config['section_margin']			= get_field('section_margin') ?? '';				// array
$section_config['section_border']			= get_field('section_border') ?? '';				// array
$section_config['section_id']				= get_field('section_id') ?? '';					// string
$section_config['section_class']			= get_field('section_class') ?? '';					// string
$section_config['section_custom_css']		= get_field('section_custom_css') ?? '';			// string

// Define section element class names
$section_config['section_classname']			= 'cdb-richtext';								// section block class name
$section_title['title_class']					= 'richtext__title';							// section title wrapper class name
$section_button_row['section_buttons_class']	= 'richtext__cta';								// section CTA wrapper class name
$section_image['image_class']					= 'richtext__bgimage';							// section bg image wrapper class name
if ( in_array($section_layout_style, array('fw5', 'fw6', 'bx3')) ) {
	$section_image['image_fit']					= 'reg';										// regular image
} else {
	$section_image['image_size']				= 'large';										// set the image size to retrieve
	$section_image['image_fit']					= get_field('section_bgimage_size') ?? '';		// section bg image fit size
}

// if homepage, add fetch_priority high
if (is_front_page()) {
	$section_image['image_fetch_priority'] = 'high';
}

// the image
$bgimage = '';
// Check if section_image exists and is not empty
if ((isset($section_image) && is_array($section_image))) {
	$bgimage = '<div class="image-wrapper">';
	$bgimage .= cd_bgimage($section_image);
	$bgimage .= '</div>';
}

// check if title is set, if not show the placeholder
if (/*is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])*/ 0 === 1) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
		<?php
			// fullscreen large image
			if ( in_array($section_layout_style, array('fw2')) ) {
				echo $bgimage;
			}
			// large image
			if ( in_array($section_layout_style, array('fw4', 'bx2')) ) {
				echo '<div class="image_smallscreen">';
				echo $bgimage;
				echo '</div>';
			}
		?>
		<div class="container section-container" data-aos="fade-up">
			
			<div class="content-outer">
				<div class="content-container">
					<?php
						// large image
						if ( in_array($section_layout_style, array('fw4', 'bx2')) ) {
							echo $bgimage;
						}
					?>
					<div class="text-container list-checklist">
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

					<div class="image-container">
						<?php
							// not large image
							if ( in_array($section_layout_style, array('fw1', 'fw3', 'fw5', 'fw6', 'bx1', 'bx3')) ) {
								echo $bgimage;
							}
						?>
					</div>

				</div>
			</div>

		</div>
	</section>
<?php } ?>