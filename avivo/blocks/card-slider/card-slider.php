<?php
//===================================================================
//	Card Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Card Slider';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');

$section_title			= get_field('section_title') ?? false;					// array
$section_description	= get_field('section_description') ?? false;				// string
$section_cards			= get_field('section_cards') ?? false;					
$section_button_row = get_field('section_button_row') ?? false;					// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;					// array
$section_autoplay		= get_field('section_autoplay') ?? false;				// boolean

$section_config['section_colour']	= get_field('section_colour') ?? '';		// string
$section_button_row['section_buttons_class']	= 'case-study-slider__cta';			// section CTA wrapper class name

// Define section element class names
$section_config['section_classname']			= 'cdb-card_slider';		// section block class name
$section_title['title_class']				  	= 'card-slider__title';	// section title wrapper
$max_slides = 6;

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container card-slider">
				<div class="card-slider__heading section-heading section-heading--style-2col">
				<?php
					
					echo '<div class="section-heading__title">';
					// Check if section_title exists and is not empty
					if (isset($section_title) && is_array($section_title)) {
						echo cd_title($section_title);
					}

					// Check if section_description exists
					if ($section_description) {
						echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
					}

					echo '</div>';


					// Ensure section_button_row exists and is an array
					if (isset($section_button_row) && is_array($section_button_row) && $section_button_row['section_buttons']) {
						echo '<div class="section-heading__description section-heading__description--button-only">';
						echo cd_button_row($section_button_row);
						echo '</div>';
					}
				?>
				</div>
				<?php if ($section_cards && count($section_cards) > 0) : ?>
				<div class="card-slider__slider splide"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>

					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<button class="splide__arrow splide__arrow--prev"></button>
							<button class="splide__arrow splide__arrow--next"></button>
						</div>
					</div>

					<div class="splide__track">
						<ul class="splide__list">
							<?php

								foreach( $section_cards as $card ) {
									$card_title = $card['card_title'] ?? '';
									$card_image = $card['card_image'] ?? false;
									$card_link = $card['card_link'] ?? '';			

									$link_open_tag = '';
									$link_close_tag = '';

									if (!empty($card_link)) {
										$card_title = !empty($card_title) ? $card_title : $alt_text;
										$link_open_tag = '<a href="' . esc_url($card_link) . '"' . (!empty($card_title) ? ' title="' . esc_attr($card_title) . '"' : '') . ' class="card-slide__link">';
										$link_close_tag = '</a>';
									}
									

									echo '<li class="splide__slide card-slide">';
									?>

									<?php echo $link_open_tag; ?>
										<div class="card-slide__image">
											<?php
												if ($card_image) {
													echo wp_get_attachment_image($card_image, 'full');
												}
											?>
										</div>

										<div class="card-slide__content">
											<?php
												echo cd_print_wrap_tags(
													$card_title ?? '',
													'<div class="card-slide__title">',
													'</div>'
												);
											?>
										</div>
									<?php echo $link_close_tag; ?>

									<?php
									echo '</li>';
								}
							?>
						</ul>

					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php } ?>