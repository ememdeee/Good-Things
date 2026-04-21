<?php
/**
 * The template for displaying all single posts
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<!-- --------------------------------------- -->
<div class="wrapper" id="single-wrapper">
	<main class="site-main" id="main">
		<!-- banner -->
		<?php 
			// $inner_banner = [
			// 	'section_image' =>  get_post_thumbnail_id( get_the_ID()),
			// 	'section_title' => ' '
			// ];
			

		// $inner_banner['section_slim'] = true;
		

		$inner_content_class = 'col-lg-10 offset-lg-1 col-xl-8 offset-xl-2';

			// // var_dump($inner_banner);
			// if ($inner_banner) {
			// 	cd_render('sections/inner-banner.php', $inner_banner);
			// }

			// var_dump(get_post_thumbnail_id( the_ID()));
			$inner_container_class = 'mb-5 mb-md-6';

		?>
		
	<?php /*
	<div class="section-breadcrumbs">
		<div class="container">
			<?php if ( function_exists('yoast_breadcrumb') ) { ?>
				<?php
					yoast_breadcrumb( '<div class="">','</div>' );
				?>
			<?php } ?>                                

		</div>
	</div>
	*/ ?>
		
		<div class="container inner-container <?php echo $inner_container_class; ?>">
			<div class="row">
				<div class="inner-content <?php echo $inner_content_class; ?>">
					<?php
						while ( have_posts() ) :
							the_post(); ?>

							<article <?php post_class(); ?> id="post-<?php the_ID(); ?>" >
								
								<header class="entry-header">
									<div class="entry-subtitle subtitle">Our Stories</div>
									<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

									
							
								</header><!-- .entry-header -->
							
							
								<div class="entry-meta">
									
									<div class="entry-date">
										<?php understrap_posted_on(); ?>
									</div>

									<div class="entry-cat">
										<?php echo cd_display_category(); ?>
									</div>

								</div>

								<div class="entry-teaser">
									<?php /* 
									<div class="entry-teaser__excerpt h3">
										<?php echo get_the_excerpt(); ?>
									</div> 
									*/ ?>


									<?php if ( has_post_thumbnail() ) { ?>
									<div class="entry-teaser__image">
										<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>


									</div>
									<?php	} ?>

								</div>


								<div class="entry-content">
							
									<?php the_content(); ?>
							
									<?php
									wp_link_pages(
										array(
											'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
											'after'  => '</div>',
										)
									);
									?>
							
								</div><!-- .entry-content -->				

							
							
							
								<footer class="entry-footer">
							
									<?php understrap_entry_footer(); ?>
							
								</footer><!-- .entry-footer -->
							
							</article><!-- #post-## -->

							<?php // ClueEdit: revision ?>
							<div class="main-content-sections-group">
								<?php 
									$main_content_dynamic_sections = get_field('main_content_dynamic_sections');

									cd_render('sections/dynamic-sections.php', [
										'dynamic_sections' => $main_content_dynamic_sections,
										'main_content' => true
									] )
								?>
							</div>


							<?php							


						endwhile;
					?>
				</div>	
				<?php /*					
				<div class="inner-sidebar <?php echo $inner_sidebar_class; ?>">
					<div class="sidebar-box sidebar-box--dropdown">
						Aside here
					</div>
				</div>
				*/ ?>
			</div>
		</div>
	</main><!-- #main -->
</div><!-- #single-wrapper -->
<?php
get_footer();
