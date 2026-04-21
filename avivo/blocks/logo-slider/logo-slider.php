<?php
//===================================================================
//	Logo Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Logo Slider';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_script('splide-slider-autoscroll-script');
wp_enqueue_style('splide-slider-style');

// Get the ACF fields for content slider
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array

$section_config['section_colour']				= get_field('section_colour') ?? '';					// string

// Define section element class names
$section_config['section_classname']			= 'cdb-logo_slider';										// section block class name

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
			<div class="container section-container" data-aos="fade-up">
			<div class="content-container logo-slider">
				<div class="logo-slider__slider splide" data-autoplay="1">

					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<button class="splide__arrow splide__arrow--prev"></button>
							<button class="splide__arrow splide__arrow--next"></button>
						</div>
					</div>

					<div class="splide__track">
						<ul class="splide__list">

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

							echo '<li class="splide__slide logo-slide">';
								echo $link_open_tag;

								if (!empty($item_image)) {
									$image = wp_get_attachment_image($item_image, 'full', false, array('alt' => $alt_text));
									echo $image;
								} else {
									echo '<span class="logo-slide__title">' . esc_html($item_title) . '</span>';
								}

								echo $link_close_tag;
							echo '</li>';
						}

					?>
						</ul>

					</div>

				</div>
			</div>
			</div>
		</section>
<?php
		}
	}
?>