<?php
//===================================================================
//	Icon Grid Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Icon Grid';


// Get the ACF fields
$section_title			= get_field('section_title') ?? false;			// array
$section_description	= get_field('section_description') ?? '';		// string
$section_button_row		= get_field('section_button_row') ?? false;		// array
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array

$section_config['section_colour']		= get_field('section_colour') ?? '';			// string
$section_config['section_column']		= get_field('section_column') ?? '3';			// string, default 3 columns
$section_config['section_grid_style']	= get_field('section_grid_style') ?? '';		// string
$section_config['section_grid_padding']	= get_field('section_grid_padding') ?? '';		// string
$section_config['section_grid_spacing']	= get_field('section_grid_spacing') ?? '';		// string


// Define section element class names.
// Keep the legacy class for existing styles while exposing the new block name.
$section_config['section_classname']	= 'cdb-icon_grid';			// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;



// Check if the icon grid has any items.
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// if the items are set
	if ($has_items) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
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
                                if (!empty($tiles_nav)) {
                                    $section_description .= '<ul class="tile_nav">'.$tiles_nav.'</ul>';
                                }
                                echo cd_print_richtext( $section_description,'<div class="content__description">','</div>' );
                            }

                            // Ensure section_button_row exists and is an array
                            if (isset($section_button_row) && is_array($section_button_row)) {
                                echo cd_button_row($section_button_row);
                            }

                        ?>
                    </div>

                    <div class="grid-wrapper">
                        <div class="grid-container<?php echo cd_get_section_grid_class($section_config); ?>">
                        <?php
                            // Loop through all grid items.
                            foreach( $section_items as $item ) {

                                // Get the ACF fields
                                // Front end, set to false or empty by default
                                $item_image			= $item['item_image'] ?? 0;				// integer
                                $item_title			= $item['item_title'] ?? false;			// array
                                $item_description	= $item['item_description'] ?? '';		// string
                                $item_link			= $item['item_link'] ?? '';				// string
                                $item_link_text		= $item['item_link_text'] ?? '';		// string
                                $item_variant_colour = $item['item_variant_colour_variant_colour'] ?? 'default'; // string

                                $no_desc_class = empty($item_description) ? ' no-desc' : '';
                                $no_desc_class .= (!empty($item_link)) ? ' has-link' : '';

                                // Set default title in admin area
                                if (is_admin()) {
                                    // Ensure 'title_text' is set with a default value in the admin area
                                    $item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Title';
                                }

                                $colour_class = '';
                                // if ($item_variant_colour && $item_variant_colour !== 'default') {
                                    $colour_class .= ' sc-' . $item_variant_colour;
                                // }

                                echo '<div class="grid-item icon-grid__tile ' . $no_desc_class . $colour_class . '">';
                                    echo '<div class="grid-item-content icon-grid__tile-container">';

                                            $icon = wp_get_attachment_image($item_image, 'thunbnail');

                                            echo '<div class="icon-grid__tile-icon">';
                                            echo	'<div class="icon_wrapper">';
                                            echo		$icon;
                                            echo	'</div>';
                                            echo '</div>';

                                        echo '<div class="icon-grid__tile-content">';
                                            
                                            // Check if item_title exists and is not empty
                                            if (!empty($item_title)) {
                                                $item_title['title_class'] = 'icon-grid__tile-title';
                                                echo cd_title($item_title);
                                            }
                                            
                                            // Check if item_description exists
                                            if (!empty($item_description)) {								
                                                echo cd_print_richtext($item_description, '<div class="icon-grid__tile-description">', '</div>');
                                            }

                                            // Check if item_link exists
                                            if (!empty($item_link)) {
                                                $item_link_text = empty($item_link_text) ? 'read more' : $item_link_text;

                                                // echo '<div class="featured_tiles__tile-link_wrapper">';
                                                // echo '<a href="' . esc_url($item_link) . '" class="featured_tiles__tile-link"><span class="link-text">' . esc_html($item_link_text) . '</span></a>';
                                                // echo '</div>';

                                                $button_class = 't-tagline';
                                                // if ($tile_color && $tile_color === 'dark') {
                                                // 	$button_class = 'light';
                                                // }

                                                echo '<div class="icon-grid__tile-button">';
                                                echo cd_button(array(
                                                    'text'		=> $item_link_text,
                                                    'link'		=> $item_link,
                                                    'style'		=> $button_class . '',
                                                    'size'		=> '',
                                                    // 'icon'		=> 'r-arrow',
                                                ));
                                                echo '</div>';

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
	} 
}
?>