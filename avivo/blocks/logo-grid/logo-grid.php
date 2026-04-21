<?php
//===================================================================
//	Logo Grid Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Logo Grid';

// Get the ACF fields for content slider
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array
$section_column		= get_field('section_column') ?? '5';		// string, default 5 columns

$section_config['section_colour']				= get_field('section_colour') ?? '';					// string
$section_config['section_content_width']		= get_field('section_content_width') ?? '';				// string
$section_config['section_content_position']		= get_field('section_content_position') ?? '';			// string
$section_config['section_column']				= $section_column;
$section_config['section_grid_spacing']			= get_field('section_grid_spacing') ?? '';				// string
$section_config['section_grid_item_height']		= get_field('section_grid_item_height') ?? '';			// string
$section_config['section_grid_image_size']		= get_field('section_grid_image_size') ?? '';			// string
$section_config['section_grid_image_color']		= get_field('section_grid_image_color') ?? '';			// string
$section_config['section_grid_image_bg']		= get_field('section_grid_image_bg') ?? false;			// boolean
$section_config['section_grid_image_bg_round']	= get_field('section_grid_image_bg_round') ?? false;	// boolean
$section_config['section_grid_flex']			= get_field('section_grid_flex') ?? false;				// boolean

if (!$section_config['section_grid_image_bg']) {
	$section_config['section_grid_image_bg_round']	= false;
}

$image_size = (intval($section_column) <= 3) ? 'large' : ((intval($section_column) > 9) ? 'thumbnail' : 'medium');

// Define section element class names
$section_config['section_classname']			= 'cdb-logo_grid';										// section block class name

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
				<div class="small-grid-container content-container<?php echo cd_get_logo_grid_class($section_config); ?>">
				<?php
					// Loop through all the slides
					foreach( $section_items as $item ) {

						// Get the ACF fields
						// Front end, set to false or empty by default
						$item_image			= $item['item_image'] ?? 0;				// integer
						$item_title			= $item['item_title'] ?? '';			// string
						$item_link			= $item['item_link'] ?? '';				// string
						
						// check the link
						$link_open_tag = '';
						$link_close_tag = '';

						$alt_text = '';
						if (!empty($item_image)) {
							$alt_text = get_post_meta($item_image, '_wp_attachment_image_alt', true);
						}

						if (!empty($item_link)) {
							$item_title = !empty($item_title) ? $item_title : $alt_text;
							$link_open_tag = '<a href="' . esc_url($item_link) . '"' . (!empty($item_title) ? ' title="' . esc_attr($item_title) . '"' : '') . '>';
							$link_close_tag = '</a>';
						}

						echo '<div class="grid-item logo_grid__tile">';
							echo $link_open_tag;

							$bgImage = cd_bgimage(array(
								'image_desktop'	=> $item_image,
								'image_size'	=> $image_size,	// set the image size to retrieve, default 'full'
								'image_class'	=> ''		// Custom class name
							));
							echo $bgImage;
							
							if (empty($bgImage)) {
								// Check if item_title exists and is not empty
								if (!empty($item_title)) {
									echo '<div class="logo_grid__tile_content">';
									echo esc_html($item_title);
									echo '</div>';
								}
							}

							echo $link_close_tag;
						echo '</div>';
					}

				?>
				</div>
			</div>
		</section>
<?php
		}
	}
?>