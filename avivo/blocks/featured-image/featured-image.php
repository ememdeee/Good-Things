<?php
//===================================================================
//	Section Featured Image
//	Custom Section Block using ACF
//-------------------------------------------------------------------
//	Image Type
//	'I' - Image (default), standard image
//	'F' - Background Image - Fullwidth
//	'B' - Background Image - Boxed
//-------------------------------------------------------------------
//	Rounded Corner - True/False
//	This option is only for 'I' and 'B'
//-------------------------------------------------------------------
//	Height
//	Setting for the section height, only for 'F' and 'B'
//	if it's 'I' set to '' (empty)
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Featured Image';

// Get the ACF fields
// Front end, set to false or empty by default
$section_image = get_field('section_image') ?? false;				// array
$section_title = '';

if (is_admin()) {
	// Set the default value on admin area only
	$section_title = (!empty($section_image) && !empty($section_image['image_desktop'])) ? '' : '<h2>Choose your featured image</h2>';
}

// Get ACF fields for setting
$section_config['section_colour']			= get_field('section_colour') ?? '';			// string
$section_image_type							= get_field('section_image_type') ?? 'I';		// string
$section_config['section_image_type']		= $section_image_type;
$section_config['section_image_rounded']	= ($section_image_type !== 'F') ? (get_field('section_image_rounded') ?? false) : false;
$section_config['section_fullwidth']		= ($section_image_type === 'F');				// boolean, for fullwidth image
$section_config['section_padding']			= get_field('section_padding') ?? '';			// array
$section_config['section_margin']			= get_field('section_margin') ?? '';			// array
$section_config['section_border']			= get_field('section_border') ?? '';			// array
$section_config['section_id']				= get_field('section_id') ?? '';				// string
$section_config['section_class']			= get_field('section_class') ?? '';				// string
$section_config['section_custom_css']		= get_field('section_custom_css') ?? '';		// string

// get the height if image type is not 'I'
if ($section_image_type !== 'I') {
	$section_config['section_height']		= get_field('section_height') ?? '30';			// string
	$section_config['section_height_unit']	= 'vh';											// string
}

// Define section element class names
$section_config['section_classname']			= 'cdb-featured_image';						// section block class name
$section_image['image_fit']						= get_field('section_bgimage_size') ?? '';	// section bg image fit size
$section_image['image_class']					= 'featured_image__bgimage';				// section bg image wrapper class name

// the image
$bgImage = cd_bgimage($section_image);

// check if bgimage is set, if not show the placeholder
if (is_admin() && empty($bgImage)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	if (!empty($bgImage)) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
			<?php echo $bgImage; ?>
		</section>
<?php
 	}
}
?>