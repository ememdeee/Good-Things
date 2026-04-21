<?php
/**
 * The template for displaying all single posts
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_style( 'posts-css', get_template_directory_uri() . '/css/posts.min.css', array(), '1.0', 'all' );

// // yoast
// function cd_additional_schema_post_data( $data ) {
// 	$data['testing'] = 'this is testing data';
// 	return $data;
// }
// add_filter( 'wpseo_schema_article', 'cd_additional_schema_post_data' );


get_header();

// enqueue /js/sharer.min.js
wp_enqueue_script( 'sharer-js', get_template_directory_uri() . '/js/sharer.min.js', array(), null, true );

$template_style = get_field('template_style') ?? 'regular';

function display_post_tags($tags, $class='article-post__tags') {
	$tags_html = '';
	if ($tags) {
		$tags_html .= '<div class="'. $class .'">';
		$tags_html .= '<h4 class="screen-reader-text">Tags</h4>';
		$tags_html .= '<ul>';
		foreach ($tags as $tag) {
			$tags_html .= '<li>';
			if (!CD_DISABLE_BLOG_ARCHIVES) {
				$tags_html .= '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">';
			} else {
				$tags_html .= '<span>';
			}
			$tags_html .= esc_html($tag->name);
			if (!CD_DISABLE_BLOG_ARCHIVES) {
				$tags_html .= '</a>';
			} else {
				$tags_html .= '</span>';
			}
			$tags_html .= '</li>';
		}
		$tags_html .= '</ul>';
		$tags_html .= '</div>';
	}
	return $tags_html;
}

?>

<!-- --------------------------------------- -->
<div class="wrapper" id="single-wrapper">
	<main class="site-main" id="main">
		<?php
			while ( have_posts() ) :
				the_post(); 
				$tags = get_the_tags();				
				?>

				<article <?php post_class('article-post'); ?> id="post-<?php the_ID(); ?>" >

						<!-- banner -->	
						 <?php /*		
						<section class="section">
							<div class="container">
								<div class="content-container">
									<header class="article-post__header">
										<?php 
												echo cd_title(array(
													'title_text' => get_the_title(),
													'title_subheading' => 'above',
													'title_subheading_text' => '<u>BLOG</u>',
													'title_subheading_size' => 'sm',
												));
												// echo do_shortcode('[heading title="hello world" subheading="above" subheading_text="yes"]');
										?>

										<div class="article-post__meta">									
											<div class="article-post__date">
												<?php understrap_posted_on(); ?>
											</div>

											<div class="article-post__cat">
												<?php echo cd_display_category(true); ?>
											</div>
										</div>

										<?php if ( has_post_thumbnail() ) { ?>
											<div class="article-post__teaser-image">
												<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
											</div>
										<?php	} ?>
									</header>
								</div>
							</div> 
						</section>
						*/ ?>

					

					
					<section class="section spt-lg">
						<div class="container">
							<div class="content-container">
								<div class="article-post__content-group">
									<header class="article-post__header">
										<!-- header -->
										<?php 
												echo cd_title(array(
													'title_text' => get_the_title(),
													'title_subheading' => 'above',
													'title_subheading_text' => '<u>CASE STUDY</u>',
													'title_subheading_size' => 'sm',
												));
												// echo do_shortcode('[heading title="hello world" subheading="above" subheading_text="yes"]');
										?>

										<!--
										<div class="article-post__meta">									
											<div class="article-post__cat">
												<?php // echo cd_display_category(true); ?>

												<?php /*
													$case_study_terms = get_the_terms(get_the_ID(), 'case-study-category');
													$case_study_categories = !empty($case_study_terms) ? reset(wp_list_pluck($case_study_terms, 'name')) : '';
													if (!empty($case_study_categories)) {
														echo '<ul class="cat-links">';
														echo '<li>';
														echo esc_html($case_study_categories);
														echo '</li>';
														echo '</ul>';
													}											
												*/ ?>

											</div>
											<?php /*
											<div class="article-post__date">
												<?php understrap_posted_on(); ?>
											</div>
											*/ ?>
										</div>
										-->

									</header>

									<div class="article-post__main-content">


										<?php if ( has_post_thumbnail() ) { ?>
											<div class="article-post__teaser-image">
												<?php echo get_the_post_thumbnail( $post->ID, 'full' ); ?>
											</div>
										<?php	} ?>


										<?php /*if ( has_excerpt() ) : ?>
											<div class="article-post__excerpt h2">
												<?php echo get_the_excerpt(); ?>
											</div>
										<?php endif;*/ ?>

										<div class="article-post__content">
									
											<?php the_content(); ?>
									
											<?php /*
											wp_link_pages(
												array(
													'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
													'after'  => '</div>',
												)
											); */
											?>

											<?php 
											/*
											if (!CD_DISABLE_BLOG_ARCHIVES) {
												// blog author
												$author_id = get_the_author_meta('ID');
												$author_name = get_the_author_meta('display_name');
												$author_avatar = get_avatar( $author_id, 100 );
												$author_link = get_author_posts_url( $author_id );

												if ( !empty($author_id) ) {
													echo '<div class="article-post__author">';
													echo '<a href="' . $author_link . '" class="article-post__author-link">';
													if ( !empty($author_avatar) ) {
																echo '<div class="article-post__author-avatar">';
																echo $author_avatar;
																echo '</div>';			
													}

													echo '<div class="article-post__author-details">';
													echo '<span class="article-post__author-by">Article by</span>';
													echo '<span class="article-post__author-name">' . $author_name . '</span>';
													echo '</div>';
													echo '</a>';
													echo '</div>';
												}
											}
											*/
											?>
									
										</div><!-- .article-post__content -->												

									</div>	
									<div class="article-post__sidebar">
											<div class="article-post__back">
												<a href="/case-study">
													<svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19 12H5m0 0 4 4m-4-4 4-4" stroke="#5A5A5A" stroke-linecap="round" stroke-linejoin="round"/></svg>
													Back to Case Studies
												</a>
											</div>

											<?php
												// Get the client name and logo
												$client = get_field('case_study_client') ?? '';
												$case_study_industry = get_field('case_study_industry') ?? '';
												$case_study_location = get_field('case_study_location') ?? '';
												// $case_study_logo = get_field('case_study_logo') ?? false;
												// $case_study_logo_white = get_field('case_study_logo_white') ?? false;
												// $case_study_year = get_field('case_study_year') ?? '';
												// $additional_properties = get_field('additional_properties') ?? '';

												if ($client) {
													echo '<div class="article-post__attr">';
													echo '<h4 class="article-post__attr-title">Client</h4>';
													echo '<div class="article-post__attr-value">';
													echo esc_html($client);
													echo '</div>';
													echo '</div>';													
												}

												if ($case_study_industry) {
													echo '<div class="article-post__attr">';
													echo '<h4 class="article-post__attr-title">Industry</h4>';
													echo '<div class="article-post__attr-value">';
													echo esc_html($case_study_industry);
													echo '</div>';
													echo '</div>';
												}

												$case_study_terms = get_the_terms(get_the_ID(), 'case-study-category');
												if (!empty($case_study_terms)) {
													echo '<div class="article-post__attr">';
													echo '<h4 class="article-post__attr-title">Service Type</h4>';
													echo '<div class="article-post__attr-value">';
													echo '<ul>';
													foreach ($case_study_terms as $term) {
														echo '<li>';
														echo esc_html($term->name);
														echo '</li>';
													}
													echo '</ul>';
													echo '</div>';
													echo '</div>';
												}

												if ($case_study_location) {
													echo '<div class="article-post__attr">';
													echo '<h4 class="article-post__attr-title">Location</h4>';
													echo '<div class="article-post__attr-value">';
													echo esc_html($case_study_location);
													echo '</div>';
													echo '</div>';
												}


											?>



											<div class="article-post__share">
												<h4>Share this Article</h4>

												<ul class="article-post__share-buttons">
													<li>
														<button data-sharer="facebook" data-hashtag="hashtag" data-url="<?php echo get_permalink(); ?>">
															<svg width="8" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.496 14.984h2.57V8.723h1.997l.328-2.489H5.066V4.512c0-.383.055-.684.22-.875.163-.219.519-.328 1.01-.328H7.61V1.094a17.272 17.272 0 0 0-1.914-.11c-.984 0-1.75.301-2.324.875-.601.575-.875 1.368-.875 2.407v1.968H.391v2.489h2.105v6.261Z" fill="#1A1A1A"/></svg>
															Share on Facebook
														</button>
													</li>
													<li>
														<button data-sharer="linkedin" data-url="<?php echo get_permalink(); ?>">
														<svg width="14" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.125 14.984V5.641H.219v9.343h2.906ZM1.687 4.36c.438 0 .844-.156 1.188-.5.313-.312.5-.718.5-1.187 0-.438-.188-.844-.5-1.188-.344-.312-.75-.5-1.188-.5-.468 0-.875.188-1.187.5-.344.344-.5.75-.5 1.188 0 .469.156.875.5 1.187.313.344.719.5 1.188.5ZM14 14.984V9.86c0-1.437-.219-2.5-.625-3.187-.563-.844-1.5-1.281-2.844-1.281-.687 0-1.25.187-1.75.5-.469.28-.812.625-1 1.03H7.75v-1.28H4.969v9.343h2.875V10.36c0-.718.093-1.28.312-1.656.25-.5.719-.75 1.406-.75.657 0 1.094.281 1.344.844.125.344.188.875.188 1.625v4.562H14Z" fill="#1A1A1A"/></svg>													
															Share on Linkedin
														</button>
													</li>
													<li>
													<button data-sharer="twitter" data-title="<?php echo get_the_title(); ?>" data-hashtags="" data-url="<?php echo get_permalink(); ?>">
														<svg width="300" height="271" viewBox="0 0 300 271" xmlns="http://www.w3.org/2000/svg"><path d="M236 0h46L181 115l118 156h-92.6l-72.5-94.8-83 94.8h-46l107-123L-1.1 0h94.9l65.5 86.6zm-16.1 244h25.5L80.4 26H53z"/></svg>												
														Share on X
													</button>
													</li>
													<li>
														<button id="copy-link-button">
														<svg width="14" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.647 11.278c0-.228.08-.423.24-.583l1.785-1.784c.16-.16.354-.24.583-.24.24 0 .446.091.618.274l-.163.163a2.525 2.525 0 0 0-.18.18 1.241 1.241 0 0 0-.13.163.584.584 0 0 0-.11.223.73.73 0 0 0-.035.232c0 .229.08.423.24.583.16.16.355.24.583.24.086 0 .166-.008.24-.025a.855.855 0 0 0 .215-.112c.074-.057.129-.1.163-.129l.189-.188.154-.163a.833.833 0 0 1 .283.626c0 .229-.08.423-.24.583l-1.767 1.776a.79.79 0 0 1-.583.232.826.826 0 0 1-.584-.223l-1.26-1.253a.784.784 0 0 1-.24-.575Zm6.03-6.047c0-.23.08-.423.24-.584l1.768-1.775c.16-.16.355-.24.583-.24.223 0 .418.077.584.231l1.26 1.252c.16.16.24.352.24.575 0 .229-.08.423-.24.584l-1.784 1.784a.79.79 0 0 1-.583.232.829.829 0 0 1-.618-.266l.163-.155.19-.189c.028-.034.07-.088.128-.163a.858.858 0 0 0 .111-.214c.018-.074.026-.154.026-.24a.794.794 0 0 0-.24-.584.794.794 0 0 0-.583-.24.73.73 0 0 0-.232.035.584.584 0 0 0-.223.111 1.24 1.24 0 0 0-.163.129 2.526 2.526 0 0 0-.18.18l-.163.163a.832.832 0 0 1-.283-.626ZM.722 9.528c-.48.48-.721 1.064-.721 1.75 0 .687.243 1.267.73 1.742l1.26 1.252a2.369 2.369 0 0 0 1.742.712 2.35 2.35 0 0 0 1.75-.729l1.767-1.776a2.369 2.369 0 0 0 .712-1.74c0-.704-.252-1.302-.755-1.794l.755-.755a2.403 2.403 0 0 0 1.784.755c.686 0 1.27-.24 1.75-.72L13.28 6.44c.48-.48.721-1.063.721-1.75a2.34 2.34 0 0 0-.73-1.741l-1.26-1.253a2.369 2.369 0 0 0-1.742-.712 2.35 2.35 0 0 0-1.75.73L6.751 3.489a2.369 2.369 0 0 0-.712 1.742c0 .703.252 1.3.755 1.793l-.755.754a2.403 2.403 0 0 0-1.784-.754c-.686 0-1.27.24-1.75.72L.72 9.528Z" fill="#1A1A1A"/></svg>													
															Copy Link
														</button>
													</li>
												</ul>

											</div>

											
												<!-- display post tags -->		
												<?php
													echo display_post_tags($tags);
												?>										 								 
											
											

									</div> <!-- .inner-sidebar -->
								</div>
							</div>
						</div> <!-- .container -->
					</section>

					<?php
						// Blog Schema, Only on the website
						if (!is_admin()) {
							// Get content from all ACF blocks
							$article_body = cd_get_acf_block_content(true, 2000);
							$featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

							// Attempt to fetch the excerpt
							$article_excerpt = get_the_excerpt();

							// Fallback to trimmed ACF content if the excerpt is empty
							if (empty($article_excerpt)) {
								$article_excerpt = wp_trim_words($article_body, 50, '...');
							}
						
				// Generate the schema only if there's content
				if (!empty($article_body)) {
					$schema_data = [
						'@context' => 'https://schema.org',
						'@type' => 'Article',
						'name' => get_the_title(),
						'description' => $article_body,
						'datePublished' => get_the_date('c'),
						'dateModified' => get_the_modified_date('c'),
						'author' => [
							'@type' => 'Organization',
							'name' => 'Avivo',
							'url' => 'https://www.avivo.org.au/',
						],
						'publisher' => [
							'@type' => 'Organization',
							'name' => 'Avivo',
							'logo' => [
								'@type' => 'ImageObject',
								'url' => 'https://www.avivo.org.au/wp-content/uploads/2025/05/logo-avivo.png',
							],
						],
						'url' => get_permalink(),
						'image' => $featured_image_url ? [
							'@type' => 'ImageObject',
							'url' => $featured_image_url,
						] : null,
						'mainEntity' => [
							'@type'=> 'WebPage',
							'name' => 'Case Study: ' . $client . ($case_study_categories ? ' - ' . $case_study_categories : ''),
							'about' => !empty($additional_properties) ? $additional_properties : null,
							'dateCompleted' => !empty($case_study_year) ? $case_study_year : null,
						]						
					];

					// Output the JSON-LD schema
					echo '<script type="application/ld+json">' . wp_json_encode($schema_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>';
				}
						}
						

					?>
				
				</article><!-- #post-## -->

				<?php // ClueEdit: revision ?>

				<?php 				

				// current category taxonomy terms
				$categories = get_the_category();
				$cat_ids = array();
				foreach ($categories as $category) {
					$cat_ids[] = $category->term_id;
				}

				// related articles block
				$post_slider_colour = 'light';
				$post_slider_style = 'regular';
				if ($template_style === 'header-overlay') { 
					$post_slider_colour = 'dark';
					$post_slider_style = 'peeking';
				}
				$related_articles = '<!-- wp:acf/post-slider 
					{
						"name": "acf/post-slider",
						"data": {
							"title_text": "Related Articles and News",
							"_title_text": "field_66a7010562271",
							"title_tag": "h2",
							"_title_tag": "field_66a701c59886b",
							"title_size": "default",
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
							"_section_title": "field_66faf47940b46",
							"section_description": "",
							"_section_description": "field_66d51be0a5136",
							"description": "",
							"_description": "field_66faf57940b48",
							"section_categories_filter": ' . json_encode($cat_ids) . ',
							"_section_categories_filter": "field_66fe1447d1f1e",
							"section_slider_style": "'. $post_slider_style .'",
							"_section_slider_style": "field_66fe45008f33f",
							"section_colour": "'. $post_slider_colour .'",
							"_section_colour": "field_66c6e6ad12ae7",
							"colour_scheme": "",
							"_colour_scheme": "field_66faf635fed37",
							"section_padding_top": "spt-md",
							"_section_padding_top": "field_66c6e5fb3b1ef",
							"section_padding_bottom": "spb-md",
							"_section_padding_bottom": "field_66c6e5fb3eb47",
							"section_padding": "",
							"_section_padding": "field_66c6e5fb11aa0",
							"section_margin_top": "smt-no",
							"_section_margin_top": "field_66c6e221d84c0",
							"section_margin_bottom": "smb-no",
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
							"_section_config": "field_66faf45ac7d4e"
						},
						"mode": "preview"
					}					 
					
					/-->';
				
				// echo do_blocks($related_articles);
				
				?>
				
				<?php							

			endwhile;
		?>

		<script>
			document.getElementById('copy-link-button').addEventListener('click', function() {
				const url = "<?php echo get_permalink(); ?>";
				navigator.clipboard.writeText(url).then(function() {
					alert('The link has been successfully copied to your clipboard.');
				}, function(err) {
					console.error('Could not copy text: ', err);
				});
			});
		</script>


	</main><!-- #main -->
</div><!-- #single-wrapper -->
<?php
get_footer();
