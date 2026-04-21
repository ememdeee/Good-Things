/**
 * This file contains shared functions and utilities used across various parts of the website or application.
 * Its purpose is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeSpyScroll()` function is designed to activate scroll spy behavior. It ensures that 
 * navigation elements respond to scrolling by highlighting the corresponding section of the page. 
 * The function checks if a block has already been initialized (by looking for the 'is-initialized' class)
 * to prevent duplicate initialization.
 *
 * Usage:
 * - Call the `initializeSpyScroll()` function to enable scroll spy for all eligible elements that haven't 
 *   been initialized yet.
 * - This function is flexible and can be applied both on the front-end and within the block editor, 
 *   ensuring consistent behavior across different environments.
 */
 
// Function to initialize the spy scroll
function initializeSpyScroll() {

	// Assuming a fixed navbar height
	const navbarHeight = 150; // Replace with your navbar class or get dynamically

	function isInViewport(el) {
		const elementTop = el.offsetTop - navbarHeight;
		const elementHeight = el.offsetHeight;
		const scrollY = window.scrollY || window.pageYOffset;
		const viewportHeight = window.innerHeight;

		const elementPos = elementTop + (elementHeight / 2); // halfway from the top

		return (
			elementPos >= scrollY && elementPos <= (scrollY + viewportHeight)
		);
	}

	function setActiveNav(tile, navLinks) {
		navLinks.forEach(link => {
			link.classList.remove('active');
		});

		const tileId = tile.getAttribute('id');
		const navLink = document.querySelector(`.tile_nav li a[href="#${tileId}"]`);
		if (navLink) {
			navLink.classList.add('active');
		}
	}

	// Debounced scroll event listener
	function setupScrollSpy(scrollElement, tiles, navLinks) {
		let timeout;
		scrollElement.addEventListener('scroll', () => {
			clearTimeout(timeout);
			timeout = setTimeout(() => {
				let firstFound = false;
				tiles.forEach(tile => {
					if (!firstFound && isInViewport(tile)) {
						setActiveNav(tile, navLinks);
						firstFound = true;
					}
				});
			}, 0); // Adjust debounce delay as needed
		});
	}

	// Initialize the scroll spy for each block
	document.querySelectorAll('.cdb-richtext_featured_tiles:not(.is-initialized)').forEach(block => {
		block.classList.add('is-initialized'); // Mark as initialized
		
		// const tiles = block.querySelectorAll('.richtext_featured_tiles__tile[id]');
		const navLinks = block.querySelectorAll('.tile_nav li a');
		const tiles = block.querySelectorAll('.richtext_featured_tiles__tile');

		// // Apply the appropriate scroll listener based on the environment (front-end or back-end)
		// if (typeof wp !== 'undefined' && wp.data) {
		// 	// We're in the Gutenberg editor (admin side)
		// 	const editorContainer = document.querySelector('#editor .interface-navigable-region.interface-interface-skeleton__content');
		// 	if (editorContainer) {
		// 		setupScrollSpy(editorContainer, tiles, navLinks);
		// 	} else {
		// 		setupScrollSpy(window, tiles, navLinks);
		// 	}
		// } else {
		// 	// We're on the front-end
		// 	setupScrollSpy(window, tiles, navLinks);
		// }

		let stacking = true;

		// check if block has class cdb-richtext_featured_tiles--no-stacking
		if (block.classList.contains('cdb-richtext_featured_tiles--no-stacking')) {
			stacking = false;
		}

		if (stacking) {
			// Loop through each of the selected elements
			tiles.forEach(element => {
			//  Get the computed 'top' style value for the element
			//    It will return a string like "150px"
			const computedStyle = window.getComputedStyle(element);
			const topValue = computedStyle.top;

				// console.log('DEBUG: element', element, topValue);

			// Parse the pixel value into a number
			//    parseFloat("150px") returns 150
			const topOffset = parseFloat(topValue) + 40;

			// Create the IntersectionObserver for this specific element
			const observer = new IntersectionObserver(
				([entry]) => {
				// The `isIntersecting` property will be false when the element
				// is scrolled past the rootMargin, meaning it's "stuck".
				// We toggle the class based on that.
						if (entry.intersectionRatio < 1) {
							entry.target.classList.add('stuck');
							// set class piled-up to previous sibling, if exists
							const prevSibling = entry.target.previousElementSibling;
							if (prevSibling) {
								prevSibling.classList.add('piled-up1');
							}
							const prevSibling2 = prevSibling ? prevSibling.previousElementSibling : null;
							if (prevSibling2) {
								prevSibling2.classList.add('piled-up2');
							}
						} else {
							entry.target.classList.remove('stuck');
							const prevSibling = entry.target.previousElementSibling;
							if (prevSibling) {
								prevSibling.classList.remove('piled-up1');
							}
							const prevSibling2 = prevSibling ? prevSibling.previousElementSibling : null;
							if (prevSibling2) {
								prevSibling2.classList.remove('piled-up2');
							}
						}
				},
				{
				threshold: [1],
				// Adjust the rootMargin to be slightly past the element's top offset.
				// We use a negative value to shrink the observation area.
				rootMargin: `-${topOffset + 1}px 0px 30000px 0px`
				}
			);

			// Start observing the current element
			observer.observe(element);
			});
		}



		

	});

}

