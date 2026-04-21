/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeTestimonialSliderSM()` function is specifically designed to initialize Splide sliders. It ensures that only
 * sliders that haven't been initialized yet are set up, preventing duplicate initialization. Splide itself adds 
 * the 'is-initialized' class to each slider element that has been successfully initialized, so this function 
 * checks for that class before initializing.
 *
 * Usage:
 * - Call the `initializeTestimonialSliderSM()` function to initialize all Splide sliders that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, ensuring 
 *   consistent behavior across different environments.
 */

// Function to initialize the slider
function initializeTestimonialSliderSM() {
	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-testimonial_slider_sm .splide').forEach(function (obj) {

		// Check if Splide is already initialized and destroy it
		if (obj.splide) {
			obj.splide.destroy();
		}

		// Check for autoplay data attribute
		const autoplay = obj.getAttribute('data-autoplay') === '1';

		// Initialize Splide with the autoplay option
		const splideInstance = new Splide(obj, {
			type: 'loop',
			speed: 400,
			// pagination: false,
			perPage: 1,
			perMove: 1,
			gap: '40px',
			autoplay: autoplay,
			drag: true,  // Enable dragging by default
			swipe: true,  // Enable swiping by default
			padding: {
				// right: '14%',
				// left: '14%',
			},
			breakpoints: {
				768: {
					perPage: 1,
					padding: {
						right: '15%',
						left: '0%',
					},
					gap: '20px',
				},
				1200: {
					perPage: 1,
				},
			}
		});

		// Add class if there's only one page
		splideInstance.on('mounted move resize', () => {
			const isSinglePage = splideInstance.Components.Controller.getEnd() === 0;
			splideInstance.root.classList.toggle('single-page', isSinglePage);
		});

		// Mount splide slider
		splideInstance.mount();

		obj.splide = splideInstance;
	});
}
