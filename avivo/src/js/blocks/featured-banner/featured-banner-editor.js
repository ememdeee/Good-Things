/**
 * This code manages the initialization and re-initialization of scroll spy functionality within the WordPress block editor.
 * It listens for changes in the block editor state and uses a debounce mechanism to ensure that the scroll spy is not 
 * initialized multiple times in quick succession.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "featured-banner-common.js"
 * at the top of this file, ensuring that the `initializeBannerScroll()` function is available for use within this script.
 *
 * Key Elements:
 * - `wp.domReady()`: Ensures that the script only runs after the WordPress block editor has fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor (e.g., when blocks are added, removed, or modified).
 * - `bannerDebounceTimer`: A variable used to store the debounce timer, preventing frequent or unnecessary re-initializations.
 * - `DEBOUNCE_DELAY`: The delay (in milliseconds) before reinitializing the scroll spy after detecting a change.
 * - The scroll spy behavior is managed through the `initializeBannerScroll()` function, which is imported from 
 *   "featured-banner-common.js".
 *
 * Usage:
 * - This script is specifically for use in the block editor. It ensures that the scroll spy functionality responds 
 *   appropriately to changes without triggering excessive reinitialization events, which could affect performance.
 */

// @prepros-prepend "featured-banner-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let bannerDebounceTimer;		// Create a variable to store the debounce timer for the slider
    	const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		wp.data.subscribe(() => {
			clearTimeout(bannerDebounceTimer);
			bannerDebounceTimer = setTimeout(() => {
				
				initializeBannerScroll();
				//console.log('BannerScroll re-initialized');
			}, DEBOUNCE_DELAY);
		});
	}
});