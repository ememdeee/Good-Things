<?php
//===================================================================
//	Section Heading Bar
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Page Title';
	
// Get the ACF fields
// Front end, set to false or empty by default
$section_title = get_field('section_title') ?? '';				// string

// Get ACF fields for setting
$section_config['section_colour']		= get_field('section_colour') ?? '';			// string
$section_config['section_id']			= get_field('section_id') ?? '';				// string
$section_config['section_class']		= get_field('section_class') ?? '';				// string
$section_config['section_custom_css']	= get_field('section_custom_css') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-heading_bar';					// section block class name

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container">
			<div class="heading_bar-container">
				<div class="title_wrapper">
					<h1 class="title"><?php echo $section_title; ?></h1>
				</div>
			</div>
		</div>
	</section>
<?php } ?>