<?php
/**
 * The template for displaying the author pages
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'posts-css', get_template_directory_uri() . '/css/archives.min.css', array(), '1.0', 'all' );

get_header();

?>

<div class="wrapper" id="author-wrapper">

	<!-- <div class="" id="content" tabindex="-1"> -->

		<!-- <div class="row"> -->

			<!-- Do the left sidebar check -->
			<?php //get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php
				if ( get_query_var( 'author_name' ) ) {
					$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
				} else {
					$curauth = get_userdata( intval( $author ) );
				}
				?>


				<?php /*
				<header class="page-header author-header">
					<?php
					if ( ! empty( $curauth->ID ) ) {
						echo get_avatar( $curauth->ID );
					}
					?>

					<?php if ( ! empty( $curauth->user_url ) || ! empty( $curauth->user_description ) ) : ?>
						<dl>
							<?php if ( ! empty( $curauth->user_url ) ) : ?>
								<dt><?php esc_html_e( 'Website', 'understrap' ); ?></dt>
								<dd>
									<a href="<?php echo esc_url( $curauth->user_url ); ?>"><?php echo esc_html( $curauth->user_url ); ?></a>
								</dd>
							<?php endif; ?>

							<?php if ( ! empty( $curauth->user_description ) ) : ?>
								<dt><?php esc_html_e( 'Profile', 'understrap' ); ?></dt>
								<dd><?php echo esc_html( $curauth->user_description ); ?></dd>
							<?php endif; ?>
						</dl>
					<?php endif; ?>

					<h2><?php echo esc_html__( 'Posts by', 'understrap' ) . ' ' . esc_html( $curauth->nickname ); ?>:</h2>

				</header><!-- .page-header -->
				*/ ?>

				<?php
				$name = trim($curauth->first_name . ' ' . $curauth->last_name);
				if (empty($name)) {
					$name = $curauth->nickname;
				}

				$title_text = 'About ' . $name;
				$description = $curauth->description;

				// $avatar_url = get_avatar_url( $curauth->ID );
				// var_dump($avatar_url);

				// if ( ! empty( $curauth->ID ) ) {
				// 	echo get_avatar( $curauth->ID );
				// }

				$page_title = '<!-- wp:acf/page-title-banner				
					{
						"name": "acf/page-title-banner",
						"data": {
							"section_breadcrumbs": "0",
							"_section_breadcrumbs": "field_66d6c2ccd8d98",
							"title_text": "'. $title_text .'",
							"_title_text": "field_66a7010562271",
							"title_tag": "h2",
							"_title_tag": "field_66a701c59886b",
							"title_size": "h1",
							"_title_size": "field_66a70105682e7",
							"title_alignment": "left",
							"_title_alignment": "field_66a7010571046",
							"title_subheading": "above",
							"_title_subheading": "field_66a702179886c",
							"title_subheading_text": "",
							"_title_subheading_text": "field_66a7024b9886d",
							"title_subheading_tag": "div",
							"_title_subheading_tag": "field_66a9ed1452b22",
							"title_subheading_size": "default",
							"_title_subheading_size": "field_66a70291b848a",
							"section_title": "",
							"_section_title": "field_66d6c1e72303f",
							"section_description": "'. $description .'",
							"_section_description": "field_66d51be0a5136",
							"description": "",
							"_description": "field_66d6c1e726ba4",
							"section_buttons_alignment": "left",
							"_section_buttons_alignment": "field_66aae8e83b757",
							"section_buttons": "",
							"_section_buttons": "field_66a84533f40ea",
							"section_button_row": "",
							"_section_button_row": "field_66d6c1e72e314",
							"image_desktop": "",
							"_image_desktop": "field_66d549f2ea43a",
							"image_mobile": "",
							"_image_mobile": "field_66d54aa363f74",
							"image_opacity": "0",
							"_image_opacity": "field_66d549f30121c",
							"section_image": "",
							"_section_image": "field_66d6c1e7358f7",
							"section_colour": "default",
							"_section_colour": "field_66c6e6ad12ae7",
							"colour_scheme": "",
							"_colour_scheme": "field_66d6c1e73cebd",
							"section_height": "0",
							"_section_height": "field_66d5b06deef1a",
							"height": "",
							"_height": "field_66e8d586e8b9f",
							"section_content_width": "compact",
							"_section_content_width": "field_66e8d1b086bc0",
							"content_width": "",
							"_content_width": "field_66e8d58de8ba0",
							"section_content_position": "left",
							"_section_content_position": "field_66e8d327a44b7",
							"content_position": "",
							"_content_position": "field_66e8d590e8ba1",
							"section_padding_top": "spt-lg",
							"_section_padding_top": "field_66c6e5fb3b1ef",
							"section_padding_bottom": "spb-no",
							"_section_padding_bottom": "field_66c6e5fb3eb47",
							"section_padding": "",
							"_section_padding": "field_66c6e5fb11aa0",
							"padding": "",
							"_padding": "field_66d6c1e744464",
							"section_margin_top": "smt-no",
							"_section_margin_top": "field_66c6e221d84c0",
							"section_margin_bottom": "smb-no",
							"_section_margin_bottom": "field_66c6e221dbf6e",
							"section_margin": "",
							"_section_margin": "field_66c6e221baaf9",
							"margin": "",
							"_margin": "field_66d6c1e7481a7",
							"section_border_top": "0",
							"_section_border_top": "field_66d53488add3c",
							"section_border_bottom": "0",
							"_section_border_bottom": "field_66d53488b0bf1",
							"section_border_left": "0",
							"_section_border_left": "field_66d534abd0ef1",
							"section_border_right": "0",
							"_section_border_right": "field_66d5352ed0ef2",
							"section_border": "",
							"_section_border": "field_66d53488a5f1b",
							"border": "",
							"_border": "field_66d6c1e74bba3",
							"section_id": "",
							"_section_id": "field_66c6eb72920f7",
							"section_class": "",
							"_section_class": "field_66c6eb7295370",
							"section_custom_css": "",
							"_section_custom_css": "field_66c6eb7298eea",
							"advanced": "",
							"_advanced": "field_66d6c1e74f727"
						},
						"mode": "preview"
					}				
				
				/-->';
				
				echo do_blocks($page_title);


				?>

				<section class="section cdb-author">
					<div class="container content-container post-grid">


						<!-- The Loop -->
						<?php
						if ( have_posts() ) { ?>
							<div class="row post-grid__posts">

								<?php /*
								echo '<ul>';
								while ( have_posts() ) {
									the_post();
									echo '<li>';
										printf(
											'<a rel="bookmark" href="%1$s" title="%2$s %3$s">%3$s</a>',
											esc_url( apply_filters( 'the_permalink', get_permalink( $post ), $post ) ),
											esc_attr( __( 'Permanent Link:', 'understrap' ) ),
											get_the_title()
										);
										understrap_posted_on();
										esc_html_e( 'in', 'understrap' );
										the_category( '&' );
									echo '</li>';
								}
								echo '</ul>';
								*/ ?>

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
							<!-- The pagination component -->
							<?php understrap_pagination(); ?>


						<?php } else {
							get_template_part( 'loop-templates/content', 'none' );
						}
						?>
						<!-- End Loop -->


					</div>
				</section>


			</main><!-- #main -->


			<!-- Do the right sidebar check -->
			<?php //get_template_part( 'global-templates/right-sidebar-check' ); ?>

		<!--</div>--> <!-- .row -->

	<!--</div>--><!-- #content -->

</div><!-- #author-wrapper -->

<?php
get_footer();
