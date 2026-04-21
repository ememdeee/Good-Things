<?php
//===================================================================
//	Hero Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/*
	// Get all fields for the current block
	$block_fields = get_fields();

	// Check if fields are available
	if( $block_fields ) {
		echo '<p>Hero Slider<br />';
		foreach( $block_fields as $field_name => $value ) {
			echo esc_html($field_name) . ': ' . esc_html($value) . ' : ' . gettype($value) . '<br />';
			if (is_array($value)) {
				foreach ($value as $key => $val) {
					echo '- '.$key.' : (' . gettype($val) . ') ' . $val . '<br />';

					if (is_array($val)) {
						foreach ($val as $k => $v) {
							echo '-x '.$k.' : (' . gettype($v) . ') ' . $v . '<br />';

							if (is_array($v)) {
								foreach ($v as $f => $g) {
									echo '-x- '.$f.' : (' . gettype($g) . ') ' . $g . '<br />';

									if (is_array($g)) {
										foreach ($g as $h => $i) {
											echo '-x-x '.$h.' : (' . gettype($i) . ') ' . $i . '<br />';
										}
									}
								}
							}

						}
					}
				}
			}
		}
		echo '</p>';
	} else {
		echo '<p>No fields found for this block.</p>';
	}
*/

	// Enqueue script and style for the slider
	wp_enqueue_script('splide-slider-script');
	wp_enqueue_style('splide-slider-style');
	
	// Get the ACF fields for content slider
	$section_items		= get_field('section_items') ?? false;		// array

	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array
	$section_autoplay	= get_field('section_autoplay') ?? false;	// boolean

	$section_config['section_colour']		= get_field('section_colour') ?? '';			// string
	$section_config['section_height']		= get_field('section_height') ?? '30';			// string
	$section_config['section_height_unit']	= 'vh';											// string
	$section_config['section_margin']		= get_field('section_margin') ?? '';			// array
	$section_config['section_id']			= get_field('section_id') ?? '';				// string
	$section_config['section_class']		= get_field('section_class') ?? '';				// string
	$section_config['section_custom_css']	= get_field('section_custom_css') ?? '';		// string

	// Default values
	$default_title = array(
		'title_text'	=> 'Hero Slide',
		'title_tag'		=> 'h2',
	);
//	$default_desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.';

	// check if the slider has any slide
	if (isset($section_items) && is_array($section_items) && count($section_items)>0 ) {

		// Define section element class names
		$section_config['section_classname']			= 'cdb-hero_slider';		// section block class name

		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
<section class="<?php echo cd_get_section_config_class($section_config); ?> cdb-hero_slider--style-gradient-dark"<?php echo cd_get_section_style($section_config); ?><?php echo cd_get_section_id($section_config); ?>>
	<div class="section-container">
		<div class="splide slider-container"<?php echo 'data-autoplay="' . ($section_autoplay ? '1' : '0') . '"'; ?>>
			<div class="splide__track">
				<div class="splide__list">
				<?php
					// Loop through all the slides
					foreach( $section_items as $item ) {

						// Get the ACF fields
						// Front end, set to false or empty by default
						$item_image			= $item['item_image'] ?? false;				// array
						$item_title			= $item['item_title'] ?? false;				// array
						$item_description	= $item['section_description'] ?? '';		// string
						$item_buttons		= $item['item_buttons'] ?? false;			// array

						// Define section element class names
						$item_title['title_class']				= 'hero_slider__title';			// section title wrapper class name

						if (is_admin()) {
							// Set the default value on admin area only
							$item_title = (!empty($item_title) && !empty($item_title['title_text'])) ? $item_title : $default_title;
						//	$item_description = (!empty($item_description)) ? $item_description : $default_desc;
						//	$item_buttons = ($item_buttons !== null && $item_buttons !== []) ? $item_buttons : $default_button_row;
						}

						echo '<div class="content-container splide__slide hero_slider__slide">';

							$bgImage = cd_bgimage($item_image);
							echo $bgImage;

							echo '<div class="container hero_slider__slide_content">';
								echo '<div class="hero_slider__slide_inner_container">';
									// Check if item_title exists and is not empty
									if (isset($item_title) && is_array($item_title)) {
										echo cd_title($item_title);
									}
									
									// Check if item_description exists
									if (!empty($item_description)) {
										echo cd_print_richtext($item_description, '<div class="hero_slider__slide_description">', '</div>');
									}

									// Ensure item_buttons exists and is an array
									if (isset($item_buttons) && is_array($item_buttons)) {
										$item_buttons['section_buttons_class']	= 'hero_slider__cta';			// section CTA wrapper class name
										echo cd_button_row($item_buttons);
									}
									

								echo '</div>';
							echo '</div>';

						echo '</div>';
					}

				?>
				</div>
			</div>

		</div>
	</div>
</section>
<?php
	} else {
		// this part is for the block added to the editor, still empty
		if (is_admin()) {
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container">
<?php
				echo '<div class="content-container">';

				// item_title
				echo cd_title(array(
					'title_text'	=> 'Add Hero Slide',
					'title_tag'		=> 'h2',
				));
						
				// item_description
				echo cd_print_richtext( $default_desc,'<div class="content__description">','</div>' );

				echo '</div>';
?>
			</div>
		</section>
<?php
		}
	}
?>