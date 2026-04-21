<?php
//===================================================================
//	Section Hero Animation
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_script('anime-script');

// Placeholder info
$placeholder_title	= 'Rich Text with Image Blob';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array
$section_description2 = get_field('section_description2') ?? '';		// string

$image_right = false;
$section_layout	= get_field('section_layout') ?? '1';			// string
if ($section_layout == '0') {
  $image_right = true;
}

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// Section color
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-richtext_image_blob';				// section block class name
$section_title['title_class']					= 'richtext-imageblob__title';			// section title wrapper class name
$section_button_row['section_buttons_class']	= 'richtext-imageblob__cta';			// section CTA wrapper class name

$imageblob_image = get_field('imageblob_image') ?? false;
$imageblob_shape = get_field('imageblob_shape') ?? 'shape1';

$icon_list = get_field('section_icon_list') ?? false; // array
$has_icon_list = isset($icon_list) && is_array($icon_list) && count($icon_list) > 0;

$icon_list_style = get_field('section_icon_list_style') ?? 'icon-list'; // string, default icon-list
/*
icon-list : Icon List – list with icons (default)
compact-list : Compact List – 2-col list with small icons
bulleted-list : Bulleted List – list with bullets, no icons
toggle-list : Toggle List – expandable list with icons
numbered-toggle : Numbered Toggle – expandable list with numbers
*/

$section_icon_variant_colour = get_field('section_icon_variant_colour') ?? array('variant_colour' => 'default'); // array
$icon_colour = $section_icon_variant_colour['variant_colour'] ?? 'default'; // string

$icon_colour_class = '';
if ($icon_colour /*&& $icon_colour !== 'default'*/) {
  $icon_colour_class .= ' sc-' . $icon_colour;
}


$additional_classes = '';
if ($image_right) {
  $additional_classes .= ' cdb-richtext_image_blob--image-right';
}

// // check if title is set, if not show the placeholder
// if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && empty($section_description)) {
// 	echo cd_cdb_placeholder($placeholder_title, $section_config);
// } else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

  // echo '<br />icon list style = ' . esc_html($icon_list_style);
  // echo '<br />icon list variant colour = ' . esc_html($icon_colour);

	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> <?php echo esc_attr($additional_classes); ?> cdb-richtext_image_blob--list-<?php echo esc_attr($icon_list_style); ?>" <?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container richtext-imageblob__content-container">

        <?php if ($imageblob_image) { ?>

          <div class="richtext-imageblob__image">
            <?php 
              // var_dump($imageblob_image);
              // var_dump($imageblob_shape);
              echo cd_display_image_blob(array(
                'imageblob_image' => $imageblob_image,
                'imageblob_shape' => $imageblob_shape,
              ));
            ?>
          </div>


        <?php } ?>


				<div class="richtext-imageblob__content">
					<?php
						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							echo cd_title($section_title);
						}
					?>	

          <?php 
						if ($section_description) {
							echo cd_print_richtext( $section_description,'<div class="content__description content__description--top">','</div>' );
						}          
          ?>

          <?php if ($has_icon_list) { ?>

            <?php if ($icon_list_style == 'toggle-list' || $icon_list_style == 'numbered-toggle') { ?>
              <div class="richtext-imageblob__toggle-list">
              <?php


                  $theme_uri = get_template_directory_uri();
                  wp_enqueue_script(
                      'featured-faq-js',
                      $theme_uri . '/blocks/featured-faq/js/featured-faq.min.js',
                      array(), // dependencies
                      filemtime(get_template_directory() . '/blocks/featured-faq/js/featured-faq.min.js'),
                      true // in footer
                  );
                  wp_enqueue_style(
                      'featured-faq-css',
                      $theme_uri . '/blocks/featured-faq/css/featured-faq.css',
                      array(), // dependencies
                      filemtime(get_template_directory() . '/blocks/featured-faq/css/featured-faq.css')
                  );                
                
                  $section_items_faqs = array_map(function($item) {
                  return array(
                    'item_anchor_id' => $item['icon_list_anchor_id'] ?? '',
                    'item_question' => $item['icon_list_title'] ?? '',
                    'item_question_tag' => 'h3',
                    'item_question_size' => 'h5',
                    'item_answer' => $item['icon_list_description'] ?? '',
                    'item_icon' => $item['icon_list_icon'] ?? false,
                    'item_link' => $item['icon_list_link'] ?? '',
                  );
                  }, $icon_list ?? []);

                  // var_dump($section_items_faqs);

                  $numbered = false;
                  if ($icon_list_style == 'numbered-toggle') {
                    $numbered = true;
                  }

                  featured_faq_list($section_items_faqs, 'simpleplus', false, $numbered, $icon_colour_class);
              ?>
              </div>
            <?php } else { ?>
              <?php 
                $download_list = false;
                if ($icon_list_style == 'download-list') {
                  $download_list = true;
                }
              ?>
              <div class="richtext-imageblob__icon-list">
                <ul class="featured-iconlist featured-iconlist--style-<?php echo esc_attr($icon_list_style); ?>">
                  <?php foreach ($icon_list as $item) : ?>
                    <?php 
                      // var_dump($item);
                      $item_title = $item['icon_list_title'] ?? '';	// string
                      $item_description = $item['icon_list_description'] ?? '';	// string
                      $item_icon = $item['icon_list_icon'] ?? false;
                      // $item_style = $item['icon_list_style'] ?? 'shape1';	// string
                      $item_link = $item['icon_list_link'] ?? false;	// string

                      $wrapper_tag_open = '<div class="featured-iconlist__link">';
                      $wrapper_tag_close = '</div>';
                      if (!empty($item_link)) {
                        $wrapper_tag_open = '<a href="' . esc_url($item_link) . '" class="featured-iconlist__link" '. ($download_list ? 'target="_blank"' : '') .'>';
                        $wrapper_tag_close = '</a>';
                      }
                    ?>
                    <li class="featured-iconlist__item">
                      <?php echo $wrapper_tag_open; ?>


                      <div class="featured-iconlist__icon <?php echo esc_attr($icon_colour_class); ?>">
                        <?php if ($item_icon) { 
                          echo wp_get_attachment_image($item_icon, 'full');
                        } ?>
                      </div>


                      <div class="featured-iconlist__text">
                        <?php echo cd_print_wrap_tags( $item_title,'<h6 class="featured-iconlist__title">','</h6>' ); ?>

                        <?php echo cd_print_wrap_tags( $item_description,'<div class="featured-iconlist__description">','</div>' ); ?>                      
                      </div>
                      <?php echo $wrapper_tag_close; ?>
                    </li>

                  <?php endforeach; ?>
                </ul>
              </div>
            <?php } ?>

          <?php } ?>
					<?php if ($section_description2 || (isset($section_button_row) && is_array($section_button_row))) { ?>
					<?php
						// Check if section_description exists
						if ($section_description2) {
							echo cd_print_richtext( $section_description2,'<div class="content__description content__description--bottom">','</div>' );
						}          

						// Ensure section_button_row exists and is an array
						if (isset($section_button_row) && is_array($section_button_row)) {
							echo cd_button_row($section_button_row);
						}

					?>
					<?php } ?>
				</div>





			</div>



		</div>


    <?php 
    // svg clippath reference    
    ?>
    



	</section>
<?php // } ?>