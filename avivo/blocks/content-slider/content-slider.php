<?php
//===================================================================
//	Text Content Slider Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


	// Get all fields for the current block
	$block_fields = get_fields();

	// Check if fields are available
/*	if( $block_fields ) {
		echo '<p>Text Content Slider<br />';
		foreach( $block_fields as $field_name => $value ) {
			echo esc_html($field_name) . ': ' . esc_html($value) . ' : ' . gettype($value) . '<br />';
			if (is_array($value)) {
				foreach ($value as $key => $val) {
					echo '- '.$key.' : '.gettype($val) . '<br />';

					if (is_array($val)) {
						foreach ($val as $k => $v) {
							echo '- '.$k.' : '.gettype($v) . '<br />';
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
	$section_content_slider		= get_field('section_content_slider') ?? false;		// array

	$section_colour				= get_field('section_colour') ?? '';				// string
	$section_content_boxed		= get_field('section_content_boxed') ?? false;		// boolean
	$section_content_width		= get_field('section_content_width') ?? '';			// string
	$section_content_position	= get_field('section_content_position') ?? '';		// string
	$section_config				= get_field('section_config') ?? false;				// array

	$section_config['section_colour'] = $section_colour;
	$section_config['section_content_boxed'] = $section_content_boxed;
	$section_config['section_content_width'] = $section_content_width;
	$section_config['section_content_position'] = $section_content_position;

	// Default values
	$default_title = array(
		'title_text'	=> 'Add Your Slide',
		'title_tag'		=> 'h2',
	);
//	$default_desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.';

	// check if the slider has any slide
	if (isset($section_content_slider) && is_array($section_content_slider) && count($section_content_slider)>0 ) {

		// Define section element class names
		$section_config['section_classname']			= 'cdb-content-slider';		// section block class name

		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
	<div class="container section-container">
		<div class="splide slider-container"<?php /* data-autoplay="1" */ ?>>
			<div class="splide__track">
				<div class="splide__list">
					<?php
						// loop thru all the slides
						foreach( $section_content_slider as $slide ) {

							// Get the ACF fields
							// Front end, set to false or empty by default
							$section_title				= $slide['section_title'] ?? false;				// array
							$section_description		= $slide['section_description'] ?? '';			// string
							$section_button_row			= $slide['section_button_row'] ?? false;		// array

							if (is_admin()) {
								// Set the default value on admin area only
								$section_title			= (!empty($section_title) && !empty($section_title['title_text'])) ? $section_title : $default_title;
							//	$section_description	= (!empty($section_description)) ? $section_description : $default_desc;
							}
							
							// Define section element class names
							$section_title['title_class']					= 'content__title';			// section title wrapper class name
							$section_button_row['section_buttons_class']	= 'content__cta';			// section CTA wrapper class name

							echo '<div class="content-container splide__slide">';

							// Check if section_title exists and is not empty
							if (isset($section_title) && is_array($section_title)) {
								echo cd_title($section_title);
							}
									
							// Check if section_description exists
							if ($section_description) {
								echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
							}

							// Ensure section_button_row exists and is an array
							if (isset($section_button_row) && is_array($section_button_row)) {
								echo cd_button_row($section_button_row);
							}

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

			// Output user-defined custom CSS
			echo cd_section_user_custom_css($section_config);
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container">
<?php
				// Set the default value on admin area only
				$section_title			= get_field('section_title');						// array
				$section_title			= (!empty($section_title) && !empty($section_title['title_text'])) ? $section_title : $default_title;

				$section_description	= get_field('section_description');					// string
				$section_description	= (!empty($section_description)) ? $section_description : $default_desc;
				
				echo '<div class="content-container">';

				// Check if section_title exists and is not empty
				if (isset($section_title) && is_array($section_title)) {
					echo cd_title($section_title);
				}
						
				// Check if section_description exists
				if ($section_description) {
					echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
				}

				// Ensure section_button_row exists and is an array
				if (isset($section_button_row) && is_array($section_button_row)) {
					echo cd_button_row($section_button_row);
				}

				echo '</div>';
?>
			</div>
		</section>
<?php
		}
	}
?>