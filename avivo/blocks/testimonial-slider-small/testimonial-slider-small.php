<?php
//===================================================================
//	Testimonial Slider (small) Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Testimonial Slider (small grid)';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');

// Get the ACF fields for content slider
$section_title			= get_field('section_title') ?? false;					// array
$section_description	= get_field('section_description') ?? '';				// string
$section_items			= get_field('section_items') ?? false;					// array
$section_button_row = get_field('section_button_row') ?? false;					// array
$section_randomize = get_field('section_randomize') ?? false;				// boolean
$variant_colour = get_field('variant_colour_variant_colour') ?? 'default';	// string

// var_dump($variant_colour);

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;					// array
$section_autoplay		= get_field('section_autoplay') ?? false;				// boolean

$section_config['section_colour']		= get_field('section_colour') ?? '';	// string
$section_button_row['section_buttons_class']	= 'case-study-slider__cta';			// section CTA wrapper class name

// Define section element class names
$section_config['section_classname']	= 'cdb-testimonial_slider_sm';			// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the slider has any slide, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	
	// storing the testimonials
	$arrSchema = [];

	$card_classes = '';
	if ($variant_colour && $variant_colour !== 'default') {
		$card_classes .= ' sc-' . $variant_colour;
	}

?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">
				<div class="testimonial_slider_sm__heading">
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

					echo '<div class="section-heading__description section-heading__description--button-only">';
					// Ensure section_button_row exists and is an array
					if (isset($section_button_row) && is_array($section_button_row)) {
						echo cd_button_row($section_button_row);
					}
					echo '</div>';

				?>
				</div>
				<?php
				// check if the slider has any slide
				if ($has_items) {

					/*
					display conditions url can be multiple values, separated by commas, e.g.
					/aged-care/,/veterans-service/
					/aged-care/, /veterans-service/, /disability-support/
					/aged-care/ (single value still works)					
					*/
					// for those section_items that has display_condition_url set, filter them out if current url doesn't match
					$section_items = array_filter($section_items, function($item) {
						$display_condition_url = $item['display_condition_url'] ?? '';
						if (!empty($display_condition_url)) {
							// Check if the current URL matches any of the display condition URLs
							$current_url = $_SERVER['REQUEST_URI'];
							
							// Split by comma and trim whitespace
							$condition_urls = array_map('trim', explode(',', $display_condition_url));
							
							// Check if current URL contains any of the condition URLs
							foreach ($condition_urls as $condition_url) {
								if (!empty($condition_url) && strpos($current_url, $condition_url) !== false) {
									return true;
								}
							}
							return false;
						}
						// If no display condition URL is set, include the item
						return true;
					});

					// Get Random Items
					$numToPick = min(count($section_items), 5);				// Determine how many items to pick (minimum of array size or 5)
					$randomKeys = array_rand($section_items, $numToPick);	// Get random keys
				
					// Ensure the result is always an array (for single-item arrays, array_rand returns a single key)
					if (!is_array($randomKeys)) {
						$randomKeys = [$randomKeys];
					}
				
					// Extract the random items
					$randomItems = array_map(fn($key) => $section_items[$key], $randomKeys);		

					// randomize the order
					if ($section_randomize) {
						shuffle($randomItems);
					}
				?>
				<div class="testimonial_slider_sm__slider splide slider-container"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?> data-count="<?php echo count($section_items); ?>">
					
					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<button class="splide__arrow splide__arrow--prev"></button>
							<button class="splide__arrow splide__arrow--next"></button>
						</div>
					</div>

					<div class="splide__track">
						<div class="splide__list">
						<?php
							// Loop through all the slides
							foreach( $randomItems as $item ) {

								// Get the ACF fields
								// Front end, set to false or empty by default
								$item_testimonial	= $item['item_testimonial'] ?? '';		// string
								$item_rating		= $item['item_rating'] ?? '';			// string
								$item_author		= $item['item_author'] ?? '';			// string
								$item_author_role	= $item['item_author_role'] ?? '';		// string
								$item_author_photo	= $item['item_author_photo'] ?? 0;		// integer
								$item_image			= $item['item_image'] ?? 0;				// integer
								$display_condition_url = $item['display_condition_url'] ?? '';	// string

								$logo				= wp_get_attachment_image($item_image, 'medium');
								$author_photo_url	= wp_get_attachment_image_url($item_author_photo, 'thumbnail');

								if (is_admin()) {
									// Set the default value on admin area only
									$item_author		= !empty($item_author) ? $item_author : 'Author';
								}

								echo '<div class="splide__slide testimonial_slider_sm__slide">';
									echo '<div class="testimonial_slider_sm__slide_content ' . esc_attr($card_classes) . '">';

										// Check if item_testimonial exists
										if (!empty($item_testimonial)) {
											echo cd_print_richtext($item_testimonial, '<div class="testimonial_slider_sm__slide_description h3">', '</div>');
										}
										
										// Check if item_rating exists
										if (!empty($item_rating)) {
											echo cd_getStarRating($item_rating);
										}

										echo '<div class=" testimonial_slider_sm__slide_meta">';
											// Check if author photo exists
											if ($author_photo_url) {
												$alt_text = get_post_meta($item_author_photo, '_wp_attachment_image_alt', true);
												echo '<picture class="author_image">';
												echo '<img src="' . esc_url($author_photo_url) . '" alt="' . esc_attr($alt_text) . '" />';
												echo '</picture>';
											} else {
												// default icon
												?>
												<picture class="author_image author_image--default">
													<img src="<?php echo get_template_directory_uri() . '/img/svg/ic-testimonial-squiggle.svg'; ?>" />
												</picture>
												<?php
											}

											// // Check if logo exists
											// if ($item_image) {
											// 	$alt_text = get_post_meta($item_image, '_wp_attachment_image_alt', true);
											// 	echo '<div class="logo">';
											// 	echo $logo;
											// 	echo '</div>';
											// }

											// Check if author exists
											if ($item_author) {
												echo '<div class="author_info">';
													echo '<div class="author">';
													echo $item_author;
													echo '</div>';
													
													if ($item_author_role) {
														echo '<div class="author_role">';
														echo $item_author_role;
														echo '</div>';
													}
												echo '</div>';
											}


										echo '</div>';

									echo '</div>';
								echo '</div>';

								// Only on the website
								if (!is_admin()) {
									// Review for testimonial schema
									if (!empty($item_testimonial)) {
										$authorDetails = [];

										// Add author details if available
										if (!empty($item_author)) {
											$authorDetails['name'] = $item_author;
										}

										if (!empty($item_author_role)) {
											$authorDetails['jobTitle'] = $item_author_role;
										}

										if (!empty($author_photo_url)) {
											$authorDetails['image'] = [
												'@type' => 'ImageObject',
												'url' => esc_url($author_photo_url),
											];
										}

										// Build the review structure
										$review = [
											'@type' => 'Review',
											'itemReviewed' => array(
												'@type' => 'Organization', 
												'name' => 'Avivo'
											),
											'reviewBody' => wp_kses_post($item_testimonial),
										];

										// Include author details if available
										if (!empty($authorDetails)) {
											$review['author'] = array_merge(['@type' => 'Person'], $authorDetails);
										}
										
										// Add Review Rating if available
										if (!empty($item_rating)) {
											$ratingValue = floatval($item_rating); // Ensure it's a number
											if ($ratingValue >= 0 && $ratingValue <= 5) { // Check if rating is within the valid range
												$review['reviewRating'] = [
													'@type' => 'Rating',
													'ratingValue' => $ratingValue,
													"bestRating" => 5,
													"worstRating" => 0
												];
											}
										}

										// Add the review to the schema array
										$arrSchema[] = $review;
									}
								}
							}

						?>
						</div>
					</div>

				</div>
				<?php } ?>
			</div>
		</div>
		<?php
			// Only on the website, output the Review for testimonial schema if exists
			if (!is_admin() && !empty($arrSchema)) {
				echo '<script type="application/ld+json">';

				$jsonld = [
					'@context' => 'https://schema.org',
					'@type' => 'LocalBusiness',
					'name' => 'Customer Testimonials',
					'hasPart' => $arrSchema,
				];
				if ($section_title && isset($section_title['title_text'])) {
					$jsonld['description'] = $section_title['title_text'];
				}

				echo wp_json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
				echo '</script>';
			}
		?>
	</section>
<?php } ?>