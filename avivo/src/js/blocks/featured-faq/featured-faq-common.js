/**
 * This file contains shared functions and utilities used throughout the website or application.
 * The aim is to centralize commonly used functionality, making it easier to maintain and reuse across different parts.
 *
 * The `initializeFAQtoggle()` function is specifically designed to initialize FAQ toggle functionality. It ensures
 * that only FAQ elements that haven't been initialized yet are set up, preventing duplicate initialization. 
 * Typically, a class like 'is-initialized' is added to each FAQ element once it's been successfully initialized, 
 * so this function checks for that class before proceeding.
 *
 * Usage:
 * - Call the `initializeFAQtoggle()` function to initialize all FAQ toggle elements that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, providing 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the toggle

function initializeFAQtoggle() {
    // Select all FAQ question buttons within the featured FAQ block
	document.querySelectorAll('.featured_faq__question:not(.is-initialized)').forEach(button => {
		button.addEventListener('click', () => {
			const cdbFeaturedFaq = button.closest('.cdb-featured_faq');
			var toggleState = 'close';
			if (cdbFeaturedFaq) {
				toggleState = cdbFeaturedFaq.getAttribute('data-toggle-state');
			}
			const faqItem = button.parentElement;
			const faqListItems = button.closest('.featured_faq__list').querySelectorAll('.featured_faq__item');

			// console.log('DEBUG: ', faqItem);

		// 	// Handle toggling based on the toggle state, if close, then close all the other active items
		// 	if (toggleState === 'close') {
		// 		// Collapse any other active items
		// 	//	let count = 0;
		// 		faqListItems.forEach(item => {
		// 			if (item !== faqItem && item.classList.contains('active')) {
		// 				item.classList.remove('active');
		// 	//			count++;
		// 			}
		// 		});

		// 		// Toggle the active class on the clicked item, with delay, close the other item first
		// 	//	if (count>0) {
		// 	//		setTimeout(() => {
		// 	//			faqItem.classList.toggle('active');
		// 	//		}, 600);
		// 	//	} else {
		// 	//		faqItem.classList.toggle('active');
		// 	//	}
		// //	} else {
		// //		faqItem.classList.toggle('active');
		// 	}

			faqItem.classList.toggle('active');

			// // only scroll in mobile
			// if (window.innerWidth < 768) {
			// 	// scroll to faqItemPosition
			// 	window.scrollTo({ top: faqItemPosition, behavior: 'smooth' });
			// }

			// // scroll to faqItemPos
			// window.scrollTo({ top: faqItemPos + window.scrollY, behavior: 'smooth' });
			
		});
	
		// Add the 'is-initialized' class to prevent multiple listeners
		button.classList.add('is-initialized');
		//console.log('toggle initialized');

	});
	
// Function to handle hash changes
function handleHashChange() {
	const hash = window.location.hash.substring(1); // Remove the '#' from the hash
	const targetElement = document.getElementById(hash);

	// Check if the target element exists and has the class 'featured_faq__item'
	if (targetElement && targetElement.classList.contains('featured_faq__item')) {

			let navbar = document.querySelector('#wrapper-navbar');
			let navbarHeight = navbar ? navbar.offsetHeight : 0;
			let faqItemPosition = targetElement.getBoundingClientRect().top + window.scrollY - navbarHeight;

			// Expand the FAQ item
			targetElement.classList.add('active');

			// Optionally, scroll to the target element with offset navbarHeight using faqItemPosition
			window.scrollTo({ top: faqItemPosition, behavior: 'smooth' });
	}
	// console.log('DEBUG: hash change!');
}

// Add event listener for hash changes
window.addEventListener('hashchange', handleHashChange);

function handleAnchorClick(event) {
	const targetHash = event.currentTarget.getAttribute('href');
	if (window.location.hash === targetHash) {
			handleHashChange();
	}
}

document.querySelectorAll('a[href^="#"]:not(.faq-anchor-initialized)').forEach(anchor => {
	let anchorHref = anchor.getAttribute('href');
	let id = anchorHref.substring(1);
	if (id) {
		let targetElement = document.querySelector(anchorHref);
		// only assign event when there's element with class .featured_faq__item and id same as href
		if (targetElement && targetElement.classList.contains('featured_faq__item')) {
			anchor.addEventListener('click', handleAnchorClick);
			anchor.classList.add('faq-anchor-initialized');
		}	
	}
});

handleHashChange();

// faqs with cdb-featured_faq--important class
document.querySelectorAll('.cdb-featured_faq--important .featured_faq__item').forEach(faqItem => {
	// additional title
	const additionalTitle = faqItem.querySelector('.featured-faq__additional-title--static');
	
	// additional tittle that only shown when faq item is collapsed
	const collapsibleTitle = faqItem.querySelector('.featured-faq__additional-title--collapsible');

	// any button with href # inside faqItem, on click, toggle the faq item
	faqItem.querySelectorAll('a[href="#"]').forEach(button => {
		button.addEventListener('click', (event) => {
			// Let the native click bubble to parent handlers.
			event.preventDefault();
		});
	});

	
	// title wrapper is .featured_faq__question .title_wrapper
	const titleWrapper = faqItem.querySelector('.featured_faq__question .title_wrapper');
	if (additionalTitle && titleWrapper) {
		// Move the additional title into the title wrapper
		titleWrapper.appendChild(additionalTitle);
	}
	if (collapsibleTitle && titleWrapper) {
		// Move the collapsible title into the title wrapper
		titleWrapper.appendChild(collapsibleTitle);
	}
});
		


}