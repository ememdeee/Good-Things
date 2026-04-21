<?php
/**
 * Nav
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// register navigation menu
add_action( 'after_setup_theme', 'cd_navs' );
if ( ! function_exists( 'cd_navs' ) ) {
	function cd_navs() {
		register_nav_menus(
			array(
				'top_nav_menu' => __( 'Top Nav Menu', 'understrap' ),
				'mobile_menu' => __( 'Mobile Menu', 'understrap' ),
				// 'more_menu' => __( 'More Menu', 'understrap' ),
			)
		);
	}
}

// define the nav_menu_item_title callback 
function cd_filter_nav_menu_item_title( $title, $item, $args, $depth ) { 
	// make filter magic happen here... 
	return '<span class="nav-link__text">'.$title.'</span>'; 
}; 
		 
// add the filter 
add_filter( 'nav_menu_item_title', 'cd_filter_nav_menu_item_title', 10, 4 ); 