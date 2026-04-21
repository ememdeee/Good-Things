<?php
//===================================================================
//	Button Row
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Button Row';

// Get the ACF fields
// Front end, set to false or empty by default
$section_button_row = get_field('section_button_row') ?? false;		// array

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// section color
$section_config['section_colour']				= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']		= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']		= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-button_row';		// section block class name
$section_button_row['section_buttons_class']	= 'button_row__cta';	// section CTA wrapper class name

// Check if section_button_row has buttons
$has_buttons = isset($section_button_row) && is_array($section_button_row) && isset($section_button_row['section_buttons']) && is_array($section_button_row['section_buttons']) && count($section_button_row['section_buttons']) > 0;

// check if the slider has any slide, if not show the placeholder
if (is_admin() && !$has_buttons) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} 
// check if the slider has any slide
if ($has_buttons) {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container">
			<div class="content-container">
			<?php
				// Ensure section_button_row exists and is an array
				if (isset($section_button_row) && is_array($section_button_row)) {
					echo cd_button_row($section_button_row);
				}
			?>
			</div>
		</div>
	</section>
<?php } ?>