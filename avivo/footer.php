<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<footer class="footer sc-footer" role="contentinfo">
	<?php /*
	<div class="footer__breadcrumbs">
		<div class="container">
			<?php
				// Check if the Breadcrumbs function exists
				if (function_exists('cd_breadcrumbs')) {
					cd_breadcrumbs();
				}
			?>
		</div>
	</div>
	*/ ?>
	<div class="container footer__wrapper">
		<?php			
			// Footer Intro Text
			// Get the ACF fields
			$footer_intro_title = get_field('footer_intro_title', 'option') ?? false;				// array
			$footer_intro_description = get_field('section_description', 'option') ?? '';			// string
			$footer_intro_button_row = get_field('footer_intro_button_row', 'option') ?? false;		// array
			$footer_logo = get_field('footer_logo', 'option') ?? false;	// string

			// if title or description not empty
			if ( (isset($footer_intro_title) && is_array($footer_intro_title)) || ($footer_intro_description) ) {
		?>
		<div class="footer__intro">
			<?php 
					if ($footer_logo) {
						$footer_logo_url = wp_get_attachment_image_url($footer_logo, 'full');
						if ($footer_logo_url) {
							echo '<div class="footer__logo"><img src="' . esc_url($footer_logo_url) . '" alt="' . esc_attr(get_bloginfo('name')) . '"></div>';
						}
					}
			?>

			<?php if ((isset($footer_intro_title) && is_array($footer_intro_title) && $footer_intro_title['title_text']) || $footer_intro_description) : ?>
			<div class="footer__description">
				<?php
					// Check if footer_intro_title exists and is not empty
					if (isset($footer_intro_title) && is_array($footer_intro_title)) {
						echo cd_title($footer_intro_title);
					}

					// Check if footer_intro_description exists
					if ($footer_intro_description) {
						echo cd_print_richtext( $footer_intro_description,'<div class="content__description">','</div>' );
					}

					// Ensure footer_intro_button_row exists and is an array
					if (isset($footer_intro_button_row) && is_array($footer_intro_button_row)) {
						echo cd_button_row($footer_intro_button_row);
					}
				?>
			</div>
			<?php endif; ?>

			
			<?php
				$footer_logos = get_field('footer_logos', 'option');

				// Ensure $footer_logos is an array before processing
				if (is_array($footer_logos) && !empty($footer_logos)) :
					echo '<div class="footer__logos">';
					// Loop through each logo
					foreach ($footer_logos as $logo) :
						// Get image ID from the field
						$logo_image_id = isset($logo['image']) ? intval($logo['image']) : 0;

						// Get the complete <img> tag including alt text
						$logo_image_html = wp_get_attachment_image($logo_image_id, 'full', false, array('alt' => get_post_meta($logo_image_id, '_wp_attachment_image_alt', true)));

						if ($logo_image_html) :
							echo '<div class="footer__logo-image">';
							echo $logo_image_html; // Output the <img> tag with alt text
							echo '</div>';
						endif;
					endforeach;
					echo '</div>';
				endif;
			?>
			

			<div class="footer__socials">
				<?php echo do_shortcode('[cd_social_links]'); ?>
			</div>

		</div>
		<?php } ?>
			
		<?php // Footer Navigation & Form ?>
		<div class="footer__footer">

			<div class="footer_nav-wrapper">
				<?php
					$footer_content_columns = get_field('footer_content_columns', 'option');

					// Ensure $footer_content_columns is an array before processing
					if (is_array($footer_content_columns) && !empty($footer_content_columns)) :
						echo '<div class="footer__nav">'; // Start wrapper for footer menu

						// Loop through each column
						foreach ($footer_content_columns as $column) :
							$column_title = cd_print_text($column['title']);
							$column_content = isset($column['content']) ? wp_kses_post($column['content']) : ''; // Escape content safely
							
							echo '<div class="footer__nav-column">';
							echo	'<div class="footer__nav-title">' . ($column_title?$column_title:'&nbsp;') . '</div>';
							echo	'<div class="footer__nav-content">' . $column_content . '</div>';
							echo '</div>'; // End column
						endforeach;

						echo '</div>'; // End wrapper for footer menu
					endif;
				?>
				
				<?php
				/*
					// Retrieve fields
					$newsletter_title = get_field('footer_newsletter_title', 'option');
					$newsletter_form_id = get_field('footer_newsletter_form', 'option');

					// Start the container
					echo '<div class="footer-newsletter">';

						// Check if the form ID is set
						if (!empty($newsletter_form_id)) {
							echo '<div class="footer-newsletter__description">';
							
							// Check if the title is set
							if (!empty($newsletter_title)) {
								echo '<div class="footer-newsletter__heading">' . esc_html($newsletter_title) . '</div>';
							} else {
								echo '<div class="footer-newsletter__heading">Subscribe to our newsletter!</div>'; // Fallback message
							}
							
							echo '</div>';
							echo '<div class="footer-newsletter__form">';
							echo gravity_form($newsletter_form_id, false, false, false, '', true, 1, false);
							echo '</div>';
						} else {
							// Handle the case where the form ID is not set
							echo '<div class="footer-newsletter__description">';
							echo	'<p class="footer-newsletter__heading">Newsletter form is not available.</p>';
							echo '</div>';
						}

					echo '</div>';
				*/
					?>


				<?php 
				$footer_disclaimer = get_field('footer_disclaimer', 'option');
				$footer_disclaimer_image = get_field('footer_disclaimer_image', 'option');
				if ($footer_disclaimer || $footer_disclaimer_image) : ?>
				<div class="footer__disclaimer">
					<?php if ($footer_disclaimer_image) : ?>
						<div class="footer__disclaimer-image">
							<?php echo wp_get_attachment_image($footer_disclaimer_image, 'full'); ?>
						</div>
					<?php endif; ?>
					<?php if ($footer_disclaimer) : ?>
						<div class="footer__disclaimer-text"><?php echo wp_kses_post($footer_disclaimer); ?></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>


			</div>
		</div>



	</div>

	<div class="footer__copyright">
		<div class="container">
			<?php
				$footer_foot_columns = get_field('footer_foot_columns', 'option');

				// Ensure $footer_foot_columns is an array before processing
				if (is_array($footer_foot_columns) && !empty($footer_foot_columns)) :
					// Loop through each column
					foreach ($footer_foot_columns as $column) :
						$column_content = isset($column['content']) ? wp_kses_post($column['content']) : ''; // Escape content safely
						echo	'<div class="footer__info-content">' . $column_content . '</div>';
					endforeach;
				endif;
			?>
		</div>
	</div>
	

</footer><?php // .footer end ?>

</div><!-- #page.site -->
<?php // #page - we need this extra closing tag here - do not remove ?>

<div style="display:none;" class="megamenu-offscreen">
<?php
	// Get the mega_menu from ACF options
	$mega_menu = get_field('mega_menu', 'option');

	// Check if mega_menu is a valid array and contains the necessary fields
	if ($mega_menu && is_array($mega_menu)) {

		// Process the mega_menu
		foreach ($mega_menu as $menu) {
			// Check if mega_menu_item exists, otherwise default to 0
			$mega_menu_item = !empty($menu['mega_menu_item']) ? $menu['mega_menu_item'] : 0;

			// Check if mega_menu_html exists, otherwise default to an empty string
			$mega_menu_html = !empty($menu['mega_menu_html']) ? $menu['mega_menu_html'] : '';

			// Only output section if both mega_menu_item and mega_menu_html are valid
			if ($mega_menu_item !== 0 && !empty($mega_menu_html)) {
				echo '<div class="cdb-megamenu dropdown-menu" aria-labelledby="menu-item-dropdown-' . $mega_menu_item . '" role="menu" id="megamenu-' . $mega_menu_item . '" data-menuid="' . $mega_menu_item . '">';
				echo	'<div class="megamenu-wrapper">';
				echo		'<div class="container">';
				echo			do_shortcode($mega_menu_html);
				?>

				<!-- temporary megamenu html here -->

				<!--  -->

				<!--  -->


				<?php
				echo		'</div>';
				echo	'</div>';
				echo '</div>';
			}
		}
	}
?>
</div>

<div style="display:none;" class="mobile-brand-offscreen">
	<?php wp_footer(); ?>
<div class="mobile-brand__wrapper" id="mobile_nav_brand">
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
		// $site_identity = '<span class="mobile-brand__logo" style="mask-image:url('.esc_url($site_logo_url).');-webkit-mask-image:url('.esc_url($site_logo_url).');">'.$site_name.'</span>';
		$site_identity = '<img class="mobile-brand__logo" src="'.esc_url($site_logo_url).'" alt="'.esc_attr($site_name).'">';
	} else {
		$site_identity = $site_name;
	}
	echo '<a class="mobile-brand" rel="home" href="'.$home_url.'" itemprop="url">'.$site_identity.'</a>';
?>

	<div class="mobile-nav-contact">
		<?php 
		$contact_phone = get_field('contact_phone','option');
		if ($contact_phone) {
			echo '<ul>';
			if ($contact_phone) {
				echo '<li class="nav__phone"><a href="tel:' . $contact_phone . '" >'  . $contact_phone . '</a></li>';
			}
			echo '</ul>';
		}
		?>		
	</div>


	<div class="mobile-nav-search">
		<?php get_search_form( ); ?>
	</div>
</div>

<?php 
	$enable_cta_mobile = get_field('enable_cta_mobile', 'option');
	$cta_buttons_mobile = get_field('cta_buttons_mobile', 'option');

	if ($enable_cta_mobile) {
?>
<div class="mobile-cta__wrapper" id="mobile_nav_cta">
<?php
	if (isset($cta_buttons_mobile) && is_array($cta_buttons_mobile)) {
		echo cd_button_row(array('section_buttons' => $cta_buttons_mobile));
	}
?>
</div>
<?php } ?>

<?php 
	$mobile_quick_links = get_field('mobile_quick_links', 'option');
	if (isset($mobile_quick_links) && !empty($mobile_quick_links)) {
		echo '<div class="mobile_nav_quick-links">';
		?>
			<!--  -->
			<!--  -->
		<?php
		echo $mobile_quick_links;
		echo '</div>';
	}
?>
</div>

<?php /*
<section class="section cdb-megamenu dropdown-menu"<?php echo ' aria-labelledby="menu-item-dropdown-' . $mega_menu_item . '"'; ?> role="menu"<?php echo ' id="megamenu-' . $mega_menu_item . '"'; ?><?php echo ' data-menuid="' . $mega_menu_item . '"'; ?>>
	<div class="container section-container">
		<div class="megamenu-container">
			<div class="megamenu__content">
				<p class="subtitle" style="padding-left:20px">Our Services</p>
				<ul class="megamenu__list">
					<li>
						<a href="/strategy" class="megamenu__list_link">
							<div class="megamenu__list_icon"><img loading="lazy" decoding="async" width="48" height="48" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Strategy.svg" class="attachment-thumbnail size-thumbnail" alt=""></div>
							<div class="megamenu__list_text">
								<div class="title">Strategy</div>
								<p>Strategies for digital growth & transformation.</p>
							</div>
						</a>
					</li>
					<li>
						<a href="/brand" class="megamenu__list_link">
							<div class="megamenu__list_icon"><img loading="lazy" decoding="async" width="48" height="48" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Brand.svg" class="attachment-thumbnail size-thumbnail" alt=""></div>
							<div class="megamenu__list_text">
								<div class="title">Brand</div>
								<p>Elevate your identity with branding solutions.</p>
							</div>
							</a>
					</li>
					<li>
						<a href="/web" class="megamenu__list_link">
							<div class="megamenu__list_icon"><img loading="lazy" decoding="async" width="48" height="48" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Web.svg" class="attachment-thumbnail size-thumbnail" alt=""></div>
							<div class="megamenu__list_text">
								<div class="title">Web</div>
								<p>Innovative web solutions for digital engagement.</p>
							</div>
							</a>
					</li>
					<li>
						<a href="/marketing" class="megamenu__list_link">
							<div class="megamenu__list_icon"><img loading="lazy" decoding="async" width="48" height="48" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Marketing.svg" class="attachment-thumbnail size-thumbnail" alt=""></div>
							<div class="megamenu__list_text">
								<div class="title">Marketing</div>
								<p>Data-driven strategies to grow audience & sales.</p>
							</div>
						</a>
					</li>
					<li>
						<a href="/ecommerce" class="megamenu__list_link">
							<div class="megamenu__list_icon"><img loading="lazy" decoding="async" width="48" height="48" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/eCommerce.svg" class="attachment-thumbnail size-thumbnail" alt=""></div>
							<div class="megamenu__list_text">
								<div class="title">eCommerce</div>
								<p>Seamless solutions to boost experiences & revenue.</p>
							</div>
						</a>
					</li>
					<li>
						<a href="/software" class="megamenu__list_link">
							<div class="megamenu__list_icon"><img loading="lazy" decoding="async" width="48" height="48" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Software.svg" class="attachment-thumbnail size-thumbnail" alt=""></div>
							<div class="megamenu__list_text">
								<div class="title">Software</div>
								<p>Seamless solutions to boost experiences & revenue.</p>
							</div>
						</a>
					</li>
				</ul>
			</div>
			<div class="megamenu__featured">
				<p class="subtitle">Featured Case Study</p>
				
				<a href="/marketing" class="megamenu__featured_case">
					<div class="megamenu__featured_image">
						<picture class="cdb-bgimage carousel__bgimage bgz-reg" style="opacity: 1;">
							<source srcset="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Image.webp 700w, https://clue.flywheelsites.com/wp-content/uploads/2024/11/Image-300x197.webp 300w" media="(min-width: 768px)">
							<img decoding="async" src="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Image.webp" srcset="https://clue.flywheelsites.com/wp-content/uploads/2024/11/Image.webp 700w, https://clue.flywheelsites.com/wp-content/uploads/2024/11/Image-300x197.webp 300w" data-imagesize="full">
						</picture>
					</div>
					<div class="title_wrapper"><div class="subtitle sm above"><u>EPIHUB</u></div><div class="title h3">Using technology to transform WHS management</div></div>
					<div class="megamenu__featured__link"><span class="link-text">read more</span></div>
				</a>
			</div>
		</div>
	</div>
</section>
<?php /* */ ?>


<?php
	// Retrieve the custom field value for the mobile menu from the ACF options page
	$mobile_menu = get_field('mobile_menu', 'option');

	if (empty($mobile_menu) || $mobile_menu === false) {
		// Fallback to the main menu if no mobile menu is specified
		$mobile_menu = get_field('main_menu', 'option');
	}

	if (!empty($mobile_menu) && $mobile_menu !== false) {
		// If a custom menu is specified, display it
		wp_nav_menu(
			array(
				'menu'				=> $mobile_menu, // Use the value from the custom field
				'container_class'	=> 'mobile-menu-container',
				'container_id'		=> 'mobileMenu',
				'menu_class'		=> 'mobile-menu',
				'fallback_cb'		=> '', // No fallback function
				'menu_id'			=> 'mobile-menu',
				'depth'				=> 9,
				'walker'			=> new Understrap_WP_Bootstrap_Navwalker(), // Custom walker for Bootstrap
			)
		);
	} else {
		// Fallback to the mobile_menu if no custom menu is specified
		wp_nav_menu(
			array(
				'theme_location'	=> 'mobile_menu', // Ensure this theme location is registered
				'container_class'	=> 'mobile-menu-container',
				'container_id'		=> 'mobileMenu',
				'menu_class'		=> 'mobile-menu',
				'fallback_cb'		=> '', // No fallback function
				'menu_id'			=> 'mobile-menu',
				'depth'				=> 9,
				'walker'			=> new Understrap_WP_Bootstrap_Navwalker(), // Custom walker for Bootstrap
			)
		);
	}
?>



<!-- temporary - delete this later -->
 <?php /*
		<div class="cd-dropdown cd-dropdown--hover cd-dropdown--megamenu"> 
			<button class="cd-dropdown__toggle" type="button" id="myCDDropdownToggle" aria-expanded="false" aria-haspopup="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-left: 5px;">
            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
        </svg>
    	</button>
			<div class="cd-dropdown__menu" aria-labelledby="myCDDropdownToggle">
					<div class="cd-dropdown__column">
							<h4>Category 1</h4>
							<a class="cd-dropdown__item" href="#">Sub-Item A</a>
							<a class="cd-dropdown__item" href="#">Sub-Item B</a>
							<a class="cd-dropdown__item" href="#">Sub-Item C</a>
					</div>
					<div class="cd-dropdown__column">
							<h4>Category 2</h4>
							<a class="cd-dropdown__item" href="#">Sub-Item X</a>
							<a class="cd-dropdown__item" href="#">Sub-Item Y</a>
					</div>
					<div class="cd-dropdown__column">
							<h4>Links & Resources</h4>
							<a class="cd-dropdown__item" href="#">About Us</a>
							<a class="cd-dropdown__item" href="#">Contact</a>
							<div class="cd-dropdown__divider"></div>
							<a class="cd-dropdown__item" href="#">Support</a>
					</div>
			</div>
		</div>

		<div class="cd-dropdown" style="margin-top: 20px;"> <button class="cd-dropdown__toggle" type="button" id="anotherCDDropdownToggle" aria-expanded="false" aria-haspopup="true">
						Click-Only Dropdown
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="vertical-align: middle; margin-left: 5px;">
								<path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708"/>
						</svg>
				</button>
				<div class="cd-dropdown__menu" aria-labelledby="anotherCDDropdownToggle">
						<a class="cd-dropdown__item" href="#">Item A</a>
						<a class="cd-dropdown__item" href="#">Item B</a>
				</div>
		</div>
<!--  -->
*/ ?>




<?php // global nav ?>
<?php // get_template_part( 'global-templates/global-nav', '' ); ?>


<?php wp_footer(); ?>
</body>
</html>
