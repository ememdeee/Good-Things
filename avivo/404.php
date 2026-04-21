<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="error-404-wrapper">

	<!-- <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1"> -->



				<main class="site-main" id="main">

					<section class="section error-404 not-found">
						<div class="container section-container">
						<div class="content-container">

							<header class="page-header">

								<h1 class="page-title"><?php esc_html_e( 'Oops!', 'understrap' ); ?></h1>

							</header><!-- .page-header -->

							<div class="page-content">


								

								<?php // get_search_form(); ?>

								<?php // the_widget( 'WP_Widget_Recent_Posts' ); ?>

									<h3>The page you have requested cannot be found.</h3>
									
									<p>The page might have been removed, had its name changed, or is temporarily unavailable.
									<br>
									Please make sure that the website address displayed in the address bar of your browser is spelled and formatted correctly.</p>
									<p>
										<a class="btn btn-primary btn-color-red" href="/">Return to Homepage</a>
									</p>

								<?php

								// /* translators: %1$s: smiley */
								// $archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'understrap' ), convert_smilies( ':)' ) ) . '</p>';
								// the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

								// the_widget( 'WP_Widget_Tag_Cloud' );
								?>

							</div>	<!-- .page-content -->
						</div>
						</div>

					</section><!-- .error-404 -->

				</main><!-- #main -->



	<!--</div>--><!-- #content -->

</div><!-- #error-404-wrapper -->

<?php
get_footer();
