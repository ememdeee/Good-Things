/**
 * This code handles the initialization and re-initialization of FAQ toggle functionality in the WordPress block editor.
 * It listens for changes in the block editor and initializes the FAQ toggles using a debounce mechanism to avoid
 * unnecessary or repeated initialization within a short time frame.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "featured-faq-common.js"
 * at the top of this file. This ensures that the `initializeFAQtoggle()` function is available within this script.
 *
 * Key Elements:
 * - `wp.domReady()`: Ensures the script runs once the WordPress block editor is fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor state, such as when blocks are added, removed,
 *   or modified.
 * - `faqDebounceTimer`: A variable to store the debounce timer, preventing rapid re-initialization of the FAQ toggles.
 * - `DEBOUNCE_DELAY`: The delay time (in milliseconds) before the FAQ toggles re-initialize after a change is detected.
 * - The FAQ toggle initialization is managed through the `initializeFAQtoggle()` function, imported from 
 *   "featured-faq-common.js".
 *
 * Usage:
 * - This script is intended for use within the block editor. It ensures that the FAQ toggle functionality remains
 *   consistent and responsive to changes in the editor, without overloading the page with unnecessary reinitialization.
 */

// @prepros-prepend "featured-faq-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let faqDebounceTimer;		// Create a variable to store the debounce timer for the slider
    	const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		wp.data.subscribe(() => {
			clearTimeout(faqDebounceTimer);
			faqDebounceTimer = setTimeout(() => {
				initializeFAQtoggle();
				//console.log('toggle re-initialized');
			}, DEBOUNCE_DELAY);
		});
	}
});