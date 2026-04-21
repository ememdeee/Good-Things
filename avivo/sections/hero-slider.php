<?php 
    $section_slides = $section_slides ?? false;
    $section_index = $section_index ?? false;
?>
<?php if( $section_slides ): ?>
<div class="section-hero-slider hero-slider <?php echo get_section_config_class($section_config); ?>">
    <section class="slider-main">
        <?php foreach( $section_slides as $section_slide ) {
            $slide_image = $section_slide['slide_image'] ?? false;
            $slide_title = $section_slide['slide_title'] ?? false;
            $slide_description = $section_slide['slide_description'] ?? false;
            $slide_button = $section_slide['slide_button'] ?? false;    
            $slide_button2 = $section_slide['slide_button2'] ?? false;    

            $has_button = $slide_button && $slide_button['button_text'];
            $has_button2 = $slide_button2 && $slide_button2['button_text'];
        ?>

            <div class="hero-slide">
                <div class="hero-slide__img">
                    <?= wp_get_attachment_image($slide_image, "full", false, ["class" => ""]); ?>
                </div>
                <div class="hero-slide__content container">
                    <div class="hero-slide__text">
                        <h3 class="hero-slide__title h2">
                            <?php echo $slide_title; ?>
                        </h3>
                        <?php if ($slide_description) { ?>
                            <p class="hero-slide__description">
                                <?php echo cd_print_text($slide_description); ?>
                            </p>
                        <?php } ?>

                        <?php if ($has_button || $has_button2) {
                            echo '<div class="hero-slider__buttons">';

                            if ($has_button) :
                                // $slide_button['button_additional_classes'] = 'btn-sm';
                                    cd_render('snippets/button.php', $slide_button);
                            endif;

                            if ($has_button2) :
                                // $slide_button2['button_additional_classes'] = 'btn-sm';
                                    cd_render('snippets/button.php', $slide_button2);
                            endif;


                            echo '</div>';
                        }
                        ?>



                    </div>
                </div>                            

                                    
            </div>
        <?php } ?>
    </section>
    
    <div class="hero-slider__nav">
        <div class="container">
            <div class="hero-slider__navs">
                <div class="hero-slider__pager"></div>
                <div class="hero-slider__arrows"></div>
            </div>

            <?php /*
            <div class="progressBarContainer">
                <?php for ($i=0; $i<count($section_slides); $i++) { ?>
                    <div class="item">
                        <h3>Slide <?php echo ($i+1); ?></h3>
                        <span data-slick-index="<?php echo $i; ?>" class="progressBar"></span>
                    </div>

                <?php }?>
                <!-- <div class="item">
                <h3>Slide 1</h3>
                <span data-slick-index="0" class="progressBar"></span>
                </div>
                <div class="item">
                <h3>Slide 2</h3>
                <span data-slick-index="1" class="progressBar"></span>
                </div>
                <div class="item">
                <h3>Slide 3</h3>
                <span data-slick-index="2" class="progressBar"></span>
                </div> -->
            </div>
            */ ?>

        </div>
    </div>


                
                

</div><!-- /.block -->

<?php endif; ?>
