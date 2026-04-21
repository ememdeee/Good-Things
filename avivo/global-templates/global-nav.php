<?php
/**
 * Global Nav setup
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<?php // <a href="#" class="global-nav-toggle">TEST TOGGLE</a> ?>

<div class="global-nav-wrapper aside-panel aside-nav">
	<div class="overlay global-nav-close"></div>
	<div class="global-nav">



		<div class="global-nav-mobile">
			<div class="mobile-nav-header">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-nav-header__logo">
					<?php 
						$site_logo = get_field('site_logo', 'option');
						if ($site_logo) {
							echo wp_get_attachment_image($site_logo, 'full', false, array('class' => ''));
						} else {
							$custom_logo_id = get_theme_mod('custom_logo');
							echo wp_get_attachment_image($custom_logo_id, 'full', false, array('class' => ''));
						}
					?>
				</a>

				<h6 class="screen-reader-text">Menu</h6>
				<a href="#" class="close global-nav-close">Close</a>
			</div>

			<?php
        //    wp_nav_menu(
        //        array(
        //            'theme_location'  => 'global_menu',
        //            'container_class' => 'global-menu-container',
        //            // 'container_id'    => 'navbarNavDropdown',
        //            'menu_class'      => 'global-menu',
        //            'fallback_cb'     => '',
        //            'menu_id'         => 'global-menu',
        //            'depth'           => 9,
        //            // 'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
        //        )
        //    );

							// wp_nav_menu(
							// 	array(
							// 		'theme_location'  => 'mobile_menu',
							// 		'container_class' => 'global-menu-container',
							// 		// 'container_id'    => 'navbarNavDropdown',
							// 		'menu_class'      => 'global-menu',
							// 		'fallback_cb'     => '',
							// 		'menu_id'         => 'global-menu',
							// 		'depth'           => 9,
							// 		// 'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
							// 	)
							// );	

           ?>


<?php
	// Retrieve the custom field value for the mobile menu from the options page
	$mobile_menu = get_field('mobile_menu', 'option');

	// Uncomment the following line for debugging purposes
	// var_dump($mobile_menu);

	if (empty($mobile_menu) || $mobile_menu === false) {
		// Fallback to the main menu if no mobile menu is specified
		$mobile_menu = get_field('main_menu', 'option');
	}

	if (!empty($mobile_menu) && $mobile_menu !== false) {
		// If a custom menu is specified, display it
		wp_nav_menu(
			array(
				'menu'				=> $mobile_menu, // Use the value from the custom field
				'container_class'	=> 'global-menu-container',
				'container_id'		=> 'mobileMenu',
				'menu_class'		=> 'global-menu',
				'fallback_cb'		=> '', // No fallback function
				'menu_id'			=> 'global-menu',
				'depth'				=> 9,
				'walker'			=> new Understrap_WP_Bootstrap_Navwalker(), // Custom walker for Bootstrap
			)
		);
	} else {
		// Fallback to the mobile_menu if no custom menu is specified
		wp_nav_menu(
			array(
				'theme_location'	=> 'mobile_menu', // Ensure this theme location is registered
				'container_class'	=> 'global-menu-container',
				'container_id'		=> 'mobileMenu',
				'menu_class'		=> 'global-menu',
				'fallback_cb'		=> '', // No fallback function
				'menu_id'			=> 'global-menu',
				'depth'				=> 9,
				'walker'			=> new Understrap_WP_Bootstrap_Navwalker(), // Custom walker for Bootstrap
			)
		);
	}
?>


		<?php /*get_template_part( 'global-templates/top-nav', '', array(
			'container_class' => 'mobile-top-nav-menu-container',
			'menu_class'      => 'mobile-top-nav-menu',
			'menu_id'         => 'mobile-top-nav-menu',
		) ); */?>

<?php 
	$enable_cta_mobile = get_field('enable_cta_mobile', 'option');
	$cta_buttons_mobile = get_field('cta_buttons_mobile', 'option');

	if ($enable_cta_mobile) {

?>

			<div class="mobile-nav-actions">
				<?php 
					// $contact_phone = get_field('contact_phone','option');
					// $enquire_button_title = get_field('enquire_button_title', 'option');
					// $enquire_button_link = get_field('enquire_button_link', 'option');

					// if ($enquire_button_title && $enquire_button_link) {
					// 	echo '<a href="'. cd_get_array_item($enquire_button_link,'url') .'" class="btn btn-light mobile-nav-enquire">'
					// 	.'<img src="/wp-content/uploads/2024/01/icon-enquire.svg">'
					// 	. $enquire_button_title .'</a>';
					// }

					// if ($contact_phone) {
					// 	echo '<a href="tel:'. $contact_phone .'" class="btn btn-light mobile-nav-phone">'
					// 	. '<img src="/wp-content/uploads/2024/01/icon-phone-heart.svg">'
					// 	. $contact_phone .'</a>';
					// }
					

					/*
					$mobile_nav_button_primary = get_field('mobile_nav_button_primary','option');
					$mobile_nav_button_secondary = get_field('mobile_nav_button_secondary','option');

					if ($mobile_nav_button_primary) {
						// echo '<div class="case-study-slider__heading-button">';
						echo cd_button(array(
							'text'       => isset($mobile_nav_button_primary['button_text']) ? trim($mobile_nav_button_primary['button_text']) : '',
							'link'       => isset($mobile_nav_button_primary['button_link']) ? trim($mobile_nav_button_primary['button_link']) : '',
							'style'      => isset($mobile_nav_button_primary['button_style']) ? $mobile_nav_button_primary['button_style'] : '',
							'size'       => isset($mobile_nav_button_primary['button_size']) ? $mobile_nav_button_primary['button_size'] : '',
							'icon'       => isset($mobile_nav_button_primary['button_icon']) ? $mobile_nav_button_primary['button_icon'] : '',
						));			
						// echo '</div>';
					}
					if ($mobile_nav_button_secondary) {
						// echo '<div class="case-study-slider__heading-button">';
						echo cd_button(array(
							'text'       => isset($mobile_nav_button_secondary['button_text']) ? trim($mobile_nav_button_secondary['button_text']) : '',
							'link'       => isset($mobile_nav_button_secondary['button_link']) ? trim($mobile_nav_button_secondary['button_link']) : '',
							'style'      => isset($mobile_nav_button_secondary['button_style']) ? $mobile_nav_button_secondary['button_style'] : '',
							'size'       => isset($mobile_nav_button_secondary['button_size']) ? $mobile_nav_button_secondary['button_size'] : '',
							'icon'       => isset($mobile_nav_button_secondary['button_icon']) ? $mobile_nav_button_secondary['button_icon'] : '',
						));			
						// echo '</div>';
					}
					*/



	if (isset($cta_buttons_mobile) && is_array($cta_buttons_mobile)) {
		echo cd_button_row(array('section_buttons' => $cta_buttons_mobile));
	}

	

				?>
			</div>

			<?php } ?>

		</div>

		


	</div>
</div>
