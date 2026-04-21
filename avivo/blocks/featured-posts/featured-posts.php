<?php
//===================================================================
//	Featured Post Block
//	Custom Section Block using ACF
//===================================================================
	
  $section_posts_selection = get_field('section_posts_selection') ?? 'latest';
  $section_posts = get_field('section_posts') ?? false;

	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array

	// $section_config['section_colour']	= get_field('section_colour') ?? '';			// string
	
	// Default values
	$default_title	= 'Featured Posts';
	$default_desc	= 'This is the placeholder for featured post.';

	// Define section element class names
	$section_config['section_classname']			= 'cdb-featured_posts';		// section block class name

	$post_per_page = 3;

  $selection_posts_ids = array();
  if ($section_posts_selection === 'custom' && is_array($section_posts)) {
    // $section_posts is array of array of post IDs, convert to single array
    $selection_posts_ids = array_map(function($item) {
      return $item['post_post'];
    }, $section_posts);    
  }

	// for front end
	/*if (!is_admin()) {*/

		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);

?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> >
	<div class="container section-container">
		<div class="content-container featured-posts">
      <?php 
        // var_dump($section_posts_selection);
        // var_dump($section_posts);
        // var_dump($selection_posts_ids);
      ?>
				<?php

          // Fetch custom posts
          if ($section_posts_selection === 'custom') {
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => $post_per_page,//-1,
              'post_status' => 'publish',
              // only include specific post IDs
              'post__in' => $selection_posts_ids,
              'orderby' => 'post__in',
              'ignore_sticky_posts' => 1,
            );            
            } else if ($section_posts_selection === 'sticky') {
              if (!empty(get_option('sticky_posts'))) {
                $args = array(
                  'post_type' => 'post',
                  'posts_per_page' => -1, // no limit for sticky posts
                  'post_status' => 'publish',
                  'post__in' => get_option('sticky_posts'),
                );    
              } else {
                // no sticky posts
                $args = array(
                  'post_type' => 'post',
                  'posts_per_page' => 0,
                  'post_status' => 'publish',
                  'ignore_sticky_posts' => 1,
                );
              }
          } else {
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => $post_per_page,//-1,
              'post_status' => 'publish',
              'ignore_sticky_posts' => 1,
            );
          }

					$posts = new WP_Query($args);
					if ($posts->have_posts()) {
            ?>
            <div class="featured-posts__posts" data-post-count="<?php echo $posts->post_count; ?>">
              <?php
              while ($posts->have_posts()) {
                echo '<div class="featured-posts__col">';
                $posts->the_post();
                // get_template_part( 'loop-templates/content', get_post_format() );
                ?>

                <div class="featured-post-card">
                  <div class="featured-card__img-wrapper">
                      <?php 
                        if (has_post_thumbnail()) {
                          echo get_the_post_thumbnail( get_the_ID(), 'full', array(  ) ); 
                        } else {
                          // TODO: default image?
                        }
                      ?>
                  </div>
                  <a href="<?php echo esc_url( get_permalink() ); ?>" class="featured-post-card__link"></a>
                  
                  <div class="featured-post-card__content">
                    <?php
                    the_title(
                      '<h2 class="featured-post-card__title h2">',
                      '</h2>'
                    );
                    ?>
                    <div class="featured-post-card__meta">
                      <div class="featured-post-card__cat">
                        <?php echo cd_display_category(true); ?>
                      </div>
                      <?php if ( 'post' === get_post_type() ) { ?>
                        <div class="featured-post-card__date">
                          | &nbsp; <?php understrap_posted_on(); ?>
                        </div>
                      <?php }  ?>
                    </div>
                  </div>


                </div>

                <?php
                echo '</div>';
              }
              ?>
            </div>
            <?php
					} else {
						// echo '<p>No posts found.</p>';
					}

					wp_reset_postdata();
				?>

		</div>
	</div>
</section>
<?php
	/*} else { 
	// this part is for the block added to the editor, still empty
?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
	<div class="container section-container">
		<div class="content-container">
		<?php
			echo cd_title(array(
				'title_text'		=> $default_title,
				'title_tag'			=> 'h3',
			//	'title_alignment'	=> 'center',
			));
			echo cd_print_richtext( $default_desc,'<div class="content__description">','</div>' );
		?>
		</div>
	</div>
</section>
<?php }*/ ?>