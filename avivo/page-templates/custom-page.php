<?php
/**
 * Template-Name: xCustom Template
 *
 * Template for displaying custom page template
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

?>

<div class="wrapper" id="page-wrapper">
	<main class="site-main" id="main">

		<div class="sections-group">
			<?php 
//				$dynamic_sections = get_field('dynamic_sections');

//				cd_render('sections/dynamic-sections.php', [
//					'dynamic_sections' => $dynamic_sections
//				] )
			?>
		</div>

	</main><!-- #main -->
</div><!-- #page-wrapper -->


<?php

get_footer();
