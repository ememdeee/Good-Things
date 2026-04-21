<?php
//===================================================================
//	Featured Tiles Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Featured Tiles';

// Icons
$arrGridIcon = array(
	'N' => 'gic-none',
	'L' => 'gic-left',
	'T' => 'gic-top',
	'B' => 'gic-title',
);

// Get the ACF fields
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array

$section_config['section_colour']		= get_field('section_colour') ?? '';			// string
$section_config['section_column']		= get_field('section_column') ?? '3';			// string, default 3 columns
$section_config['section_grid_style']	= get_field('section_grid_style') ?? '';		// string
$section_config['section_grid_padding']	= get_field('section_grid_padding') ?? '';		// string
$section_config['section_grid_spacing']	= get_field('section_grid_spacing') ?? '';		// string


// Define section element class names
$section_config['section_classname']	= 'cdb-featured_tiles';							// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;



// check if the featured tiles has any tile
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// if the items are set
	if ($has_items) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
		?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container" data-aos="fade-up">
				<div class="grid-container content-container<?php echo cd_get_section_grid_class($section_config); ?>">
				<?php
					// Loop through all the slides
					foreach( $section_items as $item ) {

						// Get the ACF fields
						// Front end, set to false or empty by default
						$item_show_icon		= $item['item_show_icon'] ?? 'N';		// string > 'N', 'L', 'T', 'B'
						$item_image			= $item['item_image'] ?? 0;				// integer
						$item_title			= $item['item_title'] ?? false;			// array
						$item_description	= $item['item_description'] ?? '';		// string
						$item_link			= $item['item_link'] ?? '';				// string
						$item_link_text		= $item['item_link_text'] ?? '';		// string
						$item_variant_colour = $item['item_variant_colour_variant_colour'] ?? 'default'; // string

						$no_desc_class = empty($item_description) ? ' no-desc' : '';
						$no_desc_class .= (!empty($item_link)) ? ' has-link' : '';

						// Set default title in admin area
						if (is_admin()) {
							// Ensure 'title_text' is set with a default value in the admin area
							$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Title';
						}

						$colour_class = '';
						// if ($item_variant_colour && $item_variant_colour !== 'default') {
							$colour_class .= ' sc-' . $item_variant_colour;
						// }

						echo '<div class="grid-item featured_tiles__tile ' . $arrGridIcon[$item_show_icon] . $no_desc_class . $colour_class . '">';
							echo '<div class="grid-item-content featured_tiles__tile_container">';

								// if not 'No Icon'
								if ($item_show_icon !== 'N') {
									$icon = wp_get_attachment_image($item_image, 'thunbnail');

									echo '<div class="featured_tiles__tile_icon">';
									echo	'<div class="icon_wrapper">';
									echo		$icon;
									echo	'</div>';
									echo '</div>';
								}

								echo '<div class="featured_tiles__tile_content">';
									
									// Check if item_title exists and is not empty
									if (!empty($item_title)) {
										$item_title['title_class'] = 'featured_tiles__tile_title';
										echo cd_title($item_title);
									}
									
									// Check if item_description exists
									if (!empty($item_description)) {								
										echo cd_print_richtext($item_description, '<div class="featured_tiles__tile_description">', '</div>');
									}

									// Check if item_link exists
									if (!empty($item_link)) {
										$item_link_text = empty($item_link_text) ? 'read more' : $item_link_text;

										// echo '<div class="featured_tiles__tile_link_wrapper">';
										// echo '<a href="' . esc_url($item_link) . '" class="featured_tiles__tile_link"><span class="link-text">' . esc_html($item_link_text) . '</span></a>';
										// echo '</div>';

										$button_class = 't-tagline';
										// if ($tile_color && $tile_color === 'dark') {
										// 	$button_class = 'light';
										// }

										echo '<div class="featured_tiles__tile-button">';
										echo cd_button(array(
											'text'		=> $item_link_text,
											'link'		=> $item_link,
											'style'		=> $button_class . '',
											'size'		=> '',
											// 'icon'		=> 'r-arrow',
										));
										echo '</div>';

									}

								echo '</div>';

							echo '</div>';
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