// @prepros-prepend "availability-finder-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let availabilityFinderDebounceTimer;		// Create a variable to store the debounce timer
    	const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		wp.data.subscribe(() => {
			clearTimeout(availabilityFinderDebounceTimer);
			availabilityFinderDebounceTimer = setTimeout(() => {

				initializeAvailabilityFinder();
			}, DEBOUNCE_DELAY);
		});
	}
});