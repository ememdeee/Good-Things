<?php
//===================================================================
//	Carousel Block
//	Custom Section Block using ACF
//-------------------------------------------------------------------
//  Creates a rotating slideshow of images or content, ideal for
//  dynamic content presentation. Includes options for captions
//  and autoplay to customize the viewing experience.
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Carousel';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');
	
// Get the ACF fields for content slider
$section_items			= get_field('section_items') ?? false;			// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;			// array
$section_image_first	= get_field('section_layout') ?? '0';			// string
$section_layout_style	= get_field('section_layout_style') ?? 'fw2';	// string, default fw2 - fullwidth with large image
$section_autoplay		= get_field('section_autoplay') ?? false;		// boolean

$section_config['section_colour']			= get_field('section_colour') ?? '';				// string

if ( in_array($section_layout_style, array('fw3', 'fw4', 'fw6', 'bx1', 'bx2', 'bx3')) ) {
	$section_config['section_rounded']		= get_field('section_rounded') ?? false;			// boolean
}

if ( !in_array($section_layout_style, array('fw5', 'fw6', 'bx3')) ) {
	$section_config['section_height']		= get_field('section_height') ?? '30';				// string
	$section_config['section_height_unit']	= 'vh';												// string
}
$section_config['section_image_first']		= $section_image_first;								// string
$section_config['section_layout_style']		= $section_layout_style;							// string

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the slider has any slide, if not show the placeholder
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Define section element class names
	$section_config['section_classname']			= 'cdb-carousel';		// section block class name

	// check if the slider has any slide
	if ($has_items) {
		// fullscreen large image
		$content_container_class = '';
		$section_container_class = 'container ';
		if ( in_array($section_layout_style, array('fw2', 'fw4', 'bx2')) ) {
			$content_container_class = 'container ';
			$section_container_class = '';
		}

		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
			<div class="<?php echo $section_container_class; ?>section-container">
				<div class="splide slider-container"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>

					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<div class="splide__arrows_inner_container">
								<button class="splide__arrow splide__arrow--prev"></button>
								<button class="splide__arrow splide__arrow--next"></button>
							</div>
						</div>
					</div>

					<div class="splide__track">
						<div class="splide__list">
						<?php
							// Loop through all the slides
							foreach( $section_items as $item ) {
								
								// Get the ACF fields
								// Front end, set to false or empty by default
								$item_title			= $item['item_title'] ?? false;				// array
								$item_description	= $item['item_description'] ?? '';			// string
								$item_button_row	= $item['item_button_row'] ?? false;		// array
								$item_image			= $item['item_image'] ?? false;				// array

								// Define item element class names
								$section_title['title_class']	= 'carousel__title';					// section title wrapper class name
								$item_image['image_class']		= 'carousel__bgimage';					// section bg image wrapper class name
								if ( in_array($section_layout_style, array('fw5', 'fw6', 'bx3')) ) {
									$item_image['image_fit']	= 'reg';								// regular image
								} else {
									$item_image['image_size']	= 'large';								// set the image size to retrieve
									$item_image['image_fit']	= $item['section_bgimage_size'] ?? '';	// string
								}

								// Set default title in admin area
								if (is_admin()) {
									// Ensure 'title_text' is set with a default value in the admin area
									$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Slide Title';
								}

								// the image
								$bgimage = '';
								// Check if item_image exists and is not empty
								if ((isset($item_image) && is_array($item_image))) {
									$bgimage = '<div class="image-wrapper">';
									$bgimage .= cd_bgimage($item_image);
									$bgimage .= '</div>';
								}
								
								echo '<div class="content-outer splide__slide carousel__slide">';
									// fullscreen large image
									if ( in_array($section_layout_style, array('fw2')) ) {
										echo $bgimage;
									}
									// large image
									if ( in_array($section_layout_style, array('fw4', 'bx2')) ) {
										echo '<div class="image_smallscreen">';
										echo $bgimage;
										echo '</div>';
									}
									echo '<div class="' . $content_container_class .'content-container">';

										// large image
										if ( in_array($section_layout_style, array('fw4', 'bx2')) ) {
											echo $bgimage;
										}

										echo '<div class="text-container carousel__slide_content">';
											
											// Check if item_title exists and is not empty
											if (isset($item_title) && is_array($item_title)) {
												echo cd_title($item_title);
											}
											
											// Check if item_description exists
											if (!empty($item_description)) {
												echo cd_print_richtext($item_description, '<div class="carousel__slide_description">', '</div>');
											}

											// Ensure item_button_row exists and is an array
											if (isset($item_button_row) && is_array($item_button_row)) {
												echo cd_button_row($item_button_row);
											}

										echo '</div>';

										echo '<div class="image-container">';
											// not large image
											if ( in_array($section_layout_style, array('fw1', 'fw3', 'fw5', 'fw6', 'bx1', 'bx3')) ) {
												echo $bgimage;
											}
										echo '</div>';

									echo '</div>';
								echo '</div>';
							}

						?>
						</div>
					</div>

				</div>
			</div>
		</section>
<?php
		}
	}
?>