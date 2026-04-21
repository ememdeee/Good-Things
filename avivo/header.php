<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');

// get the page menu style
$posttype = get_post_type();
$post_types = ['post']; // Define the array of post types

if (is_single() && in_array($posttype, $post_types, true)) {
	$menu_style = 'light';  // Single case-study or post
} else {
	$menu_style = get_field('menu_style') ?? 'light';  // Fallback to 'light' if menu_style is not set
}

// for mobile status bar color
$theme_color = ($menu_style === 'dark') ? '#1A1A1A' : '#ffffff';

$contact_phone = get_field('contact_phone', 'option');
$contact_phone2 = get_field('contact_phone2', 'option');

$secondary_menu = get_field('secondary_menu', 'option');
$enable_secondary_menu = false;
if (!empty($secondary_menu)) {
	$enable_secondary_menu = true;
}


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta name="theme-color" content="<?php echo $theme_color; ?>">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<style>
		html {
			background-color:
				<?php echo $theme_color; ?>
			;
		}
	</style>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Preconnect to third-party origins to reduce connection latency -->
	<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
	<link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
	<link rel="preconnect" href="https://connect.facebook.net" crossorigin>
	<link rel="preconnect" href="https://static.hotjar.com" crossorigin>

	<!-- Preload critical fonts to reduce LCP -->
	<link rel="preload" as="font" type="font/woff2" crossorigin
		href="<?php echo get_template_directory_uri(); ?>/fonts/montserrat/montserrat-v30-latin-regular.woff2">
	<link rel="preload" as="font" type="font/woff2" crossorigin
		href="<?php echo get_template_directory_uri(); ?>/fonts/montserrat/montserrat-v30-latin-600.woff2">
	<link rel="preload" as="font" type="font/woff2" crossorigin
		href="<?php echo get_template_directory_uri(); ?>/fonts/montserrat/montserrat-v30-latin-700.woff2">
	<link rel="preload" as="font" type="font/woff2" crossorigin
		href="<?php echo get_template_directory_uri(); ?>/fonts/montserrat/montserrat-v30-latin-900.woff2">

	<?php
	// Check for custom favicon in the Theme Config Settings
	$favicon_id = get_field('site_favicon', 'option');
	if ($favicon_id) {
		$favicon_url = wp_get_attachment_image_url($favicon_id, 'full');
		if ($favicon_url) {
			echo '<link rel="icon" href="' . esc_url($favicon_url) . '" sizes="32x32" />';
			echo '<link rel="icon" href="' . esc_url($favicon_url) . '" sizes="192x192" />';
			echo '<link rel="apple-touch-icon" href="' . esc_url($favicon_url) . '" />';
		}
	} else {
		// Allow WordPress default favicon to load if no custom favicon is set
		wp_site_icon();
	}
	?>

	<script>
		<?php /* this is for AOS animation, check above for html class="no-js" */ ?>
		document.documentElement.className = document.documentElement.className.replace("no-js", "");
	</script>

	<?php wp_head(); ?>

	<?php
	// Get the script from ACF
	$script_page_header = get_field('script_page_header');

	// Sanitize the script content
	if ($script_page_header) {
		// Allow only the <script> tag and its attributes
		$sanitized_script = wp_kses($script_page_header, cd_get_allowed_script_tags());

		echo $sanitized_script; // Output the sanitized script
	}
	?>

	<!-- Critical nav CSS: hide dropdowns/megamenu before nav stylesheet loads -->
	<style>
		.menu-item.dropdown>.dropdown-menu[role="menu"]:not(.cdb-megamenu) {
			display: none;
		}
	</style>
	<style id="nav-critical-css">
		.cd-dropdown__menu {
			display: none;
		}

		#navbarNavDropdown .cdb-megamenu,
		#navbarNavDropdown .dropdown-menu {
			display: none;
		}

		.navbar__actions {
			display: none;
		}
	</style>

	<!-- Nav CSS: non-render-blocking via media swap (downloads immediately, applies on load) -->
	<link rel="stylesheet" href="/wp-content/themes/avivo/css/nav.min.css" media="print"
		onload="this.media='all';document.getElementById('nav-critical-css')?.remove();">
	<noscript>
		<link rel="stylesheet" href="/wp-content/themes/avivo/css/nav.min.css">
	</noscript>

</head>

<body <?php body_class('menu-' . $menu_style . ' ' . ($enable_secondary_menu ? 'with-top-nav' : '')); ?> <?php understrap_body_attributes(); ?> <?php echo 'menu-style="' . $menu_style . '"'; ?>>
	<?php do_action('wp_body_open'); ?>


	<div class="site" id="page">
		<?php /******************* The Navbar Area *******************/ ?>
		<div id="wrapper-navbar" class="mn-<?php echo $menu_style; ?>" itemscope itemtype="http://schema.org/WebSite">

			<a class="skip-link visually-hidden" href="#main"><?php esc_html_e('Skip to content', 'understrap'); ?></a>

			<?php // Wrapper for main nav & desktop search ?>
			<div class="main-nav-wrapper">

				<div class="container">
					<div class="navbar-brand__wrapper">
						<?php
						// The Site Logo is set using the Theme Config Settings.
						// If the Site Logo is not set in the Theme Config Settings,
						// the default logo from WordPress will be used.
						
						$site_logo = get_field('site_logo', 'option');
						$site_logo_url = null;
						if ($site_logo) {
							$site_logo_url = wp_get_attachment_image_url($site_logo, 'full');
						}
						if (!$site_logo_url) {
							if (has_custom_logo()) {
								$custom_logo_id = get_theme_mod('custom_logo');
								$site_logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
							}
						}

						$home_url = esc_url(home_url('/'));
						$site_name = esc_html(get_bloginfo('name'));
						if ($site_logo_url) {
							// $site_identity = '<span class="navbar-brand__logo" style="mask-image:url('.esc_url($site_logo_url).');-webkit-mask-image:url('.esc_url($site_logo_url).');">'.$site_name.'</span>';
							$site_identity = wp_get_attachment_image($site_logo, 'full', false, array('class' => 'navbar-brand__logo-simple'));
						} else {
							$site_identity = $site_name;
						}
						echo '<a class="navbar-brand" rel="home" href="' . $home_url . '" itemprop="url">' . $site_identity . '</a>';
						?>
					</div>

					<nav id="main-nav" class="navbar navbar-expand-md" aria-labelledby="main-nav-label">

						<h2 id="main-nav-label" class="visually-hidden">
							<?php esc_html_e('Main Navigation', 'understrap'); ?>
						</h2>

						<?php
						// Retrieve the custom field value for the main menu from the options page
						$main_menu = get_field('main_menu', 'option');

						if (!empty($main_menu) && $main_menu !== false) {
							// If a custom menu is specified, display it
							wp_nav_menu(
								array(
									'menu' => $main_menu, // Use the value from the custom field
									'container_class' => 'collapse navbar-collapse',
									'container_id' => 'navbarNavDropdown',
									'menu_class' => 'navbar-nav',
									'fallback_cb' => '', // No fallback menu
									'menu_id' => 'main-menu',
									'depth' => 4, // Depth of the menu
									'walker' => new Understrap_WP_Bootstrap_Navwalker(), // Custom walker for Bootstrap
								)
							);
						} else {
							// Fallback to the primary menu if no custom menu is specified
							wp_nav_menu(
								array(
									'theme_location' => 'primary', // Use the primary theme location menu
									'container_class' => 'collapse navbar-collapse',
									'container_id' => 'navbarNavDropdown',
									'menu_class' => 'navbar-nav',
									'fallback_cb' => '', // No fallback menu
									'menu_id' => 'main-menu',
									'depth' => 4, // Depth of the menu
									'walker' => new Understrap_WP_Bootstrap_Navwalker(), // Custom walker for Bootstrap
								)
							);
						}
						?>

					</nav><?php // #main-nav end ?>

					<?php /* search 
<div class="navbar__search">

<button class="search-toggler" type="button">
<span class="visually-hidden">Search</span>
</button>

<div class="searchbar">
<a class="searchbar__close" href="javascript:;">
   <span class="visually-hidden">Close Search</span>
</a>			

<div class="searchbar__search">
   <?php get_search_form(); ?>
</div>
</div>

</div>
*/ ?>

					<?php
					$enable_cta = get_field('enable_cta', 'option');
					$cta_buttons = get_field('cta_buttons', 'option');

					if ($enable_cta) {
						?>
						<div class="navbar__actions">
							<?php
							if (isset($cta_buttons) && is_array($cta_buttons)) {
								echo cd_button_row(array('section_buttons' => $cta_buttons));
							}
							?>



							<!-- dropdown -->
							<div class="cd-dropdown cd-dropdown--large cd-dropdown--right">
								<button class="cd-dropdown__toggle hamburger hamburger--spin more-nav-toggle" type="button"
									id="more-nav-toggle" aria-expanded="false" aria-haspopup="true">
									<span class="screen-reader-text">More</span>
									<div class="hamburger-box">
										<div class="hamburger-inner"></div>
									</div>


								</button>
								<div class="cd-dropdown__menu" aria-labelledby="more-nav-toggle">

									<?php
									// load ACF option named more_menu
									$more_menu = get_field('more_menu', 'option');
									if (!empty($more_menu)) {
										echo do_shortcode($more_menu);
									}
									?>


									<div class="cd-dropdown__footer">
										<div class="more-nav-search">
											<?php get_search_form(); ?>
										</div>
									</div>
								</div>
							</div>
							<!-- /dropdown -->



						</div>

						<div class="navbar__contact-mobile">
							<?php
							if ($contact_phone || $contact_phone2) {
								echo '<ul>';
								if ($contact_phone) {
									echo '<li class="nav__phone"><a href="tel:' . $contact_phone . '" >' . $contact_phone . '</a></li>';
								}

								if ($contact_phone2) {
									echo '<li class="nav__phone2"><a href="tel:' . $contact_phone2 . '" >' . $contact_phone2 . '</a></li>';
								}
								echo '</ul>';
							}
							?>

						</div>
					<?php } ?>

					<?php /*
<div class="global-nav-toggler global-nav-toggle hamburger hamburger--spin js-hamburger">
<span class="screen-reader-text">Global Nav</span>	
<div class="hamburger-box">
   <div class="hamburger-inner"></div>
</div>
</div>
*/ ?>

				</div>

			</div>
<?php 
?>
			<?php if ($enable_secondary_menu): ?>
				<div class="top-nav">
					<div class="container">
						<?php
						$additional_nav_items = '';

						// if ($contact_phone) {
						// 	$additional_nav_items .= '<li class="nav__phone"><a href="tel:' . $contact_phone . '" >' . $contact_phone . '</a></li>';
						// }

						// if ($contact_phone2) {
						// 	$additional_nav_items .= '<li class="nav__phone2"><a href="tel:' . $contact_phone2 . '" >' . $contact_phone2 . '</a></li>';
						// }

						wp_nav_menu(
							array(
								'menu' => $secondary_menu, // Use the value from the custom field
								'container_class' => 'top-nav-menu-container',
								'menu_class' => 'top-nav-menu',
								'fallback_cb' => '',
								'menu_id' => 'top-nav-menu',
								'depth' => 2,
								'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s' . $additional_nav_items . '</ul>'
							)
						);
						?>
					</div>
				</div>
			<?php endif; ?>

		</div>

	</div><?php // #wrapper-navbar end ?>
	<div class="page-spacer"></div>