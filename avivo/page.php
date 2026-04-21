<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

<div class="wrapper" id="page-wrapper">
	<main class="site-main <?php // echo ($hide_main_content !== true && $hide_sidebar !== true)?'site-main--sidebar':''; ?>" id="main">

	<!--	<div class="container"> -->
		<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'loop-templates/content', 'empty' );
			endwhile;
		?>
	<!--	</div> -->

	</main><!-- #main -->
</div><!-- #page-wrapper -->



<?php
get_footer();
