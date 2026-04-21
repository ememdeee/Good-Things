/**
 * This script handles the initialization and re-initialization of Toggle element functionality in the WordPress block editor.
 * It listens for changes in the block editor and initializes Toggles with a debounce mechanism to prevent unnecessary
 * or frequent reinitialization in a short time frame.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "richtext-toggle-common.js"
 * at the start of this file, ensuring the availability of the `initializeToggle()` function within the script.
 *
 * Key Features:
 * - `wp.domReady()`: Ensures that the script runs once the WordPress block editor is fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor (e.g., when blocks are added, removed, or modified).
 * - `faqDebounceTimer`: A variable to store the debounce timer, preventing frequent reinitialization of Toggles.
 * - `DEBOUNCE_DELAY`: The delay (in milliseconds) before reinitializing the Toggles after detecting a change.
 * - The toggle initialization is managed via `initializeToggle()`, a function imported from "richtext-toggle-common.js".
 *
 * Usage:
 * - This script is designed for use within the block editor. It ensures that the Toggle element functionality remains
 *   consistent and responds to changes in the editor without overwhelming the system with unnecessary reinitializations.
 */

// @prepros-prepend "richtext-toggle-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let faqDebounceTimer;  // Variable to store the debounce timer
		const DEBOUNCE_DELAY = 300;  // Set the debounce delay (in milliseconds)

		wp.data.subscribe(() => {
			clearTimeout(faqDebounceTimer);
			faqDebounceTimer = setTimeout(() => {
				initializeToggle();
				//console.log('Toggle re-initialized');
			}, DEBOUNCE_DELAY);
		});
	}
});
