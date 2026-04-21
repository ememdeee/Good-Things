<?php
//===================================================================
//	Featured List Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Featured List';

// Get the ACF fields
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array

$section_config['section_colour']		= get_field('section_colour') ?? '';			// string

// Define section element class names
$section_config['section_classname']	= 'cdb-featured_list';							// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the featured tiles has any tile
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// if the items are set
	if ($has_items) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
		?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?> cdb-featured_list--style-numbered"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container" data-aos="fade-up">
				<div class="content-container">
					<ol class="featured-list__list">
						<?php
							$i = 0;
							// Loop through all the slides
							foreach( $section_items as $item ) {

								// Get the ACF fields
								// Front end, set to false or empty by default
								$item_title			= $item['item_title'] ?? false;			// array
								$item_description	= $item['item_description'] ?? '';		// string

								$i++;

								// Set default title in admin area
								if (is_admin()) {
									// Ensure 'title_text' is set with a default value in the admin area
									$item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Title';
								}

								echo '<li class="featured-list__item">';
									echo '<div class="featured-list__item-number sc-lavender">';
									echo str_pad($i, 2, '0', STR_PAD_LEFT);
									echo '</div>';

									echo '<div class="featured-list__item-content">';
										
										// Check if item_title exists and is not empty
										if (!empty($item_title)) {
											$item_title['title_class'] = 'featured-list__item-title';
											echo cd_title($item_title);
										}
										
										// Check if item_description exists
										if (!empty($item_description)) {								
											echo cd_print_richtext($item_description, '<div class="featured-list__item-description">', '</div>');
										}

									echo '</div>';



								echo '</li>';
							}

						?>
					</ol>
				</div>
			</div>
		</section>
<?php
	} 
}
?>