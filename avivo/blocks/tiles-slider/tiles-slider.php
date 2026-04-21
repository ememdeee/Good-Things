<?php
//===================================================================
//	Tiles Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Tiles Slider';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');

$section_title			= get_field('section_title') ?? false;					// array
$section_description	= get_field('section_description') ?? false;				// string
$section_tiles			= get_field('section_tiles') ?? false;					

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;					// array
$section_autoplay		= get_field('section_autoplay') ?? false;				// boolean

$section_config['section_colour']	= get_field('section_colour') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-tiles_slider';		// section block class name
$section_title['title_class']				  	= 'tiles-slider__title';	// section title wrapper
$max_slides = 6;

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']])) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> cdb-tiles_slider--style-numbered"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container tiles-slider">
			<div class="tiles-slider__heading section-heading">
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

				?>
				</div>
				<?php if ($section_tiles && count($section_tiles) > 0) : ?>
				<div class="tiles-slider__slider splide"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>

					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<button class="splide__arrow splide__arrow--prev"></button>
							<button class="splide__arrow splide__arrow--next"></button>
						</div>
					</div>

					<div class="splide__track">
						<ul class="splide__list">
							<?php
								$i = 0;

								foreach( $section_tiles as $tile ) {
									$tile_title = $tile['tile_title'] ?? '';
									$tile_description = $tile['tile_description'] ?? '';
									$tile_link = $tile['tile_link'] ?? '';			
									$tile_link_text = $tile['tile_link_title'] ?? '';			
									$tile_variant_colour = $tile['tile_variant_colour_variant_colour'] ?? 'default'; // string

									$link_open_tag = '';
									$link_close_tag = '';

									$i++;

									$colour_class = '';
									// if ($item_variant_colour && $item_variant_colour !== 'default') {
										$colour_class .= ' sc-' . $tile_variant_colour;
									// }
									
									if (!empty($tile_link)) {
										$tile_title = !empty($tile_title) ? $tile_title : $alt_text;
										// $link_open_tag = '<a href="' . esc_url($tile_link) . '"' . (!empty($tile_title) ? ' title="' . esc_attr($tile_title) . '"' : '') . ' class="tile-slide__link">';
										// $link_close_tag = '</a>';
									}
									

									echo '<li class="splide__slide tile-slide '. $colour_class .'">';
									//var_dump($tile_variant_colour);
									?>

									<?php echo $link_open_tag; ?>
										<div class="tile-slide__content">
											<?php
												echo '<div class="tile-slide__number sc-jade">';
												echo str_pad($i, 2, '0', STR_PAD_LEFT);
												echo '</div>';


												echo cd_print_wrap_tags(
													$tile_title ?? '',
													'<div class="tile-slide__title h4">',
													'</div>'
												);
												
												// Check if item_description exists
												if (!empty($tile_description)) {								
													echo cd_print_richtext($tile_description, '<div class="tile-slide__tile_description">', '</div>');
												}
												
												// Check if item_link exists
												if (!empty($tile_link)) {
													$tile_link_text = empty($tile_link_text) ? 'read more' : $tile_link_text;

													// echo '<div class="featured_tiles__tile_link_wrapper">';
													// echo '<a href="' . esc_url($tile_link) . '" class="featured_tiles__tile_link"><span class="link-text">' . esc_html($tile_link_text) . '</span></a>';
													// echo '</div>';

													$button_class = 't-tagline';
													// if ($tile_color && $tile_color === 'dark') {
													// 	$button_class = 'light';
													// }

													echo '<div class="tile-slide__tile-button">';
													echo cd_button(array(
														'text'		=> $tile_link_text,
														'link'		=> $tile_link,
														'style'		=> $button_class . '',
														'size'		=> '',
														// 'icon'		=> 'r-arrow',
													));
													echo '</div>';

												}
												
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