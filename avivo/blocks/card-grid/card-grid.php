<?php
//===================================================================
//	Section Card Grid
//	Custom Section Block using ACF
//===================================================================

defined( 'ABSPATH' ) || exit;

$placeholder_title = 'Card Grid Title';

// Get the ACF fields
$section_cards = get_field('section_cards') ?? [];

$section_config = get_field('section_config') ?? false;
$section_config['section_colour'] = get_field('section_colour') ?? '';
$section_config['section_content_width'] = get_field('section_content_width') ?? '';
$section_config['section_content_position'] = get_field('section_content_position') ?? '';

$section_config['section_classname'] = 'cdb-card_grid';


if (is_admin() && (empty($section_cards) || count($section_cards) === 0)) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">
				<div class="card-grid">
					<?php if (!empty($section_cards)): ?>
						<div class="card-grid__items">
							<?php foreach ($section_cards as $card): ?>
                <?php 
                  $card_image = $card['card_image'] ?? '';  
                  $card_title = $card['card_title'] ?? '';
                  $card_description = $card['card_description'] ?? '';
                  $card_link = $card['card_link'] ?? '';
                ?>
								<div class="card-grid__item">
                  <?php
                    if ($card_image) {
                      echo '<div class="card-grid__item-image">';
                      echo wp_get_attachment_image($card_image, 'full');
                      echo '</div>';
                    }
                  ?>

									<?php echo cd_print_wrap_tags($card_title,'<h4 class="card-grid__item-title">','</h4>'); ?>
									<?php echo cd_print_wrap_tags($card_description,'<div class="card-grid__item-description">','</div>'); ?>
									<?php if (!empty($card_link)): ?>
                    <div class="card-grid__item-link">
                      <a href="<?php echo esc_url($card_link); ?>" class="btn t-tagline"><span class="link-text">Learn more</span></a>
                    </div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
