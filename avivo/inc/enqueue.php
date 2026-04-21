<?php
/**
 * UnderStrap enqueue scripts
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (!function_exists('cd_theme_assets')) {
	/**
	 * Enqueue theme's JavaScript and CSS assets.
	 *
	 * This function enqueues the main styles and scripts for the theme, including versioning
	 * based on file modification times. It also registers and enqueues scripts and styles
	 * for plugins and custom components with appropriate dependencies.
	 *
	 * @return void
	 */
	function cd_theme_assets()
	{
		// Get theme data
		$the_theme = wp_get_theme();
		$theme_version = $the_theme->get('Version');

		// Define the template directory path and URI
		$template_directory_path = get_template_directory();
		$template_directory_uri = get_template_directory_uri();

		// Define assets
		$assets = array(
			// Theme CSS and JS
			'theme-styles' => array(
				'type' => 'style',
				'src' => $template_directory_uri . '/css/theme.min.css',
				'deps' => array(),
				'version' => $theme_version . '.' . filemtime($template_directory_path . '/css/theme.min.css'),
			),
			// 'theme-nav' => array(
			// 	'type'		=> 'style',
			// 	'src'		=> $template_directory_uri . '/css/nav.min.css',
			// 	'deps'		=> array(),
			// 	'version'	=> $theme_version . '.' . filemtime($template_directory_path . '/css/nav.min.css'),
			// ),
			'theme-scripts' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/app.min.js',
				'deps' => array(),
				'version' => $theme_version . '.' . filemtime($template_directory_path . '/js/app.min.js'),
				'in_footer' => true,
			),

			'nav-scripts' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/nav.min.js',
				'deps' => array('theme-scripts'),
				'version' => $theme_version . '.' . filemtime($template_directory_path . '/js/nav.min.js'),
				'in_footer' => true,
			),

			// Splide Slider JS and CSS - library
			'splide-slider-script' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/splide.min.js',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/js/splide.min.js'),
				'in_footer' => true,
			),
			'splide-slider-style' => array(
				'type' => 'style',
				'src' => $template_directory_uri . '/css/splide.min.css',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/css/splide.min.css'),
			),
			'splide-slider-autoscroll-script' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/splide-extension-auto-scroll.min.js',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/js/splide-extension-auto-scroll.min.js'),
				'in_footer' => true,
			),

			// noUiSlider JS and CSS - library
			'nouislider-script' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/nouislider.min.js',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/js/nouislider.min.js'),
				'in_footer' => true,
			),
			'nouislider-style' => array(
				'type' => 'style',
				'src' => $template_directory_uri . '/css/nouislider.min.css',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/css/nouislider.min.css'),
			),
			'anime-script' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/anime.min.js',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/js/anime.min.js'),
				'in_footer' => true,
			),

			// glightbox
			'glightbox-script' => array(
				'type' => 'script',
				'src' => $template_directory_uri . '/js/glightbox.min.js',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/js/glightbox.min.js'),
				'in_footer' => true,
			),
			'glightbox-style' => array(
				'type' => 'style',
				'src' => $template_directory_uri . '/css/glightbox.min.css',
				'deps' => array(),
				'version' => filemtime($template_directory_path . '/css/glightbox.min.css'),
			),

		);

		// Register assets
		foreach ($assets as $handle => $data) {
			if ($data['type'] === 'style') {
				wp_register_style($handle, $data['src'], $data['deps'], $data['version']);
			} elseif ($data['type'] === 'script') {
				wp_register_script($handle, $data['src'], $data['deps'], $data['version'], $data['in_footer']);
			}
		}

		// Enqueue Theme styles and scripts
		wp_enqueue_style('theme-styles');

		wp_enqueue_script('theme-scripts');
		wp_enqueue_script('nav-scripts');

		// Optionally, remove WordPress block editor CSS if not needed
		// wp_dequeue_style('wp-block-library');

		// // Optionally, enqueue jQuery if needed
		// wp_enqueue_script('jquery');

	}

	function cd_theme_assets_footer()
	{
		// wp_enqueue_style('theme-nav');		
	}

	add_action('wp_enqueue_scripts', 'cd_theme_assets');
	add_action('get_footer', 'cd_theme_assets_footer');
}
