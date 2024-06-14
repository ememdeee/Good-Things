<?php
/**
 * The template for displaying footer.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$footer_nav_menu = wp_nav_menu( [
	'theme_location' => 'menu-2',
	'fallback_cb' => false,
	'echo' => false,
] );
?>
<footer id="site-footer" class="site-footer">
	<div class="site-main">
		<?php if ( $footer_nav_menu ) : ?>
			<nav class="site-navigation">
				<?php
			// PHPCS - escaped by WordPress with "wp_nav_menu"
			echo $footer_nav_menu; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</nav>
		<?php endif; ?>
		<div class="divider"></div>
		<!-- Add your copyright notice here -->
		<div class="site-info">
			<?php
			$current_year = date( 'Y' ); // Get the current year
			$site_name = get_bloginfo( 'name' ); // Get the site name (use 'description' if you want the site description)

			// Display the copyright notice
			echo sprintf( '&copy; %d %s. All rights reserved.', $current_year, $site_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
	</div>
</footer>