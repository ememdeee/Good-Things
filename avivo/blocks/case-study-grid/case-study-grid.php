<?php
//===================================================================
//	Case Study Grid Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/*
	// Get all fields for the current block
	$block_fields = get_fields();

	// Check if fields are available
	if( $block_fields ) {
		echo '<p>Case Study Grid<br />';
		foreach( $block_fields as $field_name => $value ) {
			echo esc_html($field_name) . ': ' . esc_html($value) . ' : ' . gettype($value) . '<br />';
			if (is_array($value)) {
				foreach ($value as $key => $val) {
					echo '- '.$key.' : (' . gettype($val) . ') ' . $val . '<br />';

					if (is_array($val)) {
						foreach ($val as $k => $v) {
							echo '-- '.$k.' : (' . gettype($v) . ') ' . $v . '<br />';

							if (is_array($v)) {
								foreach ($v as $f => $g) {
									echo '-- '.$f.' : (' . gettype($g) . ') ' . $g . '<br />';
								}
							}

						}
					}
				}
			}
		}
		echo '</p>';
	} else {
		echo '<p>No fields found for this block.</p>';
	}
*/
	
	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array

	$section_config['section_colour']	= get_field('section_colour') ?? '';			// string
	
	// Define section element class names
	$section_config['section_classname']			= 'cdb-case_study_grid';		// section block class name

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);

?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
	<div class="container section-container">
		<div class="content-container case-study-grid">

			<div class="case-study-grid__category-nav">
				<ul>
					<li><a class="active" data-group="" href="#">All</a></li>
					<?php
						$terms = get_terms(array(
							'taxonomy' => 'case-study-category',
							'hide_empty' => true,
						));

						if (!is_wp_error($terms) && !empty($terms)) {
							foreach ($terms as $term) {
								echo '<li><a data-group="' . esc_attr($term->slug) . '" href="#">' . esc_html($term->name) . '</a></li>';
							}
						}
					?>
				</ul>
			</div>


		<?php

			// Fetch custom posts
			$args = array(
				'post_type'			=> 'case-study',
				'posts_per_page'	=> -1,
				'orderby'			=> 'menu_order',
				'order'				=> 'ASC', // Or 'DESC' for descending order
			);

			$posts = new WP_Query($args);
			if ($posts->have_posts()) {
				echo '<div class="case-study-grid__shuffle-container">';
				echo '<div class="js-grid case-study-grid__shuffle">';
				$short = true;
				$index = 0;
				while ($posts->have_posts()) {
					$index++;
					// echo '<div class="col-md-6 col-lg-6">';
					$posts->the_post();
					// get_template_part( 'loop-templates/content', get_post_format() );
					// echo '</div>';
					$aspect = ($short) ? 'aspect-short' : '';

					if ($index % 6 == 0) {

					} else {
						$short = !$short;
					}

					// get taxonomy terms of case-study-category
					$terms = get_the_terms( $posts->ID, 'case-study-category' );
					$terms_array = array();
					if ( $terms && ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term ) {
							$terms_array[] = $term->slug;
						}
					}
					$terms_json = json_encode($terms_array);					

					$case_study_client = get_field('case_study_client', get_the_ID()) ?? '';
					$case_study_logo = get_field('case_study_logo', get_the_ID()) ?? false;
					$case_study_cover_image = get_field('case_study_cover_image', get_the_ID()) ?? false;
					$case_study_logo_white = get_field('case_study_logo_white', get_the_ID()) ?? false;

					// var_dump($case_study_cover_image);

					echo '<figure class="case-study-grid__js-item case-study-grid__column" data-groups="'. esc_attr($terms_json) .'">';
					echo 	'<div class="aspect '. $aspect .'">';
					echo 		'<a class="case-study-box" href="'. esc_url( get_permalink() ) .'">';
					echo 			'<span class="case-study-box__img">';
					if ($case_study_cover_image) {
						echo wp_get_attachment_image($case_study_cover_image, 'full');
					} else {
						echo get_the_post_thumbnail(get_the_ID(), 'full');
					}
					echo			'</span>'; 
					echo 			'<span class="case-study-box__content">'; 
					echo 				'<span class="case-study-box__logo">';
					// echo 					'<img alt="'. $case_study_client .'" src="" />';
					if ($case_study_logo_white) {
						echo 					wp_get_attachment_image($case_study_logo_white, 'full', false, array('class' => 'logo-white'));
					} else {
						echo 					wp_get_attachment_image($case_study_logo, 'full', false, array('class' => 'logo-original'));
					}
					echo				'</span>';
					echo 				'<span class="case-study-box__sub-heading">'. $case_study_client .'</span>'; 
					// echo 				'<span class="heading">'.  .'</span>';
					// echo 				get_the_title('<span class="heading">','</span>');			
					echo 				cd_print_wrap_tags( get_the_title(get_the_ID()),'<span class="case-study-box__heading">','</span>' );
					echo 				'<span class="case-study-box__arrow"><span class="link-text">View Case Study</span></span>';
					echo 			'</span>'; 
					echo 		'</a>';
					echo 	'</div>';
					echo '</figure>';
				}
				echo '<div class="case-study-grid__column my-sizer-element">&nbsp;</div>';
				echo '</div>';
				echo '</div>';
			}
		?>
		</div>
	</div>
</section>
<?php
