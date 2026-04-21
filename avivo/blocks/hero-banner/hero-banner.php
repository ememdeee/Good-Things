<?php
//===================================================================
//	Hero Banner
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Hero Banner';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_image			= get_field('section_image') ?? false;			// array
$section_image_first	= get_field('section_layout') ?? '0';			// string
$section_column_spacing	= get_field('section_column_spacing') ?? 'no';	// string, default no spacing

// Get ACF fields for setting
$section_config									= get_field('section_config') ?? false;			// array
$section_config['section_colour']				= get_field('section_colour') ?? '';			// string
$section_config['section_fullwidth']			= get_field('section_fullwidth') ?? true;		// boolean
$section_config['section_rounded']				= get_field('section_rounded') ?? false;		// boolean
$section_config['section_image_first']			= $section_image_first;							// string
$section_config['section_column_spacing']		= $section_column_spacing;						// string

// Define section element class names
$section_config['section_classname']			= 'cdb-hero_banner';							// section block class name
$section_title['title_class']					= 'hero-banner__title';							// section title wrapper class name
$section_button_row['section_buttons_class']	= 'hero-banner__cta';							// section CTA wrapper class name

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

	// the image
	$image	= wp_get_attachment_image($section_image, 'full');
	$alt_text 	= get_post_meta($section_image, '_wp_attachment_image_alt', true);

?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container">
			
				<div class="content-container">
					<div class="text-container">
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
							echo $image;
						?>
					</div>
				</div>

		</div>
	</section>
<?php } ?>