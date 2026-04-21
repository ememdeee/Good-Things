<?php
//===================================================================
//	Rich Text with Chapter
//	Custom Section Block using ACF
//===================================================================
	
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Rich Text with Chapter';

$section_chapter_index = get_field('section_chapter_index') ?? '';			
$section_chapter_title = get_field('section_chapter_title') ?? '';

$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array
$section_config['section_colour']	= get_field('section_colour') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-richtext_chapter';		// section block class name

// check if title is set, if not show the placeholder
if (is_admin() && empty($section_chapter_index) && empty($section_chapter_title) && cd_cdb_isEmptyfields([$section_title, $section_title['title_text']]) && empty($section_description)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> >
		<div class="container section-container">
			<div class="content-container richtext-chapter">
			<?php 
				// var_dump($section_posts_selection);
				// var_dump($section_posts);
				// var_dump($selection_posts_ids);
			?>

				<div class="chapter-cols">
					<div class="richtext-chapter__chapter chapter-cols__chapter">
						<?php 				
							$chapter_id = 'chapter-' . (!empty($section_chapter_title) ? sanitize_title($section_chapter_title) : uniqid());
						?>
						<div class="chapter" id="<?php echo $chapter_id; ?>">
							<?php echo cd_print_wrap_tags($section_chapter_index,'<span class="chapter__index">','</span>'); ?>
							<?php echo cd_print_wrap_tags($section_chapter_title,'<strong class="chapter__title">','</strong>'); ?>
						</div>
					</div>
					<div class="richtext-chapter__content chapter-cols__content">
						<?php

							// Check if section_title exists and is not empty
							if (isset($section_title) && is_array($section_title)) {
								echo cd_title($section_title);
							}
									
							// Check if section_description exists
							if ($section_description) {
								// echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' ); // issue: this print gutenberg blocks too, most contents are copy pasted from gutenberg block that contains paragraph block
								echo '<div class="content__description">';
								echo do_shortcode($section_description);
								echo '</div>';
							}

							// Ensure section_button_row exists and is an array
							if (isset($section_button_row) && is_array($section_button_row)) {
								echo cd_button_row($section_button_row);
							}

						?>
					</div>
				</div>

			</div>
		</div>
	</section>
<?php } ?>