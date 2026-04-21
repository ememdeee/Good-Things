<?php
//===================================================================
//	Post Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Enqueue script and style for the slider
wp_enqueue_script('splide-slider-script');
wp_enqueue_style('splide-slider-style');

$section_title = get_field('section_title') ??  false;							// array
$section_description = get_field('section_description') ?? '';					// string
$section_button_row = get_field('section_button_row') ?? false;					// array
$section_categories_filter = get_field('section_categories_filter') ?? false;
$section_slider_style = get_field('section_slider_style') ?? 'regular';


	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array

	$section_config['section_colour']	= get_field('section_colour') ?? '';		// string
	
	// Define section element class names
	$section_config['section_classname']			= 'cdb-post_slider';			// section block class name
	$section_title['title_class']					= 'post-slider__title';			// section title wrapper
	$section_button_row['section_buttons_class']	= 'post-slider__cta';			// section CTA wrapper class name
	$max_slides = 4;

	// Default values
	$default_title = array(
		'title_text'	=> 'Page Title',
		'title_tag'		=> 'h1',
	);

	if (is_admin()) {
		// Set the default value on admin area only
		$section_title = (!empty($section_title) && !empty($section_title['title_text'])) ? $section_title : $default_title;
	}

  // Output user-defined custom CSS
  echo cd_section_user_custom_css($section_config);
?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> data-slider-style="<?php echo $section_slider_style; ?>" >
	<div class="container section-container" data-aos="fade-up">
		<div class="content-container post-slider">
      <div class="post-slider__heading section-heading section-heading--style-2col">
      <?php 
        // echo '<pre>';
        // var_dump($section_title);
        // var_dump($section_description);
        // var_dump($section_categories_filter);
        // echo '</pre>';

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
			<div class="post-slider__posts splide">

        
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
                'post_type' => 'post',
                'posts_per_page' => $max_slides,//-1,
                'post_status' => 'publish',
              );

              if (is_array($section_categories_filter) && !empty($section_categories_filter)) {
                $args['category__in'] = $section_categories_filter;
              }

              $posts = new WP_Query($args);
              if ($posts->have_posts()) {
                while ($posts->have_posts()) {
                  echo '<li class="splide__slide post-slide">';
                  $posts->the_post();
                  get_template_part( 'loop-templates/content', get_post_format() );
                  ?>
                  <?php
                  echo '</li>';
                }
              } else {
                echo '<p>No posts found.</p>';
              }

              $posts_count = $posts->post_count;

              wp_reset_postdata();
            ?>


          </ul>
        </div>        
			</div>

      <?php 
        // hide section if in blog article and post < 3
        if ($posts_count < 3 && is_single()) {
          echo '<style>#single-wrapper .cdb-post_slider {display: none;}</style>';
        }
      ?>

		</div>
	</div>
</section>
