<?php
//===================================================================
//	Featured Banner
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Featured Banner';

// Get block ID
$block_id = esc_attr($block['id']);

// Get the ACF fields
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config							= get_field('section_config') ?? false;		// array
$section_config['section_colour']		= get_field('section_colour') ?? '';		// string

// Define section element class names
$section_config['section_classname']	= 'cdb-featured_banner';					// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the slider has any slide, if not show the placeholder
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// check if the slider has any slide
	if ($has_items) {

		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container">
				<div class="content-container featured-container">
					<?php
						// init vars
						$text_content	= '';
						$counter		= 0;

						// Loop through all the slides
						foreach( $section_items as $item ) {

							// Get the ACF fields
							$item_image			= $item['item_image'] ?? 0;						// integer
							$item_title			= $item['item_title'] ?? ['title_text' => ''];	// array with default key
							$item_description	= $item['section_description'] ?? '';			// string
							$item_button_row	= $item['item_button_row'] ?? false;			// array

							// the image
							$image	= wp_get_attachment_image($item_image, 'full');
							$alt_text 	= get_post_meta($item_image, '_wp_attachment_image_alt', true);

							// Set default title in admin area
							if (is_admin()) {
								// Ensure 'title_text' is set with a default value in the admin area
								$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Banner Title';
							}

							// anchor id
							$anchor_id = $block_id.'-'.($counter++);

							// featured text content
							$text_content .= '<div class="featured-content-inner" id="'.$anchor_id.'">';
							$text_content .= '<div class="text-container">';
							$text_content .= '<div class="text-dot"><div class="inner-dot"></div></div>';
							// Check if section_title exists and is not empty
							if (isset($item_title) && is_array($item_title)) {
								$text_content .= cd_title($item_title);
							}
									
							// Check if section_description exists
							if ($item_description) {
								$text_content .= cd_print_richtext( $item_description,'<div class="content__description">','</div>' );
							}

							// Ensure section_button_row exists and is an array
							if (isset($item_button_row) && is_array($item_button_row)) {
								$text_content .= cd_button_row($item_button_row);
							}
							$text_content .= '</div>';

							$text_content .= '<div class="image-container">';
							$text_content .= $image;
							$text_content .= '</div>';
							$text_content .= '</div>';
						}
					?>

					<div class="featured-progress">
						<div class="progress_top_overlay"></div>
						<div class="progress_line"></div>
						<div class="progress_track"></div>
						<div class="progress_bottom_overlay"></div>
						<div class="progress_line_cover"></div>
					</div>
					
					<div class="featured-content">
						<?php echo $text_content; ?>
					</div>

				</div>
			</div>
		</section>
<?php
		}
	}
?>