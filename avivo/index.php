<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'posts-css', get_template_directory_uri() . '/css/archives.min.css', array(), '1.0', 'all' );

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="index-wrapper">
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

				<?php 
				$archive_subtitle = '';
				$archive_title = '';
				$cat_id = '';

				// if archive is a category archive, get category term title
				if (is_category()) {
					$cat_id = get_query_var('cat');
					$cat = get_category($cat_id);
					// $archive_subtitle = 'BLOG';
					$archive_title = $cat->name;
				} else if (is_home()) {
					$archive_title = 'Blog';
				} else {
					// $archive_title = get_the_archive_title();
				}
				
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
					<div class="container content-container posts-grid">

						<?php
							// Fetch categories
							$categories = get_categories(array(
									'hide_empty' => true, // Only get categories with count > 0
							));

							$active_class = '';

							// Check if there are any categories
							if (!empty($categories)) {
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
								get_template_part( 'loop-templates/content', get_post_format() );
								?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</section>
				<?php
			} else {
				get_template_part( 'loop-templates/content', 'none' );
			}
			?>

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

	<!--	</div> -->
	</main><!-- #main -->
</div><!-- #index-wrapper -->

<?php
get_footer();
