<?php
//===================================================================
//	Timeline Slider Block
//	Custom Section Block using ACF
//-------------------------------------------------------------------
//  Creates a rotating slideshow of images or content, ideal for
//  dynamic content presentation. Includes options for captions
//  and autoplay to customize the viewing experience.
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Timeline Slider';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');
	
// Get the ACF fields for content slider
$section_title			= get_field('section_title') ?? false;							// array
$section_description	= get_field('section_description') ?? '';						// string
$section_items			= get_field('section_items') ?? false;							// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;							// array
$section_autoplay		= get_field('section_autoplay') ?? false;						// boolean

$section_config['section_colour']			= get_field('section_colour') ?? '';		// string
//	$section_config['section_height']			= get_field('section_height') ?? '30';	// string
//	$section_config['section_height_unit']		= 'vh';									// string

// Define section element class names
$section_config['section_classname']			= 'cdb-timeline_slider';				// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the slider has any slide, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container">
			<div class="content-container">
				<div class="timeline_slider__heading">
					<?php

						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							echo cd_title($section_title);
						}

						// Check if section_description exists
						if ($section_description) {
							echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
						}

					?>
				</div>
				
				<?php
					// if the items are set
					if ($has_items) {
				?>
				<div class="splide slider-container content-container"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>

					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<button class="splide__arrow splide__arrow--prev" id="splide__arrow--prev-timeline"></button>
							<button class="splide__arrow splide__arrow--next" id="splide__arrow--next-timeline"></button>
						</div>
					</div>

					<div class="splide__track">
						<div class="splide__list">
						<?php
							// Loop through all the slides
							foreach( $section_items as $item ) {

								// Get the ACF fields
								// Front end, set to false or empty by default
								$item_title			= $item['item_title'] ?? ['title_text' => ''];	// array with default key
								$item_description	= $item['item_description'] ?? '';				// string

								// Define item element class names
								$section_title['title_class'] = 'timeline-slider__title';			// section title wrapper class name

								// Set default title in admin area
								if (is_admin()) {
									// Ensure 'title_text' is set with a default value in the admin area
									$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Slide Title';
								}
								
								echo '<div class="splide__slide timeline-slider__slide">';
									echo '<div class="timeline-slider__slide_border"></div>';
									echo '<div class="timeline-slider__slide_content">';
										
										// Check if item_title exists and is not empty
										if (isset($item_title) && is_array($item_title)) {
											echo cd_title($item_title);
										}
										
										// Check if item_description exists
										if (!empty($item_description)) {
											echo cd_print_richtext($item_description, '<div class="timeline-slider__slide_description">', '</div>');
										}

									echo '</div>';
								echo '</div>';
							}

						?>
						</div>
					</div>

				</div>
				<?php } ?>

			</div>
		</div>
	</section>
<?php } ?>