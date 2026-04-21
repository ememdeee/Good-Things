<?php
//===================================================================
//	Section Featured Statement
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Statement Title';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array
$section_image = get_field('section_image') ?? false;				// array

// Get ACF fields for setting
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_height']			= get_field('section_height') ?? '30';				// string
$section_config['section_height_unit']		= 'vh';												// string
$section_config['section_fullwidth']		= get_field('section_fullwidth') ?? true;			// boolean
$section_config['section_image_rounded']	= get_field('section_image_rounded') ?? false;		// boolean
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string
$section_config['section_padding']			= get_field('section_padding') ?? '';				// array
$section_config['section_margin']			= get_field('section_margin') ?? '';				// array
$section_config['section_border']			= get_field('section_border') ?? '';				// array
$section_config['section_id']				= get_field('section_id') ?? '';					// string
$section_config['section_class']			= get_field('section_class') ?? '';					// string
$section_config['section_custom_css']		= get_field('section_custom_css') ?? '';			// string

// Define section element class names
$section_config['section_classname']			= 'cdb-featured_statement';						// section block class name
$section_title['title_class']					= 'featured_statement__title';					// section title wrapper class name
$section_button_row['section_buttons_class']	= 'featured_statement__cta';					// section CTA wrapper class name
$section_image['image_fit']						= get_field('section_bgimage_size') ?? '';		// section bg image fit size
$section_image['image_overlay']					= get_field('section_image_overlay') ?? '0';	// section image overlay opacity
$section_image['image_class']					= 'featured_statement__bgimage';				// section bg image wrapper class name

$section_style = get_field('section_style') ?? 'default'; // string

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// content is not fullwidth
	$bgImage = cd_bgimage($section_image);

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> cdb-featured_statement--style-<?php echo esc_attr($section_style); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?> data-aos="fade-in">
		<?php
			// bg image
			if ((isset($section_image) && is_array($section_image))) {
				echo cd_bgimage($section_image);
			}
		?>
		<div class="container section-container" data-aos="fade-up" data-aos-delay="200">
			<div class="content-container">
				<div class="featured-statement__content">
					<?php
						if ($section_style === 'testimonial') { ?>
							<div class="featured-statement__quote-icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="90" height="68" fill="none" viewBox="0 0 90 68"><path fill="#ff8038" d="M56.25 67.758h25.313c4.652 0 8.437-3.784 8.437-8.437V34.008c0-4.652-3.785-8.437-8.437-8.437H70.21l4.27-21.963a2.812 2.812 0 0 0-2.761-3.35h-9.112c-2.446 0-4.62 1.6-5.36 3.917L49.06 23.596a3 3 0 0 0-.119.34 30.9 30.9 0 0 0-1.129 8.282V59.32c0 4.653 3.785 8.437 8.438 8.437M8.438 67.758H33.75c4.653 0 8.438-3.784 8.438-8.437V34.008c0-4.652-3.785-8.437-8.438-8.437H22.396l4.27-21.963a2.8 2.8 0 0 0-.59-2.327 2.8 2.8 0 0 0-2.17-1.023h-9.113a5.64 5.64 0 0 0-5.358 3.918l-8.188 19.42a3 3 0 0 0-.118.34A31 31 0 0 0 0 32.219V59.32c0 4.653 3.785 8.437 8.438 8.437"/></svg>
							</div>
						<?php } ?>

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
			</div>
		</div>
	</section>
<?php } ?>