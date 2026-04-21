<?php
//===================================================================
//	Quick Links Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Quick Links';

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// icon list
$icon_list = get_field('section_icon_list') ?? false; // array
$has_icon_list = isset($icon_list) && is_array($icon_list) && count($icon_list) > 0;

// Section color
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-quick_links';				// section block class name

// check if title is set, if not show the placeholder
if (is_admin() && !$has_icon_list) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">

				<div class="section-heading">
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
				</div>
			</div>
		</div>
	</section>
<?php } ?>