<?php
/**
 * Template Name: Journey Result Page
 *
 * Template for displaying Journey Quiz page
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


// We load script & js here to make this template portable
function cd_quiz_scripts() {
    $version = /*THEME_VERSION*/ '2024020701';
  
    wp_enqueue_script( 'quiz-data', get_stylesheet_directory_uri().'/js/quiz-data.js?v='.$version, array (  ), $version, true );
    wp_enqueue_script( 'quiz-min', get_stylesheet_directory_uri().'/js/quiz.min.js?v='.$version, array ( 'jquery','quiz-data' ), $version, true );
  
    wp_enqueue_style( 'quiz-style', get_template_directory_uri() . '/css/quiz.min.css?v='.$version, [], $version );

    // inline script
    $inline_script = '
        journeyResult();
    ';
    wp_add_inline_script('quiz-min', $inline_script, 'after');
}
  
add_action('wp_enqueue_scripts', 'cd_quiz_scripts', 101);

$journey_result_header = get_field('journey_result_header');

$header_template = '';

if ($journey_result_header === 'journey') {
    $header_template = 'journey-quiz';
}

get_header($header_template);


?>

<div class="wrapper quiz-result-wrapper" id="page-wrapper">
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
