// @prepros-prepend "case-study-slider-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let postSliderDebounceTimer;		// Variable to store the debounce timer for the slider
		const DEBOUNCE_DELAY = 300;	// Define a debounce delay in milliseconds

		// Store the initial block content to compare later
		let previousContent = wp.data.select('core/block-editor').getBlocks();

		wp.data.subscribe(() => {
			const currentContent = wp.data.select('core/block-editor').getBlocks();

			// Check if the content has changed
			if (JSON.stringify(previousContent) !== JSON.stringify(currentContent)) {
				clearTimeout(postSliderDebounceTimer);
				postSliderDebounceTimer = setTimeout(() => {
					initializeCaseStudySlider();
					//console.log('postSlider re-initialized');
					previousContent = currentContent; // Update the previous content
				}, DEBOUNCE_DELAY);
			}
		});
	}
});