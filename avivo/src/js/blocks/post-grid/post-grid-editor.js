/**
 * This code handles the initialization and re-initialization of Post Grid functionality in the WordPress block editor.
 * It listens for changes in the block editor and initializes the Post Grid using a debounce mechanism to avoid
 * unnecessary or repeated initialization within a short time frame.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "post-grid-common.js"
 * at the top of this file. This ensures that the `initializePostGrid()` function is available within this script.
 *
 * Key Elements:
 * - `wp.domReady()`: Ensures the script runs once the WordPress block editor is fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor state, such as when blocks are added, removed,
 *   or modified.
 * - `postDebounceTimer`: A variable to store the debounce timer, preventing rapid re-initialization of the Post Grid.
 * - `DEBOUNCE_DELAY`: The delay time (in milliseconds) before the Post Grid re-initialize after a change is detected.
 * - The Post Grid initialization is managed through the `initializePostGrid()` function, imported from 
 *   "post-grid-common.js".
 *
 * Usage:
 * - This script is intended for use within the block editor. It ensures that the Post Grid functionality remains
 *   consistent and responsive to changes in the editor, without overloading the page with unnecessary reinitialization.
 */

// @prepros-prepend "post-grid-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let postDebounceTimer;		// Create a variable to store the debounce timer for the slider
    	const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		wp.data.subscribe(() => {
			clearTimeout(postDebounceTimer);
			postDebounceTimer = setTimeout(() => {
				initializePostGrid();
				//console.log('toggle re-initialized');
			}, DEBOUNCE_DELAY);
		});
	}
});