/**
 * This file contains shared functions and utilities used across various parts of the website or application.
 * Its purpose is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeFeaturedLinks()` function is designed to activate scroll spy behavior. It ensures that 
 * navigation elements respond to scrolling by highlighting the corresponding section of the page. 
 * The function checks if a block has already been initialized (by looking for the 'is-initialized' class)
 * to prevent duplicate initialization.
 *
 * Usage:
 * - Call the `initializeFeaturedLinks()` function to enable scroll spy for all eligible elements that haven't 
 *   been initialized yet.
 * - This function is flexible and can be applied both on the front-end and within the block editor, 
 *   ensuring consistent behavior across different environments.
 */
 
// Function to initialize the spy scroll
function initializeFeaturedLinks() {
	document.querySelectorAll('.cdb-featured_links:not(.is-initialized)').forEach(block => {
		// Add the 'is-initialized' class to prevent multiple listeners
		block.classList.add('is-initialized');

		var links = block.querySelectorAll('.featured-link__link');
		if (links.length === 0) {
			return false;
		}
		var images = block.querySelectorAll('.featured-link__image');
		links.forEach(link => {
			link.addEventListener('mouseover', function (e) {
				var index = this.parentElement.getAttribute('data-index');
				link.classList.add('is-active');
				if (index && images[index]) {
					images[index].classList.add('is-active');
				}
			});
			link.addEventListener('mouseout', function (e) {
				var index = this.parentElement.getAttribute('data-index');
				link.classList.remove('is-active');
				if (index && images[index]) {
					images[index].classList.remove('is-active');
				}
			});
		});
	});
}

