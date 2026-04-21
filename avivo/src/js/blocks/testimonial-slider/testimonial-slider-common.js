/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeTestimonialSlider()` function is specifically designed to initialize Splide sliders. It ensures that only
 * sliders that haven't been initialized yet are set up, preventing duplicate initialization. Splide itself adds 
 * the 'is-initialized' class to each slider element that has been successfully initialized, so this function 
 * checks for that class before initializing.
 *
 * Usage:
 * - Call the `initializeTestimonialSlider()` function to initialize all Splide sliders that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, ensuring 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the slider
function initializeTestimonialSlider() {
	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-testimonial_slider .splide').forEach(function (obj) {
		
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
			pagination: false,
			gap: '2rem',
			autoplay: autoplay,
			drag: true,  // Enable dragging by default
			swipe: true  // Enable swiping by default
		});

		// Mount splide slider
		splideInstance.mount();

		// Check if the slider has only one slide
		if (splideInstance.length === 1) {
			obj.classList.add('single-slide');
			
			// Disable dragging and swiping for single-slide
			splideInstance.options = {
				...splideInstance.options, // Preserve existing options
				drag: false,  // Disable drag
				swipe: false, // Disable swipe
			};
			splideInstance.refresh(); // Apply the new options
			
		}

		obj.splide = splideInstance;
	});
}
