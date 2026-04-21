<?php
/**
 * Performance optimisations
 *
 * - Converts all non-critical stylesheets from render-blocking to async
 *   using the <link rel="preload" as="style"> pattern.
 * - Registers a mobile-optimised image size (400px wide).
 */

defined('ABSPATH') || exit;

// ─── Async-load all non-critical CSS ─────────────────────────────────────────
// theme-styles (theme.min.css) stays blocking — it's the critical baseline.
// Every other enqueued stylesheet becomes a preload that swaps to stylesheet
// on load, eliminating the 2,700 ms render-blocking dependency chain.
add_filter('style_loader_tag', function ($html, $handle) {
    if (is_admin()) {
        return $html;
    }

    // Stylesheets that must remain render-blocking
    $blocking = [
        'theme-styles',
        'admin-bar',
        'dashicons',
    ];

    if (in_array($handle, $blocking, true)) {
        return $html;
    }

    // Replace rel="stylesheet" with preload pattern
    $async = preg_replace(
        "/rel=['\"]stylesheet['\"]/",
        "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
        $html
    );

    // noscript fallback for JS-disabled browsers
    return $async . '<noscript>' . $html . '</noscript>';
}, 10, 2);


// ─── Mobile image size ────────────────────────────────────────────────────────
// Registers a 400 px wide size used by imageblob / hero blocks on mobile.
// After adding this, run "Regenerate Thumbnails" plugin once on the server
// to create the new size for existing uploads.
add_action('after_setup_theme', function () {
    add_image_size('mobile-img', 400, 9999, false);
});
