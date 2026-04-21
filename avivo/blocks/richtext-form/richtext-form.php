<?php
//===================================================================
//	Rich Text & Form
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Rich Text with Form';

// Enqueue script and style for the slider
wp_enqueue_script('nouislider-script');
wp_enqueue_style('nouislider-style');


// Get the ACF fields
// Front end, set to false or empty by default
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_form			= get_field('section_form') ?? '';				// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_empty_form = get_field('section_empty_form') ?? false;		// boolean

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// section color
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-richtext_form';			// section block class name
$section_title['title_class']					= 'richtext_form__title';		// section title wrapper class name
$section_button_row['section_buttons_class']	= 'richtext_form__cta';			// section CTA wrapper class name

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container">
			<div class="content-container">

				<div class="form-container">
				<?php
					// Check if section_form exists
					if ($section_form) {
						echo gravity_form($section_form, false, false, false, '', true, 1, false);
					} else {
						if ($section_empty_form) {
							echo cd_print_richtext( $section_empty_form,'<div class="richtext_form__empty">','</div>' );
						}
					}
				?>
				</div>
				
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
					
			</div>
		</div>
	</section>
<?php } ?>