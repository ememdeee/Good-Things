/**
 * This file contains shared functions and utilities used across various parts of the website or application.
 * Its purpose is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeBannerScroll()` function is designed to activate scroll spy behavior. It ensures that 
 * navigation elements respond to scrolling by highlighting the corresponding section of the page. 
 * The function checks if a block has already been initialized (by looking for the 'is-initialized' class)
 * to prevent duplicate initialization.
 *
 * Usage:
 * - Call the `initializeBannerScroll()` function to enable scroll spy for all eligible elements that haven't 
 *   been initialized yet.
 * - This function is flexible and can be applied both on the front-end and within the block editor, 
 *   ensuring consistent behavior across different environments.
 */
 
// Function to initialize the spy scroll
function initializeBannerScroll() {

	// Function to check if element is in viewport
	function isInViewport(el) {
		const scrollY = window.scrollY || window.pageYOffset;
		const elementTop = el.getBoundingClientRect().top;
		const elementHeight = el.offsetHeight;
		const viewportHeight = window.innerHeight;
		const elementMid = elementTop + (elementHeight / 2);

		// Calculate the midpoint of the viewport
		const viewportMid = (viewportHeight / 2) + 14;

		// Check if the element's midpoint is within 50% of the viewport's height
		const isVisible = elementMid <= viewportMid; 

		return isVisible;
	}

	// Debounced scroll event listener function
	function setupScrollListener(scrollElement, featuredTexts) {
		let timeout;
		scrollElement.addEventListener('scroll', () => {
			clearTimeout(timeout);
			timeout = setTimeout(() => {
				featuredTexts.forEach(featuredText => {
					if (isInViewport(featuredText)) {
						featuredText.querySelector('.text-dot').classList.add('active');
					} else {
						featuredText.querySelector('.text-dot').classList.remove('active');
					}
				});
			}, 0); // Adjust debounce delay as needed
		});
	}

	// Initialize the scroll spy for each block
	document.querySelectorAll('.cdb-featured_banner:not(.is-initialized)').forEach(block => {
		block.classList.add('is-initialized'); // Mark as initialized

		const featuredTexts = block.querySelectorAll('.featured-content-inner');

		// Apply the appropriate scroll listener based on the environment (front-end or back-end)
		if (typeof wp !== 'undefined' && wp.data) {
			// We're in the Gutenberg editor (admin side)
			const editorContainer = document.querySelector('#editor .interface-navigable-region.interface-interface-skeleton__content');
			if (editorContainer) {
				setupScrollListener(editorContainer, featuredTexts);
			} else {
				setupScrollListener(window, featuredTexts);
			}
		} else {
			// We're on the front-end
			setupScrollListener(window, featuredTexts);
		}
	});
}

