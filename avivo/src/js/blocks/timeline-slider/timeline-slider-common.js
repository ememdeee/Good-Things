/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeTimeline()` function is specifically designed to initialize Splide sliders. It ensures that only
 * sliders that haven't been initialized yet are set up, preventing duplicate initialization. Splide itself adds 
 * the 'is-initialized' class to each slider element that has been successfully initialized, so this function 
 * checks for that class before initializing.
 *
 * Usage:
 * - Call the `initializeTimeline()` function to initialize all Splide sliders that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, ensuring 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the slider
function initializeTimeline() {
	//console.log('timeline-slider initialize called');
	
	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-timeline_slider .splide').forEach(function (obj) {
		
		// Check if Splide is already initialized and destroy it
		if (obj.splide) {
			obj.splide.destroy();
		}

		// Check for autoplay data attribute
		const autoplay = obj.getAttribute('data-autoplay') === '1';

		// Initialize Splide with the autoplay option
		const splideInstance = new Splide(obj, {
			type: 'slide', // fade, loop, slide
			perPage: 3,
			perMove: 1,
			pagination: false,
		//	rewind: true,
			speed: 1000, // 400
			lazyLoad: 'nearby',
			autoplay: autoplay,
			breakpoints: {
				560: {
					perPage: 1,
				},
				992: {
					perPage: 2,
				},
			}
		});

		// Mount splide slider
		splideInstance.mount();
		//console.log('slider initialized, autoplay: '+autoplay);

		obj.splide = splideInstance;
	});
}
