<?php
//===================================================================
//	Featured Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Featured Slider';
	
// Get the ACF fields for content slider
$section_items		= get_field('section_items') ?? false;			// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;			// array
$section_autoplay	= get_field('section_autoplay') ?? false;		// boolean

$section_config['section_colour']		= get_field('section_colour') ?? '';			// string
$section_config['section_height']		= get_field('section_height') ?? '30';			// string
$section_config['section_height_unit']	= 'vh';											// string

// Define section element class names
$section_config['section_classname']		= 'cdb-featured_slider';		// section block class name

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
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
			<div class="section-container">
				<div class="cdfslide slider-container"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>

					<div class="cdfslide__arrows">
						<div class="cdfslide__arrows_container">
							<button class="cdfslide__arrow slide__arrow--prev content-container"><span class="arrow-content link-text"><span class="arrow-desc">PREV UP</span><span class="arrow-title"></span></span></button>
							<button class="cdfslide__arrow slide__arrow--next content-container"><span class="arrow-content link-text"><span class="arrow-desc">NEXT UP</span><span class="arrow-title"></span></span></button>
						</div>
					</div>

					<div class="cdfslide__list">
					<?php
						$index = 0;
						$page_dot = '';
						// Loop through all the slides
						foreach( $section_items as $item ) {

							// Get the ACF fields
							// Front end, set to false or empty by default
							$item_name			= $item['item_name'] ?? '';						// string
							$item_logo			= $item['item_logo'] ?? 0;						// integer
							$item_image			= $item['item_image'] ?? false;					// array
							$item_title			= $item['item_title'] ?? ['title_text' => ''];	// array with default key
							$item_link			= $item['item_link'] ?? '';						// string
							$item_link_text		= $item['item_link_text'] ?? '';				// string

							// Define section element class names
							$item_title['title_class'] = 'featured-slider__title';				// section title wrapper class name

							// Set default title in admin area
							if (is_admin()) {
								// Ensure 'title_text' is set with a default value in the admin area
								$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Slide Title';
							}

							// pagination dot
							$page_dot .= '<li class="pagination-dot" data-index="'.$index++.'"></li>';

							echo '<div class="cdfslide__slide" data-title="'.esc_attr($item_name).'">';

								$bgImage = cd_bgimage($item_image);
								echo $bgImage;

								// Check if item_link exists, slide link
								if (!empty($item_link)) {
									echo '<a href="' . esc_url($item_link) . '" title="' . esc_html($item_name) . '" class="featured-slider__slide_link"></a>';
								}

								// content
								echo'<div class="container content-container">';
								echo	'<div class="content-wrapper">';

									// logo image
									$logo = wp_get_attachment_image($item_logo, 'full');
									if ($logo) {
										echo '<div class="featured-slider__slide_logo">';
										echo	$logo;
										echo '</div>';
									}

									echo '<div class="featured-slider__slide_content">';
										// Check if item_title exists and is not empty
										if (isset($item_title) && is_array($item_title)) {
											echo cd_title($item_title);
										}
										
										// Check if item_link exists, button link
										if (!empty($item_link)) {
											$item_link_text = empty($item_link_text) ? 'read more' : $item_link_text;

											echo '<div class="featured-slider__link_wrapper">';
											echo '<span class="featured-slider__link"><span class="link-text">' . esc_html($item_link_text) . '</span></span>';
											echo '</div>';
										}
									echo '</div>';

								echo	'</div>';
								echo '</div>';

							echo '</div>';
						}

					?>
					</div>

					<div class="paging-container">
						<div class="container">
							<ul class="cdfslide__pagination"><?php echo $page_dot; ?></ul>
						</div>
					</div>

				</div>
			</div>
		</section>
<?php
		}
	}
?>