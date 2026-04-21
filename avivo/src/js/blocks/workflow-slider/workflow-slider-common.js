/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeWorkflowSlider()` function is specifically designed to initialize Splide sliders. It ensures that only
 * sliders that haven't been initialized yet are set up, preventing duplicate initialization. Splide itself adds 
 * the 'is-initialized' class to each slider element that has been successfully initialized, so this function 
 * checks for that class before initializing.
 *
 * Usage:
 * - Call the `initializeWorkflowSlider()` function to initialize all Splide sliders that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, ensuring 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the slider
function initializeWorkflowSlider() {
	//console.log('workflow-slider initialize called');
	
	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-workflow_slider .splide').forEach(function (obj) {
		
		// Check if Splide is already initialized and destroy it
		if (obj.splide) {
			obj.splide.destroy();
		}

		// Check for autoplay data attribute
		const autoplay = obj.getAttribute('data-autoplay') === '1';

		// Initialize Splide with the autoplay option
		const splideInstance = new Splide(obj, {
			type: 'slide', // fade, loop, slide
			perPage: 1,
			perMove: 1,
			pagination: false,
		//	rewind: true,
			speed: 1000, // 400
			lazyLoad: 'nearby',
			autoplay: autoplay,
			gap: -60,
			fixedWidth: '520px',
			breakpoints: {
				519: {	// substract 1px from the css media breakpoint
					fixedWidth: '100%',
					gap: 20,
					perPage: 1,
					drag: false,
          padding: {
            right: '30px',
            left: '0%',
          },  
				},
		//		992: {
		//			perPage: 1,
		//		},
		//		1200: {
		//			perPage: 2,
		//		},
			}
		});

		// Add class if there's only one page
		splideInstance.on('mounted move resize', () => {
			const isSinglePage = splideInstance.Components.Controller.getEnd() === 0;
			splideInstance.root.classList.toggle('single-page', isSinglePage);
		});

		// Mount splide slider
		splideInstance.mount();
		//console.log('slider initialized, autoplay: '+autoplay);

		obj.splide = splideInstance;

		// Add event listener to the `.arrow_dot` elements for navigation
		document.querySelectorAll('.arrow_dot').forEach(function (arrow) {
			arrow.addEventListener('click', function () {
				// Navigate to the next slide
				splideInstance.go('>'); // '>' goes to the next slide
			});
		});

		// Event listener for the stop dot
		document.querySelectorAll('.stop_dot').forEach(function (dot) {
			dot.addEventListener('click', function () {
				// Go back to the first slide
				splideInstance.go(0);
			});
		});
	});
}
