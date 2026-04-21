<?php
//===================================================================
//	Featured Links Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Featured Links';

// Get the ACF fields
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_links			= get_field('section_links') ?? false;			// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;			// array
$section_column			= get_field('section_column') ?? '5';			// string, default 5 columns

$section_config['section_colour']				= get_field('section_colour') ?? '';					// string

// Define section element class names
$section_config['section_classname']			= 'cdb-featured_links';		// section block class name

// Check if section_links has item
$has_items = isset($section_links) && is_array($section_links) && count($section_links)>0;

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

	$link_content = '';
	$link_images = '';
	if ($has_items) {
		$link_content .= '<ul class="featured-links__links">';
		$link_images .= '<ul>';
		$i = 0;

		// Loop through all the links
		foreach( $section_links as $link ) {

			// Get the ACF fields
			// Front end, set to false or empty by default
			$link_image			= $link['link_image'] ?? 0;				// integer
			$link_title			= $link['link_title'] ?? '';			// string
			$link_link			= $link['link_link'] ?? '';				// string

			// check the link
			$link_open_tag = '';
			$link_close_tag = '';
			
			if (!empty($link_link)) {
				$link_open_tag = '<a href="' . esc_url($link_link) . '"' . (!empty($link_title) ? ' title="' . esc_attr($link_title) . '"' : '') . ' class="featured-link__link">';
				$link_close_tag = '</a>';
			}

			$link_content .= '<li class="featured-link" data-index="' . esc_attr($i) . '">';
			$link_content .= $link_open_tag;
			$link_content .= '<div class="featured-link__title">';
			$link_content .= 	esc_html($link_title);
			$link_content .= '</div>';
			$link_content .= $link_close_tag;
			$link_content .= '</li>';

			$link_images .= '<li class="featured-link__image" data-index="' . esc_attr($i) . '">';
			if (!empty($link_image)) {
				$link_images .= wp_get_attachment_image($link_image, 'full', false, array('alt' => esc_attr($link_title)));
			}
			$link_images .= '</li>';
			$i++;
		}
		
		$link_content .= '</ul>';
		$link_images .= '</ul>';

	}
?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">
				
				<div class="content-wrapper">
					<?php

						// Check if section_title exists and is not empty
						if (isset($section_title) && is_array($section_title)) {
							echo cd_title($section_title);
						}
								
						// Check if section_description exists
						if ($section_description) {
							echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
						}
						?>
						<div class="featured-links__links-wrapper">
							<?php
								echo $link_content;
							?>
						</div>

						<?php

						// Ensure section_button_row exists and is an array
						if (isset($section_button_row) && is_array($section_button_row)) {
							echo cd_button_row($section_button_row);
						}

					?>

				</div>

				<div class="featured-links__images-wrapper">
					<?php
						if ($has_items) {
							echo $link_images;
						}
					?>
				</div>
			</div>
		</div>
	</section>
<?php } ?>