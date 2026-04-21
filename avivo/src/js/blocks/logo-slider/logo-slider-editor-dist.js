/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeLogoSlider()` function is specifically designed to initialize Splide sliders. It ensures that only
 * sliders that haven't been initialized yet are set up, preventing duplicate initialization. Splide itself adds 
 * the 'is-initialized' class to each slider element that has been successfully initialized, so this function 
 * checks for that class before initializing.
 *
 * Usage:
 * - Call the `initializeLogoSlider()` function to initialize all Splide sliders that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, ensuring 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the slider
function initializeLogoSlider() {
	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-logo_slider .splide').forEach(function (obj) {
				
		// Check if Splide is already initialized and destroy it
		if (obj.splide) {
			obj.splide.destroy();
		}

		// Check for autoplay data attribute
		const autoplay = obj.getAttribute('data-autoplay') === '1';

		// Initialize Splide with the autoplay option
		const splideInstance = new Splide(obj, {
			type: 'loop',
			// speed: 1000,
			arrows: false,
			pagination: false,
			easing: 'ease',
		//	padding: { left: '20rem', right: '20rem' },
			// autoplay: autoplay,
			autoWidth: true, // Allow slides to have their natural width
			perMove: 1,
			gap: 68,
			padding: { right: '9%' },
			drag: false,
			autoScroll: {
				speed: 1,
				pauseOnHover: false
			},
			breakpoints: {
				768: {
					gap: 50,
					// padding: { right: '30%' },
					padding: {
						// right: '15%',
						// left: '0%',
						right: '0%',
					},
				},
				992: {
					gap: 50,
					padding: { right: '9%' },
				},
				1200: {
					gap: 75,
					padding: { right: '9%' },
				},
			}

		});

		// Mount splide slider
		splideInstance.mount(window.splide.Extensions);
		// console.log('slider initialized, autoplay 2: '+autoplay);

		obj.splide = splideInstance;
	});
}

/**
 * This code is used in the WordPress block editor to handle the initialization and re-initialization of sliders
 * whenever the block editor state changes. It listens for changes and initializes the slider with a debounce
 * mechanism to avoid unnecessary or repeated initialization within a short time frame.
 *
 * The `@prepros-prepend` directive is used by Prepros to include the shared functions from "logo-slider-common.js"
 * at the top of this file. This ensures that the `initializeLogoSlider()` function is available for use within this script.
 *
 * Key elements:
 * - `wp.domReady()`: Ensures the script runs once the WordPress block editor is fully loaded.
 * - `wp.data.subscribe()`: Subscribes to changes in the block editor state, such as when blocks are added, removed,
 *   or modified.
 * - `logosliderDebounceTimer`: A variable to store the debounce timer, which prevents rapid re-initialization of the slider.
 * - `DEBOUNCE_DELAY`: The delay time (in milliseconds) before the slider re-initializes after a change is detected.
 * - The slider initialization is managed through the `initializeLogoSlider()` function, which is imported from 
 *   "logo-slider-common.js".
 *
 * Usage:
 * - This script is intended for use within the block editor. It keeps the slider functionality consistent and
 *   responsive to changes within the editor without overloading the page with unnecessary reinitialization.
 */


wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let logosliderDebounceTimer;	// Variable to store the debounce timer for the slider
		const DEBOUNCE_DELAY = 300;		// Define a debounce delay in milliseconds

		// Store the initial block content to compare later
		let previousContent = wp.data.select('core/block-editor').getBlocks();

		wp.data.subscribe(() => {
			const currentContent = wp.data.select('core/block-editor').getBlocks();

			// Check if the content has changed
			if (JSON.stringify(previousContent) !== JSON.stringify(currentContent)) {
				clearTimeout(logosliderDebounceTimer);
				logosliderDebounceTimer = setTimeout(() => {
					initializeLogoSlider();
					//console.log('logo-slider re-initialized');
					previousContent = currentContent; // Update the previous content
				}, DEBOUNCE_DELAY);
			}
		});
	}
});
//# sourceMappingURL=logo-slider-editor-dist.js.map