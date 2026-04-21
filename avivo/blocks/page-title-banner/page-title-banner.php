<?php
//===================================================================
//	Section Page Title Banner
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Page Title Banner';

// Get the ACF fields
// Front end, set to false or empty by default
$section_breadcrumbs = get_field('section_breadcrumbs') ?? false;	// boolean
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array
$section_image = get_field('section_image') ?? false;				// array

if (is_admin()) {
	// Set the default value on admin area only
	$section_title = (!empty($section_title) && !empty($section_title['title_text'])) ? $section_title : $default_title;
//	$section_description = (!empty($section_description)) ? $section_description : $default_desc;
//	$section_button_row = ($section_button_row !== null && $section_button_row !== []) ? $section_button_row : $default_button_row;
}

// Get ACF fields for setting
$section_config['section_colour']			= get_field('section_colour') ?? '';			// string
$section_config['section_height']			= get_field('section_height') ?? '30';			// string
$section_config['section_height_unit']		= 'vh';											// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';		// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';	// string
$section_config['section_padding']			= get_field('section_padding') ?? '';			// array
$section_config['section_margin']			= get_field('section_margin') ?? '';			// array
$section_config['section_border']			= get_field('section_border') ?? '';			// array
$section_config['section_id']				= get_field('section_id') ?? '';				// string
$section_config['section_class']			= get_field('section_class') ?? '';				// string
$section_config['section_custom_css']		= get_field('section_custom_css') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-page_title_banner';					// section block class name
$section_title['title_class']					= 'page_title_banner__title';				// section title wrapper class name
$section_button_row['section_buttons_class']	= 'page_title_banner__cta';					// section CTA wrapper class name
$section_image['image_fit']						= get_field('section_bgimage_size') ?? '';	// section bg image fit size
$section_image['image_class']					= 'page_title_banner__bgimage';				// section bg image wrapper class name

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
		<?php
			// fullwidth bg image
			if ((isset($section_image) && is_array($section_image))) {
				echo cd_bgimage($section_image);
			}
		?>
		<div class="container section-container">
			<div class="content-container">
			<div class="page-title-banner__content">
			<?php

				// Breadcrumbs
				if ($section_breadcrumbs) {
					// Check if the Yoast Breadcrumbs function exists
				//	if (function_exists('yoast_breadcrumb')) {
				//		yoast_breadcrumb('<div class="breadcrumbs-container">', '</div>');
				//	}
				
					// Check if the Breadcrumbs function exists
					if (function_exists('cd_breadcrumbs')) {
						echo '<div class="breadcrumbs-container">';
						cd_breadcrumbs();
						echo '</div>';
					}
				}

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

		<?php // when post type is case study, add back to work button ?>
		<?php if (is_singular('case-study')) { ?>
			<div class="page-title-banner__back">
				<div class="container">
					<a href="/work" class="t-light cdb-icon sw-left">
					<i class="ic-arrow-left"></i>
					Back to Work
				</a>
				</div>
			</div>
		<?php } ?>

	</section>
<?php } ?>