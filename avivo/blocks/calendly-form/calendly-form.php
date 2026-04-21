<?php
//===================================================================
//	Calendly Form
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/*
	// Get all fields for the current block
	$block_fields = get_fields();

	// Check if fields are available
	if( $block_fields ) {
		echo '<p>Calendly Form<br />';
		foreach( $block_fields as $field_name => $value ) {
			echo esc_html($field_name) . ': ' . esc_html($value) . ' : ' . gettype($value) . '<br />';
			if (is_array($value)) {
				foreach ($value as $key => $val) {
					echo '- '.$key.' : ('.gettype($val) . ') '.esc_html($val).'<br />';
					if (is_array($val)) {
						foreach ($val as $k => $v) {
							echo '-- '.$k.' : ('.gettype($v) . ') '.esc_html($v).'<br />';
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
	wp_enqueue_script('nouislider-script');
	wp_enqueue_style('nouislider-style');

	// Default values
	$default_title = array(
		'title_text'	=> 'Your Title',
		'title_tag'		=> 'h2',
	);
//	$default_desc = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.';

	// Get the ACF fields
	// Front end, set to false or empty by default
	$section_title			= get_field('section_title') ?? false;			// array
	$section_description	= get_field('section_description') ?? '';		// string
	$section_calendly_url	= get_field('section_calendly_url') ?? '';		// string
	$section_button_row		= get_field('section_button_row') ?? false;		// array

	if (is_admin()) {
		// Set the default value on admin area only
		$section_title = (!empty($section_title) && !empty($section_title['title_text'])) ? $section_title : $default_title;
	//	$section_description = (!empty($section_description)) ? $section_description : $default_desc;
	//	$section_button_row = ($section_button_row !== null && $section_button_row !== []) ? $section_button_row : $default_button_row;
	}

	// Get ACF fields for setting
	$section_config	= get_field('section_config') ?? false;				// array

	// section color
	$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
	$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
	$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

	// Define section element class names
	$section_config['section_classname']			= 'cdb-calendly_form';			// section block class name
	$section_title['title_class']					= 'calendly_form__title';		// section title wrapper class name
	$section_button_row['section_buttons_class']	= 'calendly_form__cta';			// section CTA wrapper class name

	// Check the query string parameters
	$params = array();
	if (isset($_GET['fullname'])) {
		$params[] = 'name='.sanitize_text_field($_GET['fullname']);
	}
	if (isset($_GET['email'])) {
		$params[] = 'email='.sanitize_text_field($_GET['email']);
	}
	if (isset($_GET['company'])) {
		$params[] = 'a1='.sanitize_text_field($_GET['company']);
	}
	if (isset($_GET['website'])) {
		$params[] = 'a2='.sanitize_text_field($_GET['website']);
	}
	if (isset($_GET['desc'])) {
		$params[] = 'a3='.sanitize_text_field($_GET['desc']);
	}
	if (isset($_GET['phone'])) {
		$params[] = 'a4='.sanitize_text_field($_GET['phone']);
	}

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
	<div class="container section-container">
		<div class="content-container">

			
			<div class="text-container">
			<?php
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
			?>
			</div>
			
			<div class="form-container">
			<?php
				// Check if section_calendly_url is valid
				if ($section_calendly_url && filter_var($section_calendly_url, FILTER_VALIDATE_URL)) {
					echo '<!-- Calendly inline widget begin -->';
					echo '<div class="calendly-inline-widget" data-url="' . esc_url($section_calendly_url) . '?' . join('&', $params) . '&hide_event_type_details=1&hide_gdpr_banner=1&primary_color=ed4e47" style="min-width:320px;height:700px;"></div>';
					echo '<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>';
					echo '<!-- Calendly inline widget end -->';
				} else {
					// Handle invalid or empty URL
					echo 'Invalid URL or no Calendly link provided.';
				}				
			?>
			</div>
				
		</div>
	</div>
</section>