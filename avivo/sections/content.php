<?php 
    $section_content = $section_content ?? false;
    // $section_title = $section_title ? $section_title : false;
    $section_style = $section_style ?? false;
    $section_config = $section_config ?? false;
    
?>

<div class="section-content <?php echo get_section_config_class($section_config); ?> section-content--style-<?php echo $section_style; ?>">
    <div class="container">
        <div class="content__content richtext" data-aos="fade-up" data-aos-delay="200"  data-aos-duration="750">
            <?php echo $section_content; ?>
        </div>

        <?php //echo cd_print_wrap_tags( $section_title,'<h2 class="content__title" data-aos="fade-up" data-aos-delay="100"  data-aos-duration="750">','</h2>' ); ?>

    </div>

</div>