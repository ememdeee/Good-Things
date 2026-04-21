<?php
//===================================================================
//	Toggle List Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Toggle List';

// variable to store the FAQs
global $all_faqs;

// Get the ACF fields for content slider
$section_title = get_field('section_title') ?? false;				// array
$section_description = get_field('section_description') ?? '';		// string
$section_button_row = get_field('section_button_row') ?? false;		// array
$section_button_row2 = get_field('section_button_row2') ?? false;		// array
$section_style = get_field('section_style') ?? 'default';		// string

$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config			= get_field('section_config') ?? false;				// array
$section_toggle_icon	= get_field('section_toggle_icon') ?? 'plus';		// string
$section_toggle_state	= get_field('section_toggle_state') ?? false;		// boolean
$section_faq_schema		= get_field('section_faq_schema') ?? false;		// boolean

$section_config['section_colour']	= get_field('section_colour') ?? '';	// string

// Define section element class names
$section_config['section_classname']			= 'cdb-featured_faq';		// section block class name
$section_title['title_class']					= 'cdb-featured_faq__title';			// section title wrapper class name
$section_button_row['section_buttons_class']	= 'cdb-featured_faq__cta';			// section CTA wrapper class name
$section_button_row2['section_buttons_class']	= 'cdb-featured_faq__cta2';			// section CTA wrapper class name


// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

/* 
	Special condition:
	some FAQ block is repurposed as expand/collapse toggle for important information, eg: for support call
	to do that we use this convention:
	- add custom class cdb-featured_faq--important
	- usually only one item in the FAQ list
	- in the description, add markup with this pattern
		<blockquote class="featured-faq__additional-title--static">
			If you are in immediate danger, call: <a href="tel:000">Triple zero (000)</a>
		</blockquote>
		<blockquote class="featured-faq__additional-title--collapsible">
			<a class="btn h-dark" href="#"><span class="link-text">Discover more stories</span></a>
		</blockquote>	
*/

// check if the slider has any slide, if not show the placeholder
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// check if the slider has any slide
	if ($has_items) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?> cdb-featured_faq-style--<?php echo esc_attr($section_style); ?>"<?php echo cd_get_section_id($section_config); ?> data-toggle-state="<?php echo ($section_toggle_state) ? 'open' : 'close'; ?>">
			<div class="container section-container">
				<div class="content-container">

				<?php if (
					(isset($section_title) && is_array($section_title) && !empty($section_title['title_text'])) 
					|| $section_description /*|| (isset($section_button_row) && is_array($section_button_row))*/
					) { ?>
				<div class="featured-faq__title">
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
				<?php } ?>

				<div class="featured-faq__content">

					<?php 
						$faq_classes = '';
						if ($section_style !== 'compact') {
							$faq_classes .= ' featured_faq__list--boxed';
						}

						featured_faq_list($section_items, $section_toggle_icon, $section_faq_schema, false, 'sc-teal', $faq_classes);
					?>

					<?php if (isset($section_button_row2) && is_array($section_button_row2)) { ?>
					<?php
						// Ensure section_button_row2 exists and is an array
						if (isset($section_button_row2) && is_array($section_button_row2)) {
							echo cd_button_row($section_button_row2);
						}
					?>
					<?php } ?>

				</div>


					
				</div>
			</div>
		</section>
<?php
		}
	}
?>