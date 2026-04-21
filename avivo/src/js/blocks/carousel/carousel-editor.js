/**
 * This code is used in the WordPress block editor to handle the initialization and re-initialization of sliders
 * whenever the block editor state changes. It listens for changes and initializes the slider with a debounce
 * mechanism to avoid unnecessary or repeated initialization within a short time frame.
 *
 * The `@prepros-prepend` directive is used by Prepros to include the shared functions from "carousel-common.js"
 * at the top of this file. This ensures that the `initializeCarousel()` function is available for use within this script.
 *
 * Key elements:
 * - `wp.domReady()`: Ensures the script runs once the WordPress block editor is fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor state, such as when blocks are added, removed,
 *   or modified.
 * - `carouselDebounceTimer`: A variable to store the debounce timer, which prevents rapid re-initialization of the slider.
 * - `DEBOUNCE_DELAY`: The delay time (in milliseconds) before the slider re-initializes after a change is detected.
 * - The slider initialization is managed through the `initializeCarousel()` function, which is imported from 
 *   "carousel-common.js".
 *
 * Usage:
 * - This script is intended for use within the block editor. It keeps the slider functionality consistent and
 *   responsive to changes within the editor without overloading the page with unnecessary reinitialization.
 */

// @prepros-prepend "carousel-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let carouselDebounceTimer;		// Variable to store the debounce timer for the slider
		const DEBOUNCE_DELAY = 300;	// Define a debounce delay in milliseconds

		// Store the initial block content to compare later
		let previousContent = wp.data.select('core/block-editor').getBlocks();

		wp.data.subscribe(() => {
			const currentContent = wp.data.select('core/block-editor').getBlocks();

			// Check if the content has changed
			if (JSON.stringify(previousContent) !== JSON.stringify(currentContent)) {
				clearTimeout(carouselDebounceTimer);
				carouselDebounceTimer = setTimeout(() => {
					initializeCarousel();
					//console.log('carousel re-initialized');
					previousContent = currentContent; // Update the previous content
				}, DEBOUNCE_DELAY);
			}
		});
	}
});