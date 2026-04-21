/**
 * This file contains shared functions and utilities used throughout the website or application.
 * It centralizes commonly used functionality to make maintenance and reuse across different parts easier.
 *
 * The `initializeToggle()` function is designed to initialize Toggle elements. It ensures that only
 * uninitialized Toggle elements are set up, avoiding duplicate event listeners or redundant initialization.
 * Typically, a class like 'is-initialized' is added to each Toggle element once it's been successfully set up,
 * allowing the function to skip over already initialized elements.
 *
 * Usage:
 * - Call `initializeToggle()` to initialize all Toggle elements that haven't been initialized yet.
 * - This function works in both front-end and block editor contexts, ensuring consistent behavior across environments.
 */
 
// Function to initialize toggles
function initializeToggle() {
	// Select all titles  within the toggle block that haven't been initialized
	document.querySelectorAll('.cdb-richtext_toggle .richtext-toggle__title:not(.is-initialized)').forEach(button => {
		
		// Add a click event listener to toggle the active class
		button.addEventListener('click', () => {
			const toggleState = button.closest('.cdb-richtext_toggle').getAttribute('data-toggle-state');
			const toggleItem = button.parentElement;
			const toggleListItems = button.closest('.richtext-toggle__list').querySelectorAll('.richtext-toggle__item');

			// Handle toggling based on the toggle state, if close, then close all the other active items
			if (toggleState === 'close') {
				// Collapse any other active items
				toggleListItems.forEach(item => {
					if (item !== toggleItem && item.classList.contains('active')) {
						item.classList.remove('active');
					}
				});
			}

			toggleItem.classList.toggle('active');
		});
	
		// Mark the button as initialized to prevent duplicate event listeners
		button.classList.add('is-initialized');
		// console.log('toggle initialized');
	});

	// Automatically activate the first toggle item
	const firstToggleItem = document.querySelector('.richtext-toggle__list .richtext-toggle__item');
	if (firstToggleItem) {
		firstToggleItem.classList.add('active');
	}
}
