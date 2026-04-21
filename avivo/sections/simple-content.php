<?php
	//*******************************************************************
	// $vars: all data is stored in this array variable
	// Variables are extracted from this array > extract($vars);
	// Use the code below to check extracted variables
	// foreach ($vars as $key => $value) {
	//		echo '<br>'.$key.' : '.gettype($value);
	// }
	//*******************************************************************

	$section_title				= $section_title ?? false;			// array
	$section_description		= $section_description ?? false;	// string
	$section_button_row			= $section_button_row ?? false;		// array
	$section_content_boxed		= $section_content_boxed ?? false;	// boolean
	$section_content_width		= $section_content_width ?? '';		// string
	$section_content_position	= $section_content_position ?? '';	// string
	$section_config				= $section_config ?? false;			// array
	$section_index				= $section_index ?? false;			// integer

	$section_config['section_content_boxed'] = $section_content_boxed;
	$section_config['section_content_width'] = $section_content_width;
	$section_config['section_content_position'] = $section_content_position;
	$section_config['section_content_index'] = $section_index;

	// Define section element class names
	$section_config['section_classname']			= 'cdb-content';		// section block class name
	$section_title['title_class']					= 'content__title';		// section title wrapper class name
	$section_button_row['section_buttons_class']	= 'content__cta';		// section CTA wrapper class name

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
	<div class="container section-container">
		<div class="content-container">
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
	</div>
</section>

