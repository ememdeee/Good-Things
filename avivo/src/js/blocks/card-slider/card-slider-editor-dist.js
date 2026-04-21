function initializeCardSlider() {

	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-card_slider').forEach(function (section) {

		const slider = section.querySelector('.splide');
		if (!slider) return; // Skip if no .splide element found

		// Destroy existing Splide instance if initialized
		if (slider.splide) {
			slider.splide.destroy();
			slider.splide = null;
		}

		// Get slider style and autoplay setting
		const autoplay = slider.getAttribute('data-autoplay') === '1';

		// Set up slider options
		const sliderOptions = {
			// type: 'loop',
			speed: 1000,
			autoplay: autoplay,
			perPage: 3,
			perMove: 1,
			gap: 40,
			padding: { right: '7.5%' },
			pagination: true,
			lazyLoad: 'nearby',
			breakpoints: {
				// 560: {
				// 	perPage: 1,
				// 	gap: 20,
				// 	padding: { right: '0%' },
				// },
				768: {
					perPage: 1,
					gap: 20,
					// padding: { right: '30%' },
					padding: {
						right: '15%',
						left: '0%',
					},
				},
				992: {
					perPage: 2,
					gap: 30,
					padding: { right: '0%' },
				},
				1200: {
					perPage: 3,
					gap: 30,
					padding: { right: '20%' },
				},
			}
		};

		// Initialize Splide
		const splideInstance = new Splide(slider, sliderOptions);

		// Add class if there's only one page
		splideInstance.on('mounted move resize', () => {
			const isSinglePage = splideInstance.Components.Controller.getEnd() === 0;
			splideInstance.root.classList.toggle('single-page', isSinglePage);
		});

		// Mount the Splide slider
		splideInstance.mount();

		// Store instance reference on the DOM element
		slider.splide = splideInstance;
	});


}

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
					initializeCardSlider();
					//console.log('postSlider re-initialized');
					previousContent = currentContent; // Update the previous content
				}, DEBOUNCE_DELAY);
			}
		});
	}
});
//# sourceMappingURL=card-slider-editor-dist.js.map