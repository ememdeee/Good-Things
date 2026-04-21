<?php
/**
 * Template Name: Journey Quiz Page
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
        var journeyQuizAssistant = new Assistant("JourneyQuiz");        
    ';
    wp_add_inline_script('quiz-min', $inline_script, 'after');
}
  
add_action('wp_enqueue_scripts', 'cd_quiz_scripts', 101);

get_header('journey-quiz');

?>

<div class="wrapper quiz-wrapper" id="quiz-wrapper">
	<main class="site-main" id="main">

    <script>
    </script>


        <div id="JourneyQuiz">
            <div class="quiz__steps">

            </div>
            <div class="quiz__result">

            </div>
        </div>


        <div class="quiz-intro-wrapper">
            <div class="quiz-intro-sections">
            <?php 

                // echo '<h1>Quiz intro here</h1>';
                // echo '<a href="#journey-quiz-start">Start</a>';

            // $section_quiz_intro = get_field('section_quiz_intro');            

            // if ($section_quiz_intro) {
            //     // cd_render('sections/content-with-image.php', $section_quiz_intro);
            //     echo '<h1>Quiz intro here</h1>';
            // } else {
            //     // cd_render('sections/content-with-image.php', array(
            //     //     'section_image' => 1024,
            //     //     'section_title' => 'Your Journey Starts Here',
            //     //     'section_subtitle' => 'Take Our Short Quiz',
            //     //     'section_content' => '',
            //     //     'section_button' => array(
            //     //         'button_text' => 'Start Avivo Journey',
            //     //         'button_link' => array(
            //     //             'url' => '#journey-quiz-start',
            //     //         ),
            //     //         'button_style' => 'primary'
            //     //     ),
            //     //     'section_style' => 'circles',
            //     //     'section_config' => array(
            //     //         // 'section_no_mb' => true
            //     //     ),
            //     //     'section_index' => false,
            //     //     'section_image_position_right' => false,
            //     // ));    
            //     echo '<h1>Default Quiz intro here</h1>';
            // }

            ?>

		<?php
			while ( have_posts() ) :
				the_post();
				get_template_part( 'loop-templates/content', 'empty' );
			endwhile;
		?>


            </div>
        </div>

	</main><!-- #main -->
</div><!-- #page-wrapper -->


<?php

get_footer('empty');
