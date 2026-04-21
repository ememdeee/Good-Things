<?php
//===================================================================
//	Featured Tiles Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Flip Cards';

// Get the ACF fields
$section_cards		= get_field('section_cards') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array

$section_config['section_colour']		= get_field('section_colour') ?? '';			// string

// Define section element class names
$section_config['section_classname']	= 'cdb-flip_cards';							// section block class name

// var_dump($section_cards);

// Check if section_cards has cards
$has_cards = isset($section_cards) && is_array($section_cards) && count($section_cards)>0;


// check if the featured tiles has any tile
if (is_admin() && !$has_cards) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// if the cards are set
	if ($has_cards) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
		?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container" data-aos="fade-up">
				<div class="content-container">
          <div class="flip_cards__cards">
            <?php
              // Loop through all the slides
              foreach( $section_cards as $card ) {

                // Get the ACF fields
                $card_front_title = $card['card_front_title'] ?? '';			// array
                $card_title = $card['card_title'] ?? '';			// array
                $card_description = $card['card_description'] ?? '';	// string
                $card_link_text = $card['card_link_text'] ?? '';		// string
                $card_link = $card['card_link'] ?? '';				// string
                $card_color = $card['card_color'] ?? '';			// string
                $front_variant_colour = $card['front_variant_colour_variant_colour'] ?? 'default';	// string
                $back_variant_colour = $card['back_variant_colour_variant_colour'] ?? 'default';	// string

                $flip_card_classes = '';
                $flip_card_classes .= 'flip-card--vertical';

                $flip_card_style = '';

                // if ($variant_colour && $variant_colour !== 'default') {
                //   $flip_card_style .= ' --theme-variant-color: var(--theme-color-' . $variant_colour . ');';
                // }
                
                $front_card_classes = '';
                if ($front_variant_colour && $front_variant_colour !== 'default') {
                  $front_card_classes .= ' sc-' . $front_variant_colour;
                }
                $back_card_classes = '';
                if ($back_variant_colour && $back_variant_colour !== 'default') {
                  $back_card_classes .= ' sc-' . $back_variant_colour;
                }

                ?>
                <a class="flip-card <?php echo esc_attr($flip_card_classes); ?>" style="<?php echo esc_attr($flip_card_style); ?>" href="<?php echo esc_url($card_link); ?>">
                  <div class="flip-card__front <?php echo esc_attr($front_card_classes); ?>">
                    <?php echo cd_print_wrap_tags( $card_front_title,'<h3 class="flip-card__front-title h2">','</h3>' ); ?>

                    <?php // echo $front_variant_colour; ?>
                    <?php // echo $back_variant_colour; ?>

                    <div class="flip-card__icon">
                      <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/svg/icon-plus.svg'); ?>" />
                    </div>
                  </div>
                  <div class="flip-card__back <?php echo esc_attr($back_card_classes); ?>">
                    <?php echo cd_print_wrap_tags( $card_title,'<h2 class="flip-card__title">','</h2>' ); ?>
                    <?php echo cd_print_richtext( $card_description,'<div class="flip-card__description">','</div>' ); ?>

                    <?php 
                        // Check if card_link exists
                        if (!empty($card_link)) {
                          $card_link_text = empty($card_link_text) ? 'Learn more' : $card_link_text;

                          echo '<div class="flip-card__button">';
                          echo '<span href="' . esc_url($card_link) . '" class="btn t-tagline"><span class="link-text">' . esc_html($card_link_text) . '</span></span>';
                          echo '</div>';

                          // $button_class = 't-tagline';
                          // echo '<div class="flip-card__button">';
                          // echo cd_button(array(
                          //   'text'		=> $card_link_text,
                          //   'link'		=> $card_link,
                          //   'style'		=> $button_class . '',
                          //   'size'		=> '',
                          //   'icon'		=> 'r-arrow',
                          // ));
                          // echo '</div>';

                        }              
                    ?>
                    <div class="flip-card__icon">
                      <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/img/svg/icon-minus.svg'); ?>" />
                    </div>

                  </div>
                </a>

                <?php


                // Set default title in admin area
                if (is_admin()) {
                  // Ensure 'title_text' is set with a default value in the admin area
                  $item_title['title_text'] = !empty($item_title['title_text']) ? $item_title['title_text'] : 'Add Title';
                }

              }

            ?>
          </div>
				</div>
			</div>
		</section>
<?php
	} 
}
?>