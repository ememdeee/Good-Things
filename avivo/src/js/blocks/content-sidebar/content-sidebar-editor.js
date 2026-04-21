// @prepros-prepend "content-sidebar-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let contentSidebarDebounceTimer;		// Create a variable to store the debounce timer for the slider
    	const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		wp.data.subscribe(() => {
			clearTimeout(contentSidebarDebounceTimer);
			contentSidebarDebounceTimer = setTimeout(() => {

				initializeContentSidebar();
			}, DEBOUNCE_DELAY);
		});
	}
});