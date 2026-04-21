<?php
//===================================================================
//	Section Article Spotlight
//	Custom Section Block using ACF
//===================================================================

defined( 'ABSPATH' ) || exit;

$placeholder_title = 'Article Spotlight Title';

// Get the ACF fields
$section_title = get_field('section_title') ?? false;
$section_description = get_field('section_description') ?? '';
$section_button_row = get_field('section_button_row') ?? false;

$section_image = get_field('section_image') ?? '';
$section_image_shape = get_field('section_image_shape') ?? 'shape6';
$section_variant_colour = get_field('section_variant_colour') ?? array('variant_colour' => 'default'); // array
$section_variant_colour = $section_variant_colour['variant_colour'] ?? 'default'; // string
$section_curve_style = get_field('section_curve_style') ?? 'curve1';

$section_config = get_field('section_config') ?? false;
$section_config['section_colour'] = get_field('section_colour') ?? '';
$section_config['section_content_width'] = get_field('section_content_width') ?? '';
$section_config['section_content_position'] = get_field('section_content_position') ?? '';

$section_config['section_classname'] = 'cdb-article_spotlight';
$section_title['title_class'] = 'article_spotlight__title';
$section_button_row['section_buttons_class'] = 'article_spotlight__cta';

$additional_classes = '';
$additional_classes .= ' sc-' . $section_variant_colour;
$additional_classes .= ' cdb-article_spotlight--style-' . esc_attr($section_curve_style);

if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && empty($section_description)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> <?php echo esc_attr($additional_classes); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">

			<?php
			$curve_img = '';
			if ($section_curve_style == 'curve1') {
					$curve_img .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/article-spotlight-curve1.svg" class="article-spotlight__curve">';				
				} else if ($section_curve_style == 'curve2') {
					$curve_img .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/article-spotlight-curve2.svg" class="article-spotlight__curve">';	

				}

				if ($curve_img) {
					echo $curve_img;
				}
			?>

			<div class="content-container article-spotlight__content-container">
        <?php if ($section_image) : ?>
        <div class="article-spotlight__image">
            <?php 
              $imageblob_image = $section_image;
              $imageblob_shape = $section_image_shape;
              // var_dump($imageblob_image);
              // var_dump($imageblob_shape);
              echo cd_display_image_blob(array(
                'imageblob_image' => $imageblob_image,
                'imageblob_shape' => $imageblob_shape,
              ));
            ?>
        </div>
        <?php endif; ?>
				<div class="article-spotlight__content">
					<?php
						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							echo cd_title($section_title);
						}
					?>	
					<?php if ($section_description || (isset($section_button_row) && is_array($section_button_row))) { ?>
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
					<?php } ?>

				</div>
			</div>
		</div>
	</section>
<?php } ?>
