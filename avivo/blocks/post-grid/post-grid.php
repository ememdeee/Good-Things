<?php
//===================================================================
//	Post Grid Block
//	Custom Section Block using ACF
//===================================================================

/*
	// Get all fields for the current block
	$block_fields = get_fields();

	// Check if fields are available
	if( $block_fields ) {
		echo '<p>Post Grid<br />';
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
	
	// function enqueue_load_more_scripts() {
	// 	// wp_enqueue_script('load-more', get_template_directory_uri() . 'blocks/post-grid/js/post-grid-load-more.js', array(), null, true);

	// 	// wp_localize_script('load-more', 'load_more_params', array(
	// 	// 		'ajaxurl' => admin_url('admin-ajax.php'),
	// 	// 		'posts_per_page' => 12,
	// 	// ));
	// }
	// add_action('wp_enqueue_scripts', 'enqueue_load_more_scripts');	


	$section_posts_exclusion = get_field('section_posts_exclusion') ?? '';

	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array

	$section_config['section_colour']	= get_field('section_colour') ?? '';			// string
	
	// Default values
	$default_title	= 'Blog';
	$default_desc	= 'This is the placeholder for post grid.';

	// Define section element class names
	$section_config['section_classname']			= 'cdb-post_grid';		// section block class name

	$post_per_page = 12;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$use_ajax = false;

	// for front end
	// if (!is_admin()) {

		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);

?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>" data-post-per-page="<?php echo $post_per_page; ?>" data-category="all" data-use-ajax="<?php echo $use_ajax ? 'true' : 'false'; ?>">
	<div class="container section-container">
		<div class="content-container post-grid">
			<?php //echo 'pages = ' . $paged; ?>
			
			<?php
				if (!CD_DISABLE_BLOG_ARCHIVES) {
					// Fetch categories
					$categories = get_categories(array(
							'hide_empty' => true, // Only get categories with count > 0
					));

					// Check if there are any categories
					if (!empty($categories)) {
							echo '<div class="post-grid__categories-wrapper smb-md">';
							echo '<h3 class="screen-reader-text">Categories</h3>';
							echo '<ul class="post-grid__categories">';
							if ($use_ajax) {
								echo '<li><a href="" data-category="" class="active">All</a></li>';
							} else {
								echo '<li><a href="/blog" class="active">All</a></li>';
							}

							foreach ($categories as $category) {
									if ($use_ajax) {
										$link = '';
									} else {
										$link = esc_url(get_category_link($category->term_id));
									}
									echo '<li>';
									echo '<a href="' . $link . '" data-category="'. $category->slug .'">' . esc_html($category->name) /*. ' (' . esc_html($category->count)*/ . '</a>';
									echo '</li>';
							}
							echo '</ul>';
							echo '</div>';
					} else {
							// echo '<p>No categories found.</p>';
					}
				}
			?>			


				<?php

					// Fetch custom posts
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => $post_per_page,//-1,
						'post_status' => 'publish',
						'paged' => $use_ajax?1:$paged,
					);

					if ($section_posts_exclusion === 'sticky') {
						$args['post__not_in'] = get_option('sticky_posts');
					}

					$posts = new WP_Query($args);
					if ($posts->have_posts()) {
						?>
						<div class="row post-grid__posts" data-post-count="<?php echo $posts->post_count; ?>">
							<?php
							while ($posts->have_posts()) {
								echo '<div class="col-md-6 col-lg-4">';
								$posts->the_post();
								get_template_part( 'loop-templates/content', get_post_format() );
								echo '</div>';
							}
							?>
						</div>
						<?php
					} else {
						echo '<p>No posts found.</p>';
					}


					understrap_pagination();

					wp_reset_postdata();
				?>


			<?php 						

			if (!$use_ajax && $posts->max_num_pages > 1) {
				// echo '<div class="post-grid__pager">';
				// echo paginate_links(array(
				// 	'total' => $posts->max_num_pages,
				// 	'current' => $paged,
				// 	'format' => 'page/%#%',
				// 	'show_all' => false,
				// 	'type' => 'plain',
				// 	'end_size' => 2,
				// 	'mid_size' => 1,
				// 	'prev_next' => true,
				// 	'prev_text' => '<span class="btn hollow">' . __('« Prev') . '</span>',
				// 	'next_text' => '<span class="btn hollow">' . __('Next »') . '</span>',
				// 	'add_args' => false,
				// 	'add_fragment' => '',
				// 	'before_page_number' => '<span class="btn hollow">',
				// 	'after_page_number' => '</span>',
				// ));
				// echo '</div>';

				// similar to understrap_pagination()
				$args = wp_parse_args(
					$args,
					array(
						'total' => $posts->max_num_pages,
						'current' => $paged,
						'mid_size'           => 2,
						'prev_next'          => true,
						'prev_text'          => __( '&laquo;', 'understrap' ),
						'next_text'          => __( '&raquo;', 'understrap' ),
						'type'               => 'array',
						// 'current'            => max( 1, get_query_var( 'paged' ) ),
						'screen_reader_text' => __( 'Posts navigation', 'understrap' ),
					)
				);
		
				$links = paginate_links( $args );
				if ( ! $links ) {
					return;
				}
		
				?>
		
				<div class="post-grid__loader" style="display: none;">
					<svg width="38" height="38" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient x1="8.042%" y1="0%" x2="65.682%" y2="23.865%" id="a"><stop stop-color="#000" stop-opacity="0" offset="0%"/><stop stop-color="#000" stop-opacity=".631" offset="63.146%"/><stop stop-color="#000" offset="100%"/></linearGradient></defs><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><path d="M36 18c0-9.94-8.06-18-18-18" stroke="url(#a)" stroke-width="2"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite"/></path><circle fill="#000" cx="36" cy="18" r="1"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite"/></circle></g></svg>					
				</div>


				<nav aria-labelledby="posts-nav-label" class="pagination-wrapper">
		
					<h2 id="posts-nav-label" class="visually-hidden">
						<?php echo esc_html( $args['screen_reader_text'] ); ?>
					</h2>
		
					<ul class="<?php echo esc_attr( 'pagination' ); ?>">
		
						<?php
						foreach ( $links as $key => $link ) {
							?>
							<li class="page-item <?php echo strpos( $link, 'current' ) ? 'active' : ''; ?>">
								<?php echo str_replace( 'page-numbers', 'page-link', $link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</li>
							<?php
						}
						?>
		
					</ul>
		
				</nav>

				<?php /*
				<script>
					document.addEventListener('DOMContentLoaded', function() {
							const postGrid = document.querySelector('.cdb-post_grid');
							const paginationWrapper = document.querySelector('.pagination-wrapper');
							const loader = document.querySelector('.post-grid__loader');
							let loading = false;

							function loadPosts2(reset, page) {
									if (loading) return;
									loading = true;
									loader.style.display = 'block';

									const ajaxUrl = postGrid.getAttribute('data-ajax-url');
									const postsPerPage = postGrid.getAttribute('data-post-per-page');
									// const category = postGrid.getAttribute('data-category');

									fetch(ajaxUrl, {
											method: 'POST',
											headers: {
													'Content-Type': 'application/x-www-form-urlencoded',
											},
											body: new URLSearchParams({
													action: 'load_more',
													page: page,
													posts_per_page: postsPerPage,
													// category: category
											})
									})
									.then(response => response.text())
									.then(data => {
											loader.style.display = 'none';
											if (reset) {
													postGrid.querySelector('.post-grid__posts').innerHTML = data;
											} else {
													postGrid.querySelector('.post-grid__posts').insertAdjacentHTML('beforeend', data);
											}
											loading = false;
											console.log('DEBUG: data', data);
									})
									.catch(error => {
											console.error('Error:', error);
											loader.style.display = 'none';
											loading = false;
									});
							}

							paginationWrapper.addEventListener('click', function(event) {
									event.preventDefault();

									if (event.target.tagName === 'A') {
											const page = parseInt(event.target.getAttribute('data-page'));
											loadPosts2(true, page);
									}
							});
					});					

				</script>
				*/ ?>
				<?php							


			}


			?>

			<?php if ($use_ajax) { ?>
				<!-- <button class="post-grid__load-more btn hollow">
					Load More
				</button> -->

				<div class="post-grid__nav-more">
				<?php 
					echo cd_button(array(
						'text'		=> 'Load More',
						'href'		=> '',
						'style'		=> 'h-dark post-grid__load-more',
						'size'		=> '',
						'icon'		=> 'r-arrow',
					));
				?>
				</div>

				<div class="post-grid__loader" style="display: none;">
					<svg width="38" height="38" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient x1="8.042%" y1="0%" x2="65.682%" y2="23.865%" id="a"><stop stop-color="#000" stop-opacity="0" offset="0%"/><stop stop-color="#000" stop-opacity=".631" offset="63.146%"/><stop stop-color="#000" offset="100%"/></linearGradient></defs><g transform="translate(1 1)" fill="none" fill-rule="evenodd"><path d="M36 18c0-9.94-8.06-18-18-18" stroke="url(#a)" stroke-width="2"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite"/></path><circle fill="#000" cx="36" cy="18" r="1"><animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="0.9s" repeatCount="indefinite"/></circle></g></svg>					
				</div>



				<!-- ajax paging -->
				



			<?php } ?>
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
<?php } */?>