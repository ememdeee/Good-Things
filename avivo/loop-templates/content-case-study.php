<?php
/**
 * Post rendering content according to caller of get_template_part
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$cover_image = get_field('cover_image', get_the_ID()) ?? false;
$cover_image_secondary = get_field('cover_image_secondary', get_the_ID()) ?? false;


?>

<article <?php post_class('post-card card post-card--color-default'); ?> id="post-<?php the_ID(); ?>">
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-grid-link">
		<div class="card-img-wrapper">
			<?php 
				if ($cover_image) {
					echo wp_get_attachment_image($cover_image, 'full', false, array('class' => 'card-img-primary'));
				} else if (has_post_thumbnail()) {
					echo get_the_post_thumbnail( $post->ID, 'full', array('class' => 'card-img-primary') ); 
				}

				if ($cover_image_secondary) {
					echo wp_get_attachment_image($cover_image_secondary, 'full', false, array('class' => 'card-img-secondary'));
				}
			?>
		</div>


		<div class="card-body">

			<div class="entry-meta">
				<div class="entry-cat">
					<?php //echo cd_display_category(true); ?>


					<?php 
						$case_study_terms = get_the_terms(get_the_ID(), 'case-study-category');
						$case_study_categories = !empty($case_study_terms) ? reset(wp_list_pluck($case_study_terms, 'name')) : '';
						if (!empty($case_study_categories)) {
							echo '<ul class="cat-links">';
							echo '<li>';
							echo esc_html($case_study_categories);
							echo '</li>';
							echo '</ul>';
						}											
					?>


				</div>
				<?php if ( 'post' === get_post_type() ) { ?>
					<div class="entry-date sep-left">
						<?php understrap_posted_on(); ?>
					</div>
				<?php }  ?>
			</div><!-- .entry-meta -->

			<header class="entry-header">
				<?php
				/*the_title(
					sprintf( '<h2 class="entry-title card-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
					'</a></h2>'
				);*/
				the_title(
					'<h2 class="entry-title card-title h4">',
					'</h2>'
				);
				?>
			</header><!-- .entry-header -->

			<div class="card-text entry-content">
				<?php 
					if (!(is_front_page() || is_single() )) {
						the_excerpt(); 
					}

					// $excerpt = text_max_charlength(wp_filter_nohtml_kses(get_the_excerpt()),150);
					// echo '<p>'.$excerpt.'</p>';
				?>

				<?php /*
				<div class="card-read-more-link">
					<span class="link-text">
						View Article
					</span>
				</div>
				*/ ?>

				<?php /*
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
						'after'  => '</div>',
					)
				);*/
				?>
			</div>

			<?php /*
			<footer class="entry-footer">

				<?php understrap_entry_footer(); ?>

			</footer><!-- .entry-footer -->
			*/ ?>
		</div>
	</a>
</article>