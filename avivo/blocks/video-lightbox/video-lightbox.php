<?php
//===================================================================
//	Section Video Lightbox
//	Custom Section Block using ACF
//===================================================================

defined( 'ABSPATH' ) || exit;

$placeholder_title = 'Video Lightbox Title';

// Get the ACF fields
$section_video_url = get_field('section_video_url') ?? '';
$section_video_description = get_field('section_video_description') ?? '';
$section_video_file = get_field('section_video_file') ?? '';
$section_poster_image = get_field('section_poster_image') ?? '';

$section_config = get_field('section_config') ?? false;
$section_config['section_colour'] = get_field('section_colour') ?? '';
$section_config['section_content_width'] = get_field('section_content_width') ?? '';
$section_config['section_content_position'] = get_field('section_content_position') ?? '';

$section_config['section_classname'] = 'cdb-video_lightbox';
$section_title['title_class'] = 'video_lightbox__title';
$section_button_row['section_buttons_class'] = 'video_lightbox__cta';

$gallery_id = 'gallery-'.cd_random_number();

$video_link = '';
if (!empty($section_video_file)) {
	$video_link = wp_get_attachment_url($section_video_file);
} elseif (!empty($section_video_url)) {
	$video_link = $section_video_url;
}
    
if (is_admin() && (empty($section_poster_image))) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">
				<div class="video-lightbox__video">
					<?php if ($video_link): ?>
              <?php
                if ($section_poster_image) {
                  echo wp_get_attachment_image($section_poster_image, 'full');
                }
              ?>
						<a href="<?php echo esc_url($video_link); ?>" class="video-lightbox__play glightbox-video" data-gallery="<?php echo $gallery_id; ?>">
              Play Video
						</a>
					<?php endif; ?>
				</div>
        
        <div class="video-lightbox__description">
          <?php echo cd_print_richtext( $section_video_description,'','' ); ?>
        </div>
			</div>
		</div>
	</section>
<?php } ?>
