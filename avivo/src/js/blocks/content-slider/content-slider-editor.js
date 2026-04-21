/**
 * This code is used in the WordPress block editor to handle the initialization and re-initialization of sliders
 * whenever the block editor state changes. It listens for changes and initializes the slider with a debounce
 * mechanism to avoid unnecessary or repeated initialization within a short time frame.
 *
 * The `@prepros-prepend` directive is used by Prepros to include the shared functions from "content-slider-common.js"
 * at the top of this file. This ensures that the `initializeSlider()` function is available for use within this script.
 *
 * Key elements:
 * - `wp.domReady()`: Ensures the script runs once the WordPress block editor is fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor state, such as when blocks are added, removed,
 *   or modified.
 * - `sliderDebounceTimer`: A variable to store the debounce timer, which prevents rapid re-initialization of the slider.
 * - `DEBOUNCE_DELAY`: The delay time (in milliseconds) before the slider re-initializes after a change is detected.
 * - The slider initialization is managed through the `initializeSlider()` function, which is imported from 
 *   "content-slider-common.js".
 *
 * Usage:
 * - This script is intended for use within the block editor. It keeps the slider functionality consistent and
 *   responsive to changes within the editor without overloading the page with unnecessary reinitialization.
 */

// @prepros-prepend "content-slider-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let sliderDebounceTimer;		// Variable to store the debounce timer for the slider
		const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		// Store the initial block content to compare later
		let previousContent = wp.data.select('core/block-editor').getBlocks();

		wp.data.subscribe(() => {
			const currentContent = wp.data.select('core/block-editor').getBlocks();

			// Check if the content has changed
			if (JSON.stringify(previousContent) !== JSON.stringify(currentContent)) {
				clearTimeout(sliderDebounceTimer);
				sliderDebounceTimer = setTimeout(() => {
					initializeSlider();
					//console.log('slider re-initialized');
					previousContent = currentContent; // Update the previous content
				}, DEBOUNCE_DELAY);
			}
		});
	}
});