// @prepros-prepend "tab-group-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let bannerDebounceTimer;		// Create a variable to store the debounce timer for the slider
    	const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		wp.data.subscribe(() => {
			clearTimeout(bannerDebounceTimer);
			bannerDebounceTimer = setTimeout(() => {

				initializeTabGroup();
			}, DEBOUNCE_DELAY);
		});
	}
});