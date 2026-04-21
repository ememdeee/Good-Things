<?php
//===================================================================
//	Text & Image
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Text with Image';

// Get the ACF fields
// Front end, set to false or empty by default
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_image			= get_field('section_image') ?? false;			// array
$section_style 				= get_field('section_style') ?? 'boxed';	// string, default fw2 - fullwidth with large image
$section_variant_colour = get_field('section_variant_colour') ?? array('variant_colour' => 'default'); // array
$section_variant_colour = $section_variant_colour['variant_colour'] ?? 'default'; // string
$section_quote = get_field('section_quote') ?? false;			// array

$image_right = false;
$section_layout	= get_field('section_layout') ?? '0';			// string
if ($section_layout == '0') {
  $image_right = true;
}


// Get ACF fields for setting
$section_config = get_field('section_config') ?? false;
$section_config['section_colour'] = get_field('section_colour') ?? '';
$section_config['section_content_width'] = get_field('section_content_width') ?? '';
$section_config['section_content_position'] = get_field('section_content_position') ?? '';

$section_config['section_classname']			= 'cdb-text_image';								// section block class name
$section_title['title_class']					= 'text-image__title';							// section title wrapper class name
$section_button_row['section_buttons_class']	= 'text-image__cta';								// section CTA wrapper class name


$additional_classes = '';
if ($image_right) {
  $additional_classes .= ' cdb-text_image--image-right';
}

if ($section_quote) {
	$additional_classes .= ' cdb-text_image--with-quote';
}

$additional_classes .= ' sc-' . $section_variant_colour;
$additional_classes .= ' cdb-text_image--style-' . esc_attr($section_style);

if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && empty($section_description)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> <?php echo esc_attr($additional_classes); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container text-image__content-container">
				<?php
					if ($section_image) {
						echo '<div class="text-image__image">';
						echo wp_get_attachment_image($section_image, 'full');
						echo '</div>';
					}
				?>
				
				<div class="text-image__content list-checklist">
					<?php 
						if ($section_quote) {
							echo '<div class="text-image__quote">';
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="none"><path fill="#BCCF00" d="M31.25 43.75h14.063A4.693 4.693 0 0 0 50 39.062V25a4.693 4.693 0 0 0-4.688-4.688h-6.307l2.372-12.201a1.562 1.562 0 0 0-1.533-1.861h-5.062a3.136 3.136 0 0 0-2.978 2.176l-4.549 10.79a1.54 1.54 0 0 0-.065.189 17.163 17.163 0 0 0-.628 4.6v15.058a4.693 4.693 0 0 0 4.688 4.687ZM4.688 43.75H18.75a4.693 4.693 0 0 0 4.688-4.688V25a4.693 4.693 0 0 0-4.688-4.688h-6.308l2.373-12.201a1.56 1.56 0 0 0-1.534-1.86H8.218c-1.36-.001-2.566.888-2.977 2.176L.693 19.215a1.682 1.682 0 0 0-.066.19 17.177 17.177 0 0 0-.627 4.6v15.058a4.693 4.693 0 0 0 4.688 4.687Z"/></svg>';
							echo '</div>';
						}
					?>

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
