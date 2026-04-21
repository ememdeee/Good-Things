<?php
//===================================================================
//	Section Intro Text
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Intro Title';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// imageblob
$imageblob_image = get_field('imageblob_image') ?? false;
$imageblob_shape = get_field('imageblob_shape') ?? 'shape1';

// icon list
$icon_list = get_field('section_icon_list') ?? false; // array
$has_icon_list = isset($icon_list) && is_array($icon_list) && count($icon_list) > 0;

// Section color
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-intro_text';				// section block class name
$section_title['title_class']					= 'intro_text__title';			// section title wrapper class name
$section_button_row['section_buttons_class']	= 'intro_text__cta';			// section CTA wrapper class name

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && empty($section_description)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">

				<div class="section-heading">

					<?php if ($imageblob_image) { ?>
						<div class="section-heading__image">
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


					<div class="section-heading__title">
					<?php
						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							$section_title['title_no_mb'] = true; // true to remove bottom margin
							echo cd_title($section_title);
						}
					?>	
					</div>

					<?php if ($section_description || (isset($section_button_row) && is_array($section_button_row))) { ?>
					<div class="section-heading__description">
					<?php
						// Check if section_description exists
						if ($section_description) {
							echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
						}

						// Ensure section_button_row exists and is an array
						if (isset($section_button_row) && is_array($section_button_row)) {
							echo cd_button_row($section_button_row);
						}

					?>
					</div>

          <?php if ($has_icon_list) { ?>
            <div class="section-heading__icon-list">
              <ul class="nav-iconlist">
                <?php foreach ($icon_list as $item) : ?>
                  <?php 
                    // var_dump($item);
                    $item_title = $item['icon_list_title'] ?? '';	// string
                    $item_icon = $item['icon_list_icon'] ?? false;
                    $item_link = $item['icon_list_link'] ?? false;	// string

                    $wrapper_tag_open = '<div class="nav-iconlist__link">';
                    $wrapper_tag_close = '</div>';
                    if (!empty($item_link) && is_array($item_link)) {
                      $wrapper_tag_open = '<a href="' . esc_url($item_link['url']) . '" class="nav-iconlist__link" alt="' . esc_attr($item_link['title']) . '" target="' . esc_attr($item_link['target']) . '">';
                      $wrapper_tag_close = '</a>';
                    }
                  ?>
                  <li class="nav-iconlist__item">
                    <?php echo $wrapper_tag_open; ?>
                      <?php if ($item_icon) { ?>                        
												<span class="nav-iconlist__icon">
													<?php echo wp_get_attachment_image($item_icon, 'full'); ?>
												</span>
                      <?php } ?>
                      <?php echo cd_print_wrap_tags( $item_title,'<span class="nav-iconlist__text">','</span>' ); ?>
                    <?php echo $wrapper_tag_close; ?>
                  </li>

                <?php endforeach; ?>
              </ul>
            </div>
          <?php } ?>


				<?php } ?>
				</div>
			</div>
		</div>
	</section>
<?php } ?>