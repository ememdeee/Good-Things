<?php
/**
 * The template for displaying archive pages
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'posts-css', get_template_directory_uri() . '/css/archives.min.css', array(), '1.0', 'all' );

get_header();

?>

<div class="wrapper" id="archive-wrapper">
	<main class="site-main" id="main">

	<!--	<div class="container"> -->

			<?php 
			// Sidebar news top
			if (is_active_sidebar( 'sidebar-news-top' )) { ?>
				<div class="sidebar-news-top">
					<?php dynamic_sidebar( 'sidebar-news-top' ); ?>
				</div>
			<?php } ?>
		
			<?php
			if ( have_posts() ) {
				// Start the Loop.
				?>


				<?php /*

				<!-- blog banner -->
				<section class="section cdb-page_title_banner">
				<!--	<picture class="cdb-bgimage page_title_banner__bgimage" style="opacity: 0.4;"><source srcset="https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1.jpg 1600w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-300x169.jpg 300w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-1024x576.jpg 1024w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-768x432.jpg 768w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-1536x864.jpg 1536w" media="(min-width: 768px)"><img decoding="async" src="https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1.jpg" srcset="https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1.jpg 1600w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-300x169.jpg 300w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-1024x576.jpg 1024w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-768x432.jpg 768w, https://clue.flywheelsites.com/wp-content/uploads/2024/09/photo-1-1536x864.jpg 1536w" data-imagesize="full"></picture>	<div class="container section-container">
			-->		<div class="container content-container">
							<p>&nbsp;</p>
							<p>&nbsp;</p>
							<div class="title_wrapper page_title_banner__title">
								<div class="subtitle">BLOG</div>
								<h2 class="title">Our thoughts, news and actionable advice for growth.</h2></div><div class="content__description"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
							</div><div class="btn-row page_title_banner__cta"><a href="" class="btn light"><span class="link-text">Let’s Chat</span></a></div>
						</div>
					</div>
				</section>

				*/ ?>

				<?php 

				$archive_subtitle = '';
				$archive_title = '';
				$cat_id = '';

				// if archive is a category archive, get category term title
				if (is_category()) {
					$cat_id = get_query_var('cat');
					$cat = get_category($cat_id);
					$archive_subtitle = 'BLOG';
					$archive_title = $cat->name;
				} else {
					$archive_title = get_the_archive_title();
				}
				
				// var_dump($archive_subtitle);

				// $page_title = '<!-- wp:acf/page-title-banner				
				// 	{
				// 		"name": "acf/page-title-banner",
				// 		"data": {
				// 			"section_breadcrumbs": "0",
				// 			"_section_breadcrumbs": "field_66d6c2ccd8d98",
				// 			"title_text": "'. $archive_title .'",
				// 			"_title_text": "field_66a7010562271",
				// 			"title_tag": "h2",
				// 			"_title_tag": "field_66a701c59886b",
				// 			"title_size": "h1",
				// 			"_title_size": "field_66a70105682e7",
				// 			"title_alignment": "left",
				// 			"_title_alignment": "field_66a7010571046",
				// 			"title_subheading": "above",
				// 			"_title_subheading": "field_66a702179886c",
				// 			"title_subheading_text": "\u003cU\u003e'. $archive_subtitle .'\u003c/U\u003e",
				// 			"_title_subheading_text": "field_66a7024b9886d",
				// 			"title_subheading_tag": "div",
				// 			"_title_subheading_tag": "field_66a9ed1452b22",
				// 			"title_subheading_size": "default",
				// 			"_title_subheading_size": "field_66a70291b848a",
				// 			"section_title": "",
				// 			"_section_title": "field_66d6c1e72303f",
				// 			"section_description": "",
				// 			"_section_description": "field_66d51be0a5136",
				// 			"description": "",
				// 			"_description": "field_66d6c1e726ba4",
				// 			"section_buttons_alignment": "left",
				// 			"_section_buttons_alignment": "field_66aae8e83b757",
				// 			"section_buttons": "",
				// 			"_section_buttons": "field_66a84533f40ea",
				// 			"section_button_row": "",
				// 			"_section_button_row": "field_66d6c1e72e314",
				// 			"image_desktop": "",
				// 			"_image_desktop": "field_66d549f2ea43a",
				// 			"image_mobile": "",
				// 			"_image_mobile": "field_66d54aa363f74",
				// 			"image_opacity": "0",
				// 			"_image_opacity": "field_66d549f30121c",
				// 			"section_image": "",
				// 			"_section_image": "field_66d6c1e7358f7",
				// 			"section_colour": "default",
				// 			"_section_colour": "field_66c6e6ad12ae7",
				// 			"colour_scheme": "",
				// 			"_colour_scheme": "field_66d6c1e73cebd",
				// 			"section_height": "0",
				// 			"_section_height": "field_66d5b06deef1a",
				// 			"height": "",
				// 			"_height": "field_66e8d586e8b9f",
				// 			"section_content_width": "compact",
				// 			"_section_content_width": "field_66e8d1b086bc0",
				// 			"content_width": "",
				// 			"_content_width": "field_66e8d58de8ba0",
				// 			"section_content_position": "left",
				// 			"_section_content_position": "field_66e8d327a44b7",
				// 			"content_position": "",
				// 			"_content_position": "field_66e8d590e8ba1",
				// 			"section_padding_top": "spt-lg",
				// 			"_section_padding_top": "field_66c6e5fb3b1ef",
				// 			"section_padding_bottom": "spb-no",
				// 			"_section_padding_bottom": "field_66c6e5fb3eb47",
				// 			"section_padding": "",
				// 			"_section_padding": "field_66c6e5fb11aa0",
				// 			"padding": "",
				// 			"_padding": "field_66d6c1e744464",
				// 			"section_margin_top": "smt-no",
				// 			"_section_margin_top": "field_66c6e221d84c0",
				// 			"section_margin_bottom": "smb-no",
				// 			"_section_margin_bottom": "field_66c6e221dbf6e",
				// 			"section_margin": "",
				// 			"_section_margin": "field_66c6e221baaf9",
				// 			"margin": "",
				// 			"_margin": "field_66d6c1e7481a7",
				// 			"section_border_top": "0",
				// 			"_section_border_top": "field_66d53488add3c",
				// 			"section_border_bottom": "0",
				// 			"_section_border_bottom": "field_66d53488b0bf1",
				// 			"section_border_left": "0",
				// 			"_section_border_left": "field_66d534abd0ef1",
				// 			"section_border_right": "0",
				// 			"_section_border_right": "field_66d5352ed0ef2",
				// 			"section_border": "",
				// 			"_section_border": "field_66d53488a5f1b",
				// 			"border": "",
				// 			"_border": "field_66d6c1e74bba3",
				// 			"section_id": "",
				// 			"_section_id": "field_66c6eb72920f7",
				// 			"section_class": "",
				// 			"_section_class": "field_66c6eb7295370",
				// 			"section_custom_css": "",
				// 			"_section_custom_css": "field_66c6eb7298eea",
				// 			"advanced": "",
				// 			"_advanced": "field_66d6c1e74f727"
				// 		},
				// 		"mode": "preview"
				// 	}				
				
				// /-->';
				
				$page_title = '<!-- wp:acf/hero-animation {
						"name": "acf/hero-animation",
						"data": {
							"section_breadcrumbs": "1",
							"_section_breadcrumbs": "field_689ab27d0754f",
							"title_text": "' . $archive_title . '",
							"_title_text": "field_66a7010562271",
							"title_tag": "h1",
							"_title_tag": "field_66a701c59886b",
							"title_size": "default",
							"_title_size": "field_66a70105682e7",
							"title_alignment": "left",
							"_title_alignment": "field_66a7010571046",
							"title_subheading": "above",
							"_title_subheading": "field_66a702179886c",
							"title_subheading_text": "",
							"_title_subheading_text": "field_66a7024b9886d",
							"title_subheading_tag": "h2",
							"_title_subheading_tag": "field_66a9ed1452b22",
							"title_subheading_size": "default",
							"_title_subheading_size": "field_66a70291b848a",
							"title_subheading_icon": "",
							"_title_subheading_icon": "field_673ab8d587b1c",
							"title_subheading_icon_location": "0",
							"_title_subheading_icon_location": "field_674e97338af6d",
							"section_title": "",
							"_section_title": "field_68737d87c2910",
							"section_description": "",
							"_section_description": "field_66d51be0a5136",
							"description": "",
							"_description": "field_68737d87c65e7",
							"section_buttons_alignment": "left",
							"_section_buttons_alignment": "field_66aae8e83b757",
							"section_buttons": "",
							"_section_buttons": "field_66a84533f40ea",
							"section_button_row": "",
							"_section_button_row": "field_68737d87cf98e",
							"section_curve_image": "",
							"_section_curve_image": "field_68737efa5971c",
							"section_curve_style": "curve7",
							"_section_curve_style": "field_68737d87db14c",
							"section_curve_size": "default",
							"_section_curve_size": "field_68ee4fdc8cada",
							"section_colour": "lightgrey",
							"_section_colour": "field_66c6e6ad12ae7",
							"colour_scheme": "",
							"_colour_scheme": "field_689ab4842538b",
							"section_content_width": "default",
							"_section_content_width": "field_66e8d1b086bc0",
							"content_width": "",
							"_content_width": "field_68737d87dee48",
							"section_padding_top": "spt-sm",
							"_section_padding_top": "field_66c6e5fb3b1ef",
							"section_padding_bottom": "spb-md",
							"_section_padding_bottom": "field_66c6e5fb3eb47",
							"section_padding": "",
							"_section_padding": "field_66c6e5fb11aa0",
							"section_margin_top": "smt-no",
							"_section_margin_top": "field_66c6e221d84c0",
							"section_margin_bottom": "smb-lg",
							"_section_margin_bottom": "field_66c6e221dbf6e",
							"section_margin": "",
							"_section_margin": "field_66c6e221baaf9",
							"section_border_top": "0",
							"_section_border_top": "field_66c6e62dd8c00",
							"section_border_bottom": "0",
							"_section_border_bottom": "field_66c6e62ddc5cc",
							"section_border": "",
							"_section_border": "field_66c6e62d9cb57",
							"section_id": "",
							"_section_id": "field_66c6eb72920f7",
							"section_class": "",
							"_section_class": "field_66c6eb7295370",
							"section_custom_css": "",
							"_section_custom_css": "field_66c6eb7298eea",
							"section_config": "",
							"_section_config": "field_68737d87e43da"
						},
						"mode": "preview"
					} /-->	';

				echo do_blocks($page_title);

				?>



				<!-- blog posts -->
				<section class="section cdb-blog spt-no">
					<div class="container content-container post-grid">

						<?php
							// Fetch categories
							$categories = get_categories(array(
									'hide_empty' => true, // Only get categories with count > 0
							));

							$active_class = '';

							// Check if there are any categories
							if (get_post_type() === 'post' && !empty($categories)) {
									echo '<div class="post-grid__categories-wrapper smb-md">';
									echo '<h3 class="screen-reader-text">Categories</h3>';
									echo '<ul class="post-grid__categories h6">';
									echo '<li><a href="/blog">All</a></li>';

									foreach ($categories as $category) {
											$link = esc_url(get_category_link($category->term_id));
											if ($cat_id == $category->term_id) {
												$active_class = 'active';
											} else {
												$active_class = '';
											}
											echo '<li>';
											echo '<a href="' . $link . '" data-category="'. $category->slug .'" class="'.$active_class.'">' . esc_html($category->name) /*. ' (' . esc_html($category->count)*/ . '</a>';
											echo '</li>';
									}
									echo '</ul>';
									echo '</div>';
							} else if (is_post_type_archive('case-study') || is_tax('case-study-category')) {
									// For case studies, we can fetch categories from the 'case-study-category' taxonomy
									$terms = get_terms(array(
										'taxonomy' => 'case-study-category',
										'hide_empty' => true,
									));

									if (!is_wp_error($terms) && !empty($terms)) {
										echo '<div class="post-grid__categories-wrapper smb-md">';
										echo '<h3 class="screen-reader-text">Categories</h3>';
										echo '<ul class="post-grid__categories h6">';
										echo '<li><a href="/case-study">All</a></li>';

										if (is_tax('case-study-category')) {
											$current_term = get_queried_object();
											$cat_id = $current_term ? $current_term->term_id : '';
										}
										foreach ($terms as $term) {
											$link = esc_url(get_term_link($term));

											if (is_tax('case-study-category')) {
												if ($cat_id == $term->term_id) {
													$active_class = 'active';
												} else {
													$active_class = '';
												}
											}
											echo '<li>';
											echo '<a href="' . $link . '" data-category="'. $term->slug .'" class="'.$active_class.'">' . esc_html($term->name) /*. ' (' . esc_html($term->count)*/ . '</a>';
											echo '</li>';
										}
										echo '</ul>';
										echo '</div>';
									}
							} else {
									// echo '<p>No categories found.</p>';
							}
						?>			


						<div class="row post-grid__posts">
							<?php
							while ( have_posts() ) {
								?>
								<div class="col-md-6 col-lg-4">
								<?php		
								the_post();

								/*
									* Include the Post-Format-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Format name) and that will be used instead.
									*/
								if (is_post_type_archive('case-study')) {
									get_template_part( 'loop-templates/content', 'case-study' );
								} else {
									get_template_part( 'loop-templates/content', get_post_format() );
								}
								?>
								</div>
								<?php
							}
							?>
						</div>

						<!-- The pagination component -->
						<?php understrap_pagination(); ?>

					</div>
				</section>
				<?php
			} else {
				get_template_part( 'loop-templates/content', 'none' );
			}
			?>


	<!--	</div> -->
	</main><!-- #main -->
</div><!-- #archive-wrapper -->

<?php
get_footer();
