<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'understrap_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	// ClueEdit
	function understrap_posted_on($noecho = false) {
		// $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		// if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		// 	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s"> (%4$s) </time>';
		// }
		// $time_string = sprintf(
		// 	$time_string,
		// 	esc_attr( get_the_date( 'c' ) ),
		// 	esc_html( get_the_date() ),
		// 	esc_attr( get_the_modified_date( 'c' ) ),
		// 	esc_html( get_the_modified_date() )
		// );
		// $posted_on   = apply_filters(
		// 	'understrap_posted_on',
		// 	sprintf(
		// 		'<span class="posted-on">%1$s <a href="%2$s" rel="bookmark">%3$s</a></span>',
		// 		esc_html_x( 'Posted on', 'post date', 'understrap' ),
		// 		esc_url( get_permalink() ),
		// 		apply_filters( 'understrap_posted_on_time', $time_string )
		// 	)
		// );
		// $byline      = apply_filters(
		// 	'understrap_posted_by',
		// 	sprintf(
		// 		'<span class="byline"> %1$s<span class="author vcard"> <a class="url fn n" href="%2$s">%3$s</a></span></span>',
		// 		$posted_on ? esc_html_x( 'by', 'post author', 'understrap' ) : esc_html_x( 'Posted by', 'post author', 'understrap' ),
		// 		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		// 		esc_html( get_the_author() )
		// 	)
		// );
		// // ClueEdit
		// if ($noecho === true) {
		// 	return $posted_on . $byline;
		// } else {
		// 	echo $posted_on . $byline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		// }

		if ($noecho === true) {
			return get_the_date();
		} else {
			echo get_the_date();
		}
	}
}

if ( ! function_exists( 'understrap_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function understrap_entry_footer() {
		// // Hide category and tag text for pages.
		// if ( 'post' === get_post_type() ) {
		// 	/* translators: used between list items, there is a space after the comma */
		// 	$categories_list = get_the_category_list( esc_html__( ', ', 'understrap' ) );
		// 	if ( $categories_list && understrap_categorized_blog() ) {
		// 		/* translators: %s: Categories of current post */
		// 		printf( '<span class="cat-links">' . esc_html__( 'Posted in %s', 'understrap' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		// 	}
		// 	/* translators: used between list items, there is a space after the comma */
		// 	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'understrap' ) );
		// 	if ( $tags_list ) {
		// 		/* translators: %s: Tags of current post */
		// 		printf( '<span class="tags-links">' . esc_html__( 'Tagged %s', 'understrap' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		// 	}
		// }
		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'understrap' ), esc_html__( '1 Comment', 'understrap' ), esc_html__( '% Comments', 'understrap' ) );
			echo '</span>';
		}
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'understrap' ),
				the_title( '<span class="visually-hidden">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
}

if ( ! function_exists( 'understrap_categorized_blog' ) ) {
	/**
	 * Returns true if a blog has more than 1 category.
	 *
	 * @return bool
	 */
	function understrap_categorized_blog() {
		$all_the_cool_cats = get_transient( 'understrap_categories' );
		if ( false === $all_the_cool_cats ) {
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);
			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );
			set_transient( 'understrap_categories', $all_the_cool_cats );
		}
		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so understrap_categorized_blog should return true.
			return true;
		}
		// This blog has only 1 category so understrap_categorized_blog should return false.
		return false;
	}
}

add_action( 'edit_category', 'understrap_category_transient_flusher' );
add_action( 'save_post', 'understrap_category_transient_flusher' );

if ( ! function_exists( 'understrap_category_transient_flusher' ) ) {
	/**
	 * Flush out the transients used in understrap_categorized_blog.
	 */
	function understrap_category_transient_flusher() {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Like, beat it. Dig?
		delete_transient( 'understrap_categories' );
	}
}

if ( ! function_exists( 'understrap_body_attributes' ) ) {
	/**
	 * Displays the attributes for the body element.
	 */
	function understrap_body_attributes() {
		/**
		 * Filters the body attributes.
		 *
		 * @param array $atts An associative array of attributes.
		 */
		$atts = array_unique( apply_filters( 'understrap_body_attributes', $atts = array() ) );
		if ( ! is_array( $atts ) || empty( $atts ) ) {
			return;
		}
		$attributes = '';
		foreach ( $atts as $name => $value ) {
			if ( $value ) {
				$attributes .= sanitize_key( $name ) . '="' . esc_attr( $value ) . '" ';
			} else {
				$attributes .= sanitize_key( $name ) . ' ';
			}
		}
		echo trim( $attributes ); // phpcs:ignore WordPress.Security.EscapeOutput
	}
}



// ClueEdit
function cd_display_category($only_primary_category = false) {
	$output = '';

	$categories = [];
	
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		
		if ($only_primary_category) {
			$primary_term_id = false;
			$primary_term = false;
	
			if (function_exists('yoast_get_primary_term_id')) {
				$primary_term_id = yoast_get_primary_term_id( 'category', get_the_ID() );		
			}	
	
			if ($primary_term_id) {
				$primary_term = get_term($primary_term_id);
				if ($primary_term) {
					$categories[] = $primary_term;
				}
			} else {
				$categories = get_the_category();

				// only pick the first
				if (isset($categories[0])) {
					$categories = [$categories[0]];
				}
			}
	
			// if only show primary category, then firstly it will try to get from yoast
			// if not found, then get the first category

			// echo '<pre>';
			// var_dump($primary_term_id);
			// var_dump(yoast_get_primary_term_id( 'category', get_the_ID() ));
			// var_dump(yoast_get_primary_term());
			// echo '</pre>';
			
		} else {
			$categories = get_the_category();
		}
	

			// $categories = get_the_category();
			if ( ! empty( $categories ) && understrap_categorized_blog() ) {
					$categories_list = array();
					foreach ( $categories as $category ) {
							$categories_list[] = '<li>' . esc_html( $category->name ) . '</li>';
					}
					$categories_string = implode( ' ', $categories_list );
					/* translators: %s: Categories of current post */
					$output .= sprintf( '<ul class="cat-links">' . esc_html__( '%s', 'understrap' ) . '</ul>', $categories_string ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
	}
	return $output;
}


// aside
function cd_display_aside_childpages() {
	return do_shortcode('[cd_childpages]');
	// echo do_shortcode('[cd_childpages fromroot="1"]');
}



// image blob
// parameters:
// array(
//   'imageblob_image' => 0, // integer
//   'imageblob_shape' => 'shape1', // string, default shape1
// )

function cd_display_image_blob($imageblob) {
	static $svg_shape1_printed = false;
	static $svg_shape2_printed = false;
	static $svg_shape3_printed = false;

	$imageblob_image = $imageblob['imageblob_image'] ?? 0; // integer
	$imageblob_shape = $imageblob['imageblob_shape'] ?? 'shape1'; //

	$clippath_id = $imageblob_shape;
	// randomize
	$clippath_id .= '-' . uniqid();

	$output = '<div class="imageblob imageblob--' . esc_attr($imageblob_shape) . '">';
	$output .= '<div class="imageblob__image-wrapper">';
	$output .= wp_get_attachment_image($imageblob_image, 'full', false, array('class' => 'imageblob__img', 'style' => 'clip-path: url(#' . $clippath_id . ');'));
	$output .= '</div>';

	if ($imageblob_shape === 'shape1') {
		$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/shape1-accent.svg" class="imageblob__accent">';
	} else if ($imageblob_shape === 'shape2') {
		$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/shape2-accent.svg" class="imageblob__accent">';
	} else if ($imageblob_shape === 'shape3') {
		$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/shape3-accent.svg" class="imageblob__accent">';
	} else if ($imageblob_shape === 'shape4') {
		$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/shape4-accent.svg" class="imageblob__accent">';
	} else if ($imageblob_shape === 'shape5') {
		$output .= '<img src="' . get_stylesheet_directory_uri() . '/img/svg/shape3-accent.svg" class="imageblob__accent">';
	}

	$svg_output = '';
		// from figma, save as svg, edit in svg editor, make 1x1px image, save as svg small (with no transform)

		if ($imageblob_shape === 'shape1') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '            <path d="M 0.71739097,0 C 0.87347254,4.0817137e-8 1,0.12652828 1,0.28260898 1,0.37002162 0.96031121,0.4481614 0.89797333,0.49999998 0.96031114,0.55183862 1,0.62997838 1,0.717391 1,0.87347251 0.87347254,1 0.71739097,1 H 0.28260887 C 0.1265283,1 1.0378679e-7,0.87347251 0,0.717391 0,0.62998001 0.03968851,0.5518386 0.10202513,0.49999998 0.03968851,0.4481614 0,0.37001997 0,0.28260898 1.0378679e-7,0.12652828 0.1265283,4.0817137e-8 0.28260887,0 Z" />';
			// $svg_output .= '        </clipPath>';

			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '            <path d="M0.612,0.642c0.019,0.042 0.037,0.084 0.063,0.122c0.026,0.037 0.059,0.071 0.1,0.089c0.041,0.017 0.09,0.018 0.129,-0.005c0.047,-0.028 0.069,-0.085 0.081,-0.14c0.021,-0.095 0.019,-0.195 0.001,-0.29c-0.01,-0.054 -0.025,-0.108 -0.059,-0.15c-0.023,-0.029 -0.056,-0.051 -0.092,-0.059c-0.036,-0.008 -0.075,-0.001 -0.104,0.022c-0.026,0.019 -0.043,0.049 -0.053,0.08c-0.01,0.031 -0.016,0.061 -0.025,0.1c-0.029,-0.13 -0.135,-0.248 -0.261,-0.278c-0.127,-0.03 -0.27,0.028 -0.337,0.143c-0.033,0.057 -0.047,0.124 -0.052,0.19c-0.006,0.067 -0.004,0.136 0.018,0.198c0.044,0.125 0.169,0.214 0.297,0.211c0.129,-0.003 0.25,-0.098 0.294,-0.233l0,0Z" style="fill-rule:nonzero;"/>';
			// $svg_output .= '        </clipPath>';

			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '            <path d="M0.612,0.689c0.019,0.056 0.037,0.112 0.063,0.163c0.026,0.049 0.059,0.095 0.1,0.119c0.041,0.022 0.09,0.024 0.129,-0.007c0.047,-0.037 0.069,-0.113 0.081,-0.187c0.021,-0.126 0.019,-0.26 0.001,-0.386c-0.01,-0.072 -0.025,-0.144 -0.059,-0.2c-0.023,-0.039 -0.056,-0.069 -0.092,-0.079c-0.036,-0.011 -0.075,-0.002 -0.104,0.029c-0.026,0.026 -0.043,0.066 -0.053,0.107c-0.01,0.041 -0.016,0.081 -0.025,0.133c-0.029,-0.173 -0.135,-0.331 -0.261,-0.371c-0.127,-0.04 -0.27,0.038 -0.337,0.191c-0.033,0.076 -0.047,0.166 -0.052,0.254c-0.006,0.089 -0.004,0.181 0.018,0.264c0.044,0.166 0.169,0.285 0.297,0.281c0.129,-0.004 0.25,-0.131 0.294,-0.311Z" style="fill-rule:nonzero;"/>';
			$svg_output .= '        </clipPath>';

		}

		if ($imageblob_shape === 'shape2') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path
			// d="M 0.31664008,1.0562862e-4 C 0.40710668,-0.00275136 0.52540236,0.05286267 0.63499506,0.10438624 c 0.0260889,0.0122657 0.0516868,0.0242996 0.0762974,0.0352576 0.007218,0.003214 0.0143579,0.006384 0.0214159,0.009518 0.12937271,0.05744 0.2307643,0.10245468 0.2598024,0.17184045 0.030621,0.0731711 -0.040141,0.40003196 -0.0774569,0.53782071 -0.019291,0.0712279 -0.0766785,0.11452549 -0.10400743,0.12636394 -0.0902192,0.039081 -0.22550701,-0.004906 -0.41079812,-0.0651516 l -0.005915,-0.001922 c -0.006565,-0.002134 -0.0130701,-0.004246 -0.0195089,-0.006336 C 0.2104784,0.85841903 0.08791692,0.81862618 0.02520397,0.75166293 -0.02331855,0.69985046 0.00730929,0.58210403 0.04109634,0.46626227 c 0.0115919,-0.0397432 0.006903,-0.0339201 0.039751,-0.14171673 0.0149438,-0.0490404 0.0240929,-0.080211 0.03698,-0.12039982 C 0.15321224,0.0937972 0.19322814,0.00400329 0.31664008,1.0562862e-4 Z" />';      
			// $svg_output .= '        </clipPath>';
			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '    <path d="M0.96,0.481c0.006,-0.035 -0.01,-0.072 -0.042,-0.107c0.042,-0.022 0.07,-0.051 0.076,-0.087c0.019,-0.107 -0.164,-0.229 -0.409,-0.272c-0.244,-0.043 -0.458,0.009 -0.476,0.116c-0.007,0.035 0.009,0.072 0.042,0.107c-0.043,0.022 -0.07,0.052 -0.077,0.087c-0.006,0.035 0.01,0.072 0.043,0.107c-0.043,0.022 -0.071,0.052 -0.077,0.087c-0.006,0.035 0.01,0.072 0.042,0.107c-0.042,0.022 -0.07,0.051 -0.076,0.087c-0.019,0.107 0.164,0.229 0.409,0.272c0.244,0.043 0.458,-0.009 0.476,-0.116c0.007,-0.035 -0.009,-0.072 -0.042,-0.107c0.043,-0.022 0.07,-0.052 0.077,-0.087c0.006,-0.035 -0.01,-0.072 -0.043,-0.107c0.043,-0.022 0.071,-0.052 0.077,-0.087l-0,0Z" style="fill-rule:nonzero;"/>';
			$svg_output .= '        </clipPath>';
		}

		if ($imageblob_shape === 'shape3') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path
			// 	d="M 0.70444492,0 C 0.86767536,3.3e-7 0.99999998,0.22385834 0.99999998,0.50000004 0.99999998,0.77614175 0.86767536,1 0.70444492,1 0.59055797,1 0.49171595,0.89102761 0.44236377,0.73135632 0.39538987,0.79930512 0.33296087,0.84072637 0.26444493,0.84072637 0.1183958,0.84072637 0,0.65252364 0,0.42036225 0,0.188203 0.1183958,0 0.26444493,0 0.35306963,0 0.43150724,0.06930612 0.4794913,0.17567899 0.5337014,0.06817047 0.61436811,0 0.70444492,0 Z"
			// 	/>';
			// $svg_output .= '        </clipPath>';
			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '    <path d="M0.736,0.029l-0.736,0.13l0.091,0.515c0.042,0.237 0.25,0.36 0.523,0.312c0.274,-0.049 0.421,-0.234 0.379,-0.471l-0.091,-0.515l-0.166,0.029Z" style="fill-rule:nonzero;"/>';
			$svg_output .= '        </clipPath>';
		}

		if ($imageblob_shape === 'shape4') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path d="m 0.44134071,0.99750181 c 0.11635399,0.005508 0.23445582,0.005451 0.34697502,-0.0383974 0.041661,-0.0162332 0.0832785,-0.039276 0.11557429,-0.0811881 0.0368074,-0.0477705 0.0583784,-0.11602795 0.0727336,-0.1850114 0.0162609,-0.0781593 0.0245566,-0.16004733 0.023245,-0.24174737 -0.001591,-0.099348 -0.0195377,-0.2036609 -0.0681582,-0.27280613 C 0.89128418,0.1208578 0.83505356,0.09480415 0.780236,0.07605746 0.6509095,0.03184279 0.51780037,0.01797796 0.38535068,0.00425135 0.34326358,-1.0990489e-4 0.300462,-0.00439793 0.25931404,0.00929608 0.21907188,0.02268893 0.18231524,0.05271337 0.14787745,0.08608181 0.11172357,0.12111824 0.07676693,0.16127258 0.05281816,0.21426712 0.02301372,0.2802143 0.01256347,0.36062983 0.00550369,0.43908324 -0.00592252,0.56607973 -0.0032038,0.71989443 0.04932627,0.82987776 c 0.04053998,0.0848741 0.12117589,0.11319831 0.18595581,0.13544257 0.0674364,0.0231583 0.13705841,0.0289013 0.20605863,0.0321722" /></clipPath>';
			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '    <path
			d="M 0.31664008,1.0562862e-4 C 0.40710668,-0.00275136 0.52540236,0.05286267 0.63499506,0.10438624 c 0.0260889,0.0122657 0.0516868,0.0242996 0.0762974,0.0352576 0.007218,0.003214 0.0143579,0.006384 0.0214159,0.009518 0.12937271,0.05744 0.2307643,0.10245468 0.2598024,0.17184045 0.030621,0.0731711 -0.040141,0.40003196 -0.0774569,0.53782071 -0.019291,0.0712279 -0.0766785,0.11452549 -0.10400743,0.12636394 -0.0902192,0.039081 -0.22550701,-0.004906 -0.41079812,-0.0651516 l -0.005915,-0.001922 c -0.006565,-0.002134 -0.0130701,-0.004246 -0.0195089,-0.006336 C 0.2104784,0.85841903 0.08791692,0.81862618 0.02520397,0.75166293 -0.02331855,0.69985046 0.00730929,0.58210403 0.04109634,0.46626227 c 0.0115919,-0.0397432 0.006903,-0.0339201 0.039751,-0.14171673 0.0149438,-0.0490404 0.0240929,-0.080211 0.03698,-0.12039982 C 0.15321224,0.0937972 0.19322814,0.00400329 0.31664008,1.0562862e-4 Z" />';      
			$svg_output .= '        </clipPath>';
		}

		if ($imageblob_shape === 'shape5') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path d="m 0.70145828,0.39005971 c 0,0.18022747 -0.0853388,0.4658724 -0.19783221,0.4658724 -0.0830147,0 -0.21043603,-0.26366959 -0.21043603,-0.44389767 C 0.29319004,0.23180697 0.40665122,0 0.5239911,0 0.65296648,0 0.70145828,0.20983163 0.70145828,0.39005971 Z m 0.2783169,0.0659254 C 1.0411741,0.6320737 0.95115769,0.79435175 0.86498831,0.83292589 0.77881346,0.87150003 0.69206484,0.79468509 0.63066594,0.61860454 0.56926704,0.44251535 0.67055665,0.23635081 0.7567315,0.19777667 0.86498831,0.14931856 0.93904294,0.30765278 0.97977518,0.45598511 Z M 0.36980041,0.60871255 c 0.0613994,0.17608363 0.0416994,0.33662094 -0.063382,0.38365806 C 0.2202447,1.0309447 0.10061302,0.91946925 0.03921369,0.74338253 -0.02218559,0.56729828 -0.01214778,0.33523925 0.07402614,0.29666511 0.19136601,0.23403599 0.30840097,0.43262645 0.36980041,0.60871255 Z" /></clipPath>';

			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path d="M0.704,0.132c0.164,-0 0.296,0.165 0.296,0.368c0,0.203 -0.132,0.368 -0.296,0.368c-0.113,0 -0.212,-0.08 -0.262,-0.198c-0.047,0.05 -0.109,0.081 -0.178,0.081c-0.146,-0 -0.264,-0.139 -0.264,-0.31c0,-0.171 0.118,-0.309 0.264,-0.309c0.089,-0 0.168,0.051 0.215,0.129c0.055,-0.079 0.135,-0.129 0.225,-0.129Z" style="fill-rule:nonzero;"/>      
			// 	</clipPath>';

			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '    <path d="M0.704,0c0.164,0 0.296,0.224 0.296,0.5c0,0.276 -0.132,0.5 -0.296,0.5c-0.113,-0 -0.212,-0.109 -0.262,-0.269c-0.047,0.068 -0.109,0.11 -0.178,0.11c-0.146,0 -0.264,-0.189 -0.264,-0.421c0,-0.232 0.118,-0.42 0.264,-0.42c0.089,0 0.168,0.069 0.215,0.175c0.055,-0.107 0.135,-0.175 0.225,-0.175Z" style="fill-rule:nonzero;"/>      
				</clipPath>';

		}

		if ($imageblob_shape === 'shape6') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path d="m 0.94492299,0.30129172 c 0.0390332,0.1574813 0.0958291,0.42304469 0.0108946,0.45923902 C 0.89313778,0.78724172 0.73982617,0.5978463 0.70079293,0.440365 0.66176103,0.2828837 0.69722494,0.04382533 0.78582072,0.00607033 0.88320314,-0.03542898 0.90589109,0.1438099 0.94492299,0.30129172 Z M 0.55689463,0.43959617 c 0,0.16558987 -0.0677518,0.42803593 -0.15705961,0.42803593 -0.0659065,0 -0.16706758,-0.24225696 -0.16706758,-0.40784683 0,-0.16558986 0.0900784,-0.37856859 0.18323554,-0.37856859 0.10239708,0 0.14089165,0.19278963 0.14089165,0.35837949 z m 0.22096078,0.0605708 C 0.82660062,0.66195125 0.75513813,0.81105253 0.68672363,0.84649379 0.61830914,0.88193505 0.54943731,0.81135901 0.5006921,0.64957474 0.45194689,0.48779047 0.53236402,0.29837053 0.60077852,0.26292927 0.68672363,0.21840747 0.74551949,0.36388179 0.77785541,0.50016697 Z M 0.29358862,0.64048894 C 0.34233516,0.80227496 0.3266952,0.94977029 0.24326874,0.99298737 0.17485425,1.0284286 0.07987795,0.92600851 0.03113221,0.7642225 -0.0176134,0.60243823 -0.00964425,0.3892285 0.05877014,0.35378724 c 0.0931575,-0.0575428 0.18607327,0.12491744 0.23481848,0.2867017 z" /></clipPath>';
			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '    <path d="M0.344,0.025c0.103,-0.03 0.215,-0.029 0.317,0.005c0.01,0.003 0.017,0.011 0.019,0.022l0,0.001l0.012,0.089l0.001,0.003l0.002,-0.002l0.072,-0.041l-0,0c0.01,-0.006 0.022,-0.005 0.031,0.002l-0,0c0.079,0.061 0.141,0.142 0.178,0.235l0.001,0.004c0.005,0.012 0.001,0.025 -0.009,0.033l-0.038,0.028l-0.003,0.002l0.003,0.001c0.027,0.007 0.043,0.013 0.053,0.019c0.005,0.004 0.008,0.007 0.01,0.011c0.002,0.003 0.002,0.006 0.002,0.011l-0,-0.001l0,0.003c0.012,0.074 0.001,0.153 -0.028,0.222c-0.005,0.011 -0.015,0.017 -0.026,0.017c-0.001,0 -0.001,0 -0.001,0l0,0l0,0l-0.062,-0.001l-0.003,-0l0.001,0.002c0.02,0.03 0.03,0.047 0.035,0.056c0.003,0.005 0.004,0.008 0.005,0.01c0.001,0.003 0.001,0.004 0.001,0.005l-0,0c0.001,0.007 -0,0.014 -0.004,0.02c-0.041,0.065 -0.098,0.119 -0.166,0.154l-0,0c-0.011,0.006 -0.023,0.004 -0.032,-0.003l-0,-0.001l-0.069,-0.063l-0.002,-0.001l-0.001,0.002c-0.009,0.05 -0.014,0.075 -0.016,0.089c-0.003,0.013 -0.004,0.014 -0.005,0.016c-0.004,0.008 -0.012,0.014 -0.02,0.015c-0.031,0.005 -0.061,0.007 -0.092,0.007c-0.086,0 -0.172,-0.019 -0.25,-0.056l-0.003,-0.001c-0.011,-0.005 -0.017,-0.016 -0.016,-0.028l0.005,-0.074l0,-0.003l-0.002,0.001c-0.037,0.016 -0.056,0.024 -0.067,0.027c-0.005,0.001 -0.009,0.001 -0.012,0.001c-0.002,-0.001 -0.005,-0.002 -0.008,-0.004l0,0c-0.002,-0.001 -0.004,-0.002 -0.006,-0.004l-0.001,-0.001c-0.09,-0.092 -0.144,-0.218 -0.15,-0.347c-0,-0.012 0.007,-0.023 0.018,-0.027l0,-0l0.073,-0.029l0.002,-0.001l-0.002,-0.002c-0.038,-0.033 -0.058,-0.05 -0.067,-0.062c-0.005,-0.005 -0.007,-0.009 -0.007,-0.013c-0,-0.003 0.001,-0.007 0.003,-0.011l-0,0l-0,-0c0.027,-0.1 0.086,-0.19 0.167,-0.255c0.008,-0.007 0.02,-0.008 0.029,-0.004l0.089,0.042l0.002,0.001l0,-0.002c0.008,-0.053 0.013,-0.08 0.017,-0.095c0.002,-0.007 0.004,-0.011 0.006,-0.014c0.002,-0.003 0.004,-0.004 0.007,-0.006l0,-0c0.002,-0.002 0.005,-0.003 0.007,-0.004Z" style="fill-rule:nonzero;"/></clipPath>';
		}

		if ($imageblob_shape === 'shape7') {
			// $svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			// $svg_output .= '    <path d="m 0.23444079,0 c 0.078936,1.498491e-7 0.14876072,0.0607725 0.19124471,0.15391983 0.0429276,-0.08918098 0.10530593,-0.14530796 0.17473428,-0.14530796 0.0964047,2e-7 0.1792155,0.10821065 0.21523217,0.2628751 0.0179388,-0.0157973 0.0386634,-0.0248122 0.0607399,-0.0248142 0.068267,0 0.12360774,0.0862095 0.12360774,0.19255544 0,0.10634391 -0.0553407,0.19255343 -0.12360774,0.19255343 -0.0212517,0 -0.0412489,-0.008358 -0.0587162,-0.0230726 C 0.78281055,0.76813873 0.6986757,0.8805414 0.60041983,0.8805414 c -0.0423477,0 -0.0820709,-0.020884 -0.11635879,-0.0574069 -0.017758,0.10191057 -0.0775633,0.1768664 -0.14860633,0.1768664 -0.0850347,-2.01e-6 -0.15397073,-0.10738811 -0.15397073,-0.23985503 0,-0.0130695 6.7316e-4,-0.0258945 0.001964,-0.0383969 C 0.07849051,0.68548266 2.3893104e-7,0.53962756 0,0.36521031 0,0.16351102 0.10496324,0 0.23444079,0 Z" /></clipPath>';
			$svg_output .= '        <clipPath id="'. $clippath_id .'" clipPathUnits="objectBoundingBox">';
			$svg_output .= '    <path d="M0.012,0.501c-0.077,0.262 0.221,0.495 0.494,0.495c0.273,0 0.494,-0.222 0.494,-0.495c0,-0.273 -0.231,-0.472 -0.494,-0.495c-0.015,-0.001 -0.03,-0.002 -0.044,-0.002c-0.242,-0 -0.36,0.19 -0.45,0.497" style="fill-rule:nonzero;"/></clipPath>';
		}

	if ($svg_output !== '') {
		$svg_output = '<svg width="1" height="1" viewBox="0 0 1 1" fill="none" xmlns="http://www.w3.org/2000/svg" style="position: absolute;"><defs>'. $svg_output . '</defs></svg>';
	}

	$output .= $svg_output;

	$output .= '</div>';

	return $output;
}