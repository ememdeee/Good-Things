<?php
//===================================================================
//	Testimonial Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Testimonial Slider';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');

// Get the ACF fields for content slider
$section_items		= get_field('section_items') ?? false;						// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;						// array
$section_autoplay	= get_field('section_autoplay') ?? false;					// boolean

$section_config['section_colour']		= get_field('section_colour') ?? '';	// string

// Define section element class names
$section_config['section_classname']	= 'cdb-testimonial_slider';				// section block class name

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
		
		// storing the testimonials
		$arrSchema = [];
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container">
				<div class="splide slider-container"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>
					
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
							foreach( $section_items as $item ) {

								// Get the ACF fields
								// Front end, set to false or empty by default
								$item_image			= $item['item_image'] ?? 0;				// integer
								$item_testimonial	= $item['item_testimonial'] ?? '';		// string
								$item_author		= $item['item_author'] ?? '';			// string
								$item_author_role	= $item['item_author_role'] ?? '';		// string
								$item_author_photo	= $item['item_author_photo'] ?? 0;		// integer

								$image 				= wp_get_attachment_image($item_image, 'large');
								$author_photo_url	= wp_get_attachment_image_url($item_author_photo, 'thumbnail');

								if (is_admin()) {
									// Set the default value on admin area only
									$item_author		= !empty($item_author) ? $item_author : 'Author';
								}

								echo '<div class="content-container splide__slide testimonial_slider__slide">';
									if (!empty($image)) {
										echo '<div class=" testimonial_slider__slide_image">';
										echo $image;
										echo '</div>';
									}

									echo '<div class=" testimonial_slider__slide_content">';

										// Check if item_testimonial exists
										if (!empty($item_testimonial)) {
											echo cd_print_richtext($item_testimonial, '<div class="testimonial_slider__slide_description">', '</div>');
										}
										echo '<div class=" testimonial_slider__slide_meta">';
											// Check if author photo exists
											if ($author_photo_url) {
												$alt_text = get_post_meta($item_author_photo, '_wp_attachment_image_alt', true);
												echo '<picture class="author_image">';
												echo '<img src="' . esc_url($author_photo_url) . '" alt="' . esc_attr($alt_text) . '" />';
												echo '</picture>';
											}
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

										// Add the review to the schema array
										$arrSchema[] = $review;
									}
								}

							}
						?>
						</div>
					</div>

				</div>
			</div>
			<?php
				// Only on the website, output the Review for testimonial schema if exists
				if (!is_admin() && !empty($arrSchema)) {
					echo '<script type="application/ld+json">';
					echo wp_json_encode([
						'@context' => 'https://schema.org',
						'@type' => 'CreativeWork',
						'name' => 'Customer Testimonials',
						'hasPart' => $arrSchema,
					], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
					echo '</script>';
				}
			?>
		</section>
<?php
		}
	}
?>