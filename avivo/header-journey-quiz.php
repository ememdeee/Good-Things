<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


	<script>
    	document.documentElement.className = document.documentElement.className.replace("no-js","");		
	</script>

	<?php wp_head(); ?>

	<?php /* ClueEdit: quick patch to fix menu?? need to check if conflict because of optimization */ ?>
	<style>
		.hc-offcanvas-nav {
			display: none !important;
		}
	</style>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>

<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">

	<div id="wrapper-navbar" class="header-journey-quiz mn-light">
		<div class="main-nav-wrapper">

        <div class="container">
				<? /*
				<div class="navbar__brand">
					<!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>

						<?php if ( is_front_page() && is_home() ) : ?>

							<div class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></div>

						<?php else : ?>

							<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

						<?php endif; ?>

						<?php
					} else {
						// the_custom_logo();
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );

						?>
						<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url" >
						
						
						<span class="navbar-brand__logo" style="background-image:url(<?php echo $image[0]; ?>)"><?php bloginfo( 'name' ); ?></span>
					

						
					
						</a>	


						
						<?php
					}
					?>
					<!-- end custom logo -->
				</div>
				*/ ?>

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
						echo '<a class="navbar-brand" rel="home" href="'.$home_url.'" itemprop="url">'.$site_identity.'</a>';
					?>
				</div>


                <div class="header-journey__title tagline">
                    Your Avivo journey
                </div>

                <div class="header-journey__actions">
                    <a href="/" class="header-journey__exit btn h-dark cdb-icon"><i class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg></i><span class="link-text">Exit</span></a>
                    <!-- <a href="/your-journey-dev?restart=true" class="header-journey__restart btn h-dark"><span class="link-text">Restart (Dev)</span></a> -->
                    <a href="/your-journey?restart=true" class="header-journey__restart btn h-dark cdb-icon"><i class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><polyline points="24 56 24 104 72 104" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M67.59,192A88,88,0,1,0,65.77,65.77L24,104" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg></i><span class="link-text">Restart</span></a>
                    
										<a href="#" class="header-journey__saveexit btn h-dark cdb-icon"><?php /*<i class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M216,83.31V208a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V48a8,8,0,0,1,8-8H172.69a8,8,0,0,1,5.65,2.34l35.32,35.32A8,8,0,0,1,216,83.31Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M80,216V152a8,8,0,0,1,8-8h80a8,8,0,0,1,8,8v64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="152" y1="72" x2="96" y2="72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg></i>*/ ?><i class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg></i><span class="link-text">Save &amp; exit</span></a>
                    <a href="/" class="header-journey__close btn h-dark cdb-icon"><i class=""><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><line x1="200" y1="56" x2="56" y2="200" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="200" y1="200" x2="56" y2="56" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg></i><span class="link-text">Exit</span></a>
                </div>
        </div>
		</div>
	</div>
