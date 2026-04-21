<?php
//===================================================================
//	Section Video Banner
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Video Banner';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array
$section_video = get_field('section_video') ?? false;				// array

// Get ACF fields for setting
$section_video_width						= get_field('section_video_width') ?? 'fullwidth';	// string
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_video_width']		= $section_video_width;								// string
$section_config['section_fullwidth']		= (($section_video_width === 'fullwidth') || ($section_video_width === 'full-ar'));			// boolean
$section_config['section_video_rounded']	= get_field('section_video_rounded') ?? false;		// boolean
$section_config['section_height']			= get_field('section_height') ?? '';				// string
$section_config['section_height_unit']		= 'vh';												// string
$section_config['section_aspect_ratio']		= $section_video['video_aspect_ratio'] ?? false;	// array
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string
$section_config['section_padding']			= get_field('section_padding') ?? false;			// array
$section_config['section_margin']			= get_field('section_margin') ?? false;				// array
$section_config['section_border']			= get_field('section_border') ?? false;				// array
$section_config['section_id']				= get_field('section_id') ?? '';					// string
$section_config['section_class']			= get_field('section_class') ?? '';					// string
$section_config['section_custom_css']		= get_field('section_custom_css') ?? '';			// string

// Define section element class names
$section_config['section_classname']			= 'cdb-video_banner';				// section block class name
$section_title['title_class']					= 'video_banner__title';			// section title wrapper class name
$section_button_row['section_buttons_class']	= 'video_banner__cta';				// section CTA wrapper class name
$section_video['video_class']					= 'video_banner__bgvideo';			// section bg video wrapper class name

// check if title is set, if not show the placeholder
if (is_admin() && !(isset($section_video) && is_array($section_video) && (!empty($section_video['video_url']) || !empty($section_video['video_file'])))) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
		<?php
			// fullwidth bg video
			if ((isset($section_video) && is_array($section_video))) {
				echo cd_bgvideo($section_video);
			}

			// Check if any of the content exists before outputting the container
			if ( (isset($section_title) && is_array($section_title) && !empty($section_title['title_text'])) || !empty($section_description) ) {
				echo '<div class="container section-container">';
					echo '<div class="content-container">';

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

					echo '</div>'; // Close content-container
				echo '</div>'; // Close section-container
			}
		?>
		<div id="scroll_afterVideo">
			<a href="#afterVideo" class="cdb-icon sm"><i class="ic-scroll"></i><span class="link-text">SCROLL DOWN</span></a>
		</div>
	</section>
	<div id="afterVideo"></div>
<?php } ?>