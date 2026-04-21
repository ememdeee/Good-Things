<?php
//===================================================================
//	Section Hero Animation
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_script('anime-script');

// Placeholder info
$placeholder_title	= 'Hero Animation Title';

// Get the ACF fields
// Front end, set to false or empty by default
$section_breadcrumbs = get_field('section_breadcrumbs') ?? false;	// boolean
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array

$section_curve_image = get_field('section_curve_image') ?? false;	// array
$section_curve_style = get_field('section_curve_style') ?? 'curve1'; // string, default curve-1
$section_curve_size = get_field('section_curve_size') ?? 'default'; // string, default medium

// icon list
$icon_list = get_field('section_icon_list') ?? false; // array
$has_icon_list = isset($icon_list) && is_array($icon_list) && count($icon_list) > 0;

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// Section color
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-hero_animation';				// section block class name
$section_title['title_class']					= 'hero_animation__title';			// section title wrapper class name
$section_button_row['section_buttons_class']	= 'hero_animation__cta';			// section CTA wrapper class name

// check if title is set, if not show the placeholder
if (is_admin() && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && empty($section_description)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?> cdb-hero_animation--curve-style-<?php echo esc_attr($section_curve_style); ?> cdb-hero_animation--curve-size-<?php echo esc_attr($section_curve_size); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container hero-animation__content-container">
				<div class="hero-animation__content">
					<?php

						// Breadcrumbs
						if ($section_breadcrumbs) {
							// Check if the Yoast Breadcrumbs function exists
						//	if (function_exists('yoast_breadcrumb')) {
						//		yoast_breadcrumb('<div class="breadcrumbs-container">', '</div>');
						//	}
						
							// Check if the Breadcrumbs function exists
							if (function_exists('cd_breadcrumbs')) {
								echo '<div class="breadcrumbs-container">';
								cd_breadcrumbs();
								echo '</div>';
							}
						}


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

					<?php if ($has_icon_list) { ?>
						<div class="hero-animation__icon-list">
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


			<?php if ($section_curve_image) { ?>

				<?php 
					$curve_svg = '<svg class="animated-svg">
<path class="base-path-template" d="M908.5 122C817.5 60.5 572.71 -66.1379 503 46.5C408.5 170 627.5 450.5 390 450.5C164.911 450.5 412 31.0001 143.496 3.5003C16.1625 -9.54103 -97.0041 204 133.997 475.5" fill="none" stroke-linejoin="round" stroke-linecap="round" />
</svg>';

					$curve_image = wp_get_attachment_image_url($section_curve_image, 'full');
					$stroke_width = 160; //158; // Default stroke width
					$stroke_color = 'var(--theme-color-primary)'; // Default stroke color
					$animation_duration = 2000; // Default animation duration
					$fade_duration = 1000; // Default fade duration
					$fade_offset = -500; // Default fade offset
					$aspect_ratio = '906/465';
					$padding_factor = 0.5; // Default padding factor

					if ($section_curve_style === 'curve1') {
						// $curve_svg = '<svg class="animated-svg"><path class="base-path-template" d="M168.334 459.816C34.5777 280.409 42.5384 100.144 160.318 72.0853C222.153 57.354 295.381 121.395 280.585 241.283C272.502 306.779 296.54 386.067 376.338 386.067C434.68 386.067 509.166 299.99 439.79 187.211C405.093 130.806 537.218 -45.6932 630 228.951" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>';

						// $aspect_ratio = '700/530';
						// $stroke_width = 140;

						$curve_svg = '<svg class="animated-svg">
						<path class="base-path-template" d="M192.382 521C39.5174 318.497 48.6153 115.025 183.22 83.3538C253.889 66.726 337.578 139.012 320.668 274.334C311.431 348.261 338.903 437.756 430.101 437.756C496.778 437.756 581.903 340.598 502.617 213.3C462.963 149.634 613.963 -49.5872 720 260.413" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>';
						$aspect_ratio = '801/601';
						// $stroke_width = 160;

					} else if ($section_curve_style === 'curve2') {
						// $curve_svg = '<svg class="animated-svg">
						// 							<path class="base-path-template"
						// 							d="M160.169 523.8C123.496 434.263 41.0182 231.585 101.5 174.301C224 58.2772 281.146 527.955 378 523.8C474.855 519.644 521.695 423.549 385.349 273.361C277.739 154.828 453.064 -17.4951 556.5 146.277C659.937 310.049 624.045 438.868 702.798 462.669C781.551 486.469 665.624 179.856 761.826 186.622C862.806 193.724 899.705 438.041 941.001 523.8"
						// 							fill="none" />
						// 						</svg>';
						// $aspect_ratio = '1000/600'; // Default aspect ratio

						$curve_svg = '<svg class="animated-svg">
						<path class="base-path-template" d="M166.751 520C127.072 413.486 37.8348 172.377 103.274 104.23C235.814 -33.7929 308.796 462.039 411.963 481.08C481.963 494 596.033 424.382 448.511 245.716C332.082 104.707 484.048 -5.82593 595.963 189C707.877 383.826 720 467.431 720 467.431" fill="none" stroke-linecap="round"/>
												</svg>';
						$aspect_ratio = '801/601';


					} else if ($section_curve_style === 'curve3') {
						// $curve_svg = '<svg class="animated-svg">
						// 							<path class="base-path-template" d="M64.5 480.277C93.7275 569.61 221 661.777 339.5 588.277C563.393 449.407 382.043 305.925 300.5 363.777C231.526 412.712 280.688 575.835 494.155 527.303C701 480.277 630.447 119.932 515.591 89.0381C407.954 60.0856 365.463 207.708 456.861 241.857C548.258 276.006 694.458 143.711 690 64.2772" fill="none" />
						// 						</svg>';
						// $stroke_width = 100; // Adjust stroke width for curve2

						$curve_svg = '<svg class="animated-svg">
						<path class="base-path-template" d="M166.751 520C127.072 413.486 37.8348 172.377 103.274 104.23C235.814 -33.7929 308.796 462.039 411.963 481.08C481.963 494 596.033 424.382 448.511 245.716C332.082 104.707 484.048 -5.82593 595.963 189C707.877 383.826 720 467.431 720 467.431" fill="none" stroke-linecap="round"/>						
												</svg>';
						// $aspect_ratio = '801/601';
						$aspect_ratio = '540/405';
						$stroke_width = 120;

					} else if ($section_curve_style === 'curve4') {
						// $curve_svg = '<svg class="animated-svg">
						// 							<path class="base-path-template"
						// 						d="M100 100 C 200 0, 300 200, 400 100 S 600 0, 700 100"
						// 						fill="none" />
						// 						</svg>';
						// $stroke_width = 80; // Adjust stroke width for curve3

						$curve_svg = '<svg class="animated-svg">
						<path class="base-path-template" d="M81 393.217C115.711 464.506 262.541 561.619 403.272 502.964C447.706 484.445 478.238 460.862 497.659 434.889M497.659 434.889C594.455 305.435 415.214 116.591 305.273 199.283C236.728 250.839 278.783 446.31 497.659 434.889ZM497.659 434.889C510.356 434.227 523.649 432.868 537.549 430.744C783.199 393.217 753.12 105.654 616.717 81" fill="none" stroke-linecap="round"/>
												</svg>';
						$aspect_ratio = '801/602';

					} else if ($section_curve_style === 'curve5') {
						$curve_svg = '<svg class="animated-svg">
													<path class="base-path-template" d="M633.726 80C780.311 263.085 724.806 489.553 595.73 518.187C527.964 533.22 438.785 453.346 455 331C463.858 264.162 429.452 187.168 342 187.168C278.062 187.168 223.97 289.909 300 405C338.025 462.562 182.681 638.38 81 358.106" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
												</svg>';
						// $stroke_width = 160; // Adjust stroke width for curve5
						$aspect_ratio = '642/442';

					} else if ($section_curve_style === 'curve6') {
						$curve_svg = '<svg class="animated-svg">
													<path class="base-path-template" d="M85.2018 181.164C67.8793 279.759 84.0679 485.042 287.403 517.414C343.099 526.282 389.06 511.699 424.941 483.519M424.941 483.519C552.806 383.099 552.68 110.004 409 110.016C251.761 110.03 282.074 411.145 424.941 483.519ZM424.941 483.519C436.266 489.256 448.298 493.556 461 496.155C757.687 556.851 718.261 80 718.261 80" fill="none" stroke-linecap="round"/>
												</svg>';
						// $stroke_width = 160; // Adjust stroke width for curve6
						$aspect_ratio = '640/440';
					} else if ($section_curve_style === 'curve7') {
						$curve_svg = '<svg class="animated-svg">
						<path class="base-path-template" d="M80 202.066C173.588 102.868 313.786 24.538 369.319 130.822C438.735 263.678 100.744 335.768 156.3 461.781C198.152 556.709 343.718 536.322 418.298 394.945C461 313.997 574.017 91.2328 666.825 149.126C756.876 205.3 730.301 333.036 604.167 461.781" fill="none" stroke-linecap="round"/>
												</svg>';
						// $stroke_width = 160; // Adjust stroke width for curve7
						$aspect_ratio = '800/600';
					} else if ($section_curve_style === 'curve8') {
						$curve_svg = '<svg class="animated-svg">
						<path class="base-path-template" d="M80 397.934C173.588 497.132 313.786 575.462 369.319 469.178C438.735 336.322 100.744 264.232 156.3 138.219C198.152 43.2907 343.718 63.6785 418.298 205.055C461 286.003 574.017 508.767 666.825 450.874C756.876 394.7 730.301 266.964 604.167 138.219" fill="none" stroke-linecap="round"/>
												</svg>';
						// $stroke_width = 160; // Adjust stroke width for curve8
						$aspect_ratio = '800/600';
					}

					
				?>


				<div class="hero-animation__image">
					<div class="hero-animation__animation">
						<div class="animation-container"
								data-image-src="<?php echo esc_url($curve_image); ?>"
								data-stroke-color="<?php echo esc_attr($stroke_color); ?>"
								data-stroke-width="<?php echo esc_attr($stroke_width); ?>"
								data-animation-duration="<?php echo esc_attr($animation_duration); ?>"
								data-fade-duration="<?php echo esc_attr($fade_duration); ?>"
								data-fade-offset="<?php echo esc_attr($fade_offset); ?>"
								data-aspect-ratio="<?php echo esc_attr($aspect_ratio); ?>"
								data-padding-factor="<?php echo esc_attr($padding_factor); ?>">

								<?php echo $curve_svg; ?>
						</div>
					</div>
				</div>


			<?php } ?>



			</div>



		</div>
	</section>
<?php } ?>