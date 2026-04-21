<?php
//===================================================================
//	Case Study Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Case Study Slider';

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');

$section_title			= get_field('section_title') ?? false;					// array
$section_description	= get_field('section_description') ?? '';				// string
$section_display_by		= get_field('section_display_by') ?? '0';				// string '0', '1'
$section_items			= get_field('section_items') ?? false;					// array, case study ids
$section_categories		= get_field('section_categories') ?? false;				// array
$section_button_row = get_field('section_button_row') ?? false;					// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;					// array
$section_autoplay		= get_field('section_autoplay') ?? false;				// boolean

$section_config['section_colour']	= get_field('section_colour') ?? '';		// string
$section_button_row['section_buttons_class']	= 'case-study-slider__cta';			// section CTA wrapper class name

// Define section element class names
$section_config['section_classname']			= 'cdb-case_study_slider';		// section block class name
$section_title['title_class']				  	= 'case-study-slider__title';	// section title wrapper
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
			<div class="content-container case-study-slider">
				<div class="case-study-slider__heading section-heading section-heading--style-2col">
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
				<div class="case-study-slider__slider splide"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>

					<div class="splide__arrows cdb-slider__arrows">
						<div class="container splide__arrows_container">
							<button class="splide__arrow splide__arrow--prev"></button>
							<button class="splide__arrow splide__arrow--next"></button>
						</div>
					</div>

					<div class="splide__track">
						<ul class="splide__list">
							<?php

							$args = array(
								'post_type'			=> 'case-study',
								'post_status'		=> 'publish',
								'posts_per_page'	=> $max_slides,	//-1
								'orderby'			=> 'menu_order',
								'order'				=> 'ASC',
							);

							if ($section_display_by === '0') {
								// by selected case studies
								if (isset($section_items) && is_array($section_items) && !empty($section_items)) {
									$args['post__in']		= $section_items;
									$args['orderby']		= 'post__in'; // Maintain the order of selected posts
									$args['posts_per_page']	= -1;
								}
							} else {
								// by Category
								if (isset($section_categories) && is_array($section_categories) && !empty($section_categories)) {
									$args['tax_query'] = array(
										array(
											'taxonomy'	=> 'case-study-category',
											'field'		=> 'term_id',
											'terms'		=> $section_categories,
										),
									);
								}
							}

							$posts = new WP_Query($args);
							if ($posts->have_posts()) {
								while ($posts->have_posts()) {
									$posts->the_post();
									$post_id = get_the_ID();

									$case_study_client      = get_field('case_study_client', $post_id) ?? '';
									$case_study_logo        = get_field('case_study_logo', $post_id) ?? false;
									$case_study_cover_image = get_field('case_study_cover_image', $post_id) ?? false;
									$case_study_logo_white  = get_field('case_study_logo_white', $post_id) ?? false;

									echo '<li class="splide__slide case-study-slide">';
									?>

									<a <?php post_class('case-study__link'); ?> id="case-study-<?php the_ID(); ?>" href="<?php echo esc_url( get_permalink() ); ?>">
										<div class="case-study-slide__image">
											<?php 
												if ($case_study_cover_image) {
													echo wp_get_attachment_image($case_study_cover_image, 'full');
												} else if (has_post_thumbnail()) {
													echo get_the_post_thumbnail( $post_id, 'full', array(  ) ); 
												}
											?>
										</div>

										<div class="case-study-slide__content">
											<?php /*
											<div class="case-study-slide__logo">
												<?php
													if ($case_study_logo_white) {
														echo wp_get_attachment_image($case_study_logo_white, 'full', false, array('class' => 'logo-white'));
													} else {
														echo wp_get_attachment_image($case_study_logo, 'full', false, array('class' => 'logo-original'));
													}
												?>
											</div>
											<div class="case-study-slide__client">
												<?php echo $case_study_client; ?>
											</div>
											*/ ?>

											<?php
												the_title(
													'<h3 class="case-study-slide__title h4">',
													'</h3>'
												);
											?>

											<?php 
												$case_study_terms = get_the_terms(get_the_ID(), 'case-study-category');
												$case_study_categories = !empty($case_study_terms) ? reset(wp_list_pluck($case_study_terms, 'name')) : '';
												if (!empty($case_study_categories)) {
													echo '<div class="case-study-slide__categories">';
													echo '<span>';
													echo esc_html($case_study_categories);
													echo '</span>';
													echo '</div>';
												}											
											?>

											<?php 
											/*
												if (has_excerpt($post_id)) {
													// the_excerpt(); 
													$excerpt = text_max_charlength(wp_filter_nohtml_kses(get_the_excerpt()),150);
													echo '<div class="case-study-slide__excerpt">';
													echo '<p>'.$excerpt.'</p>';
													echo '</div>';
												}
											*/
											?>
											
										</div>

										<div class="case-study-slide__overlay">
											<?php
												if ($case_study_logo_white) {
													echo wp_get_attachment_image($case_study_logo_white, 'full', false, array('class' => 'logo-white'));
												} else {
													echo wp_get_attachment_image($case_study_logo, 'full', false, array('class' => 'logo-original'));
												}
											?>
										</div>
									</a>

									<?php
									echo '</li>';
								}
							} else {
								echo '<p>No case studies found.</p>';
							}

							wp_reset_postdata();
							?>
						</ul>

					</div>
				</div>
			</div>
		</div>
	</section>
<?php } ?>