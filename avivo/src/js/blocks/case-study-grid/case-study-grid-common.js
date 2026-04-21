/**
 * This file contains shared functions and utilities used throughout the website or application.
 * The aim is to centralize commonly used functionality, making it easier to maintain and reuse across different parts.
 *
 * The `initializeCaseStudyMasonary()` function is specifically designed to initialize Case Study Grid functionality. It ensures
 * that only FAQ elements that haven't been initialized yet are set up, preventing duplicate initialization. 
 * Typically, a class like 'is-initialized' is added to each FAQ element once it's been successfully initialized, 
 * so this function checks for that class before proceeding.
 *
 * Usage:
 * - Call the `initializeCaseStudyMasonary()` function to initialize all Case Study Grid elements that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, providing 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the toggle
function initializeCaseStudyMasonary() {
    // Select all FAQ question buttons within the featured FAQ block
	document.querySelectorAll('.cdb-case_study_grid:not(.is-initialized)').forEach(block => {
		block.addEventListener('click', () => {
		});
	
		// Add the 'is-initialized' class to prevent multiple listeners
		block.classList.add('is-initialized');
		//console.log('toggle initialized');

// project shuffle
function shuffle() {
	var $projects = document.querySelector('.case-study-grid');
	if (!$projects) {
		return false;
	}
	var Shuffle = window.Shuffle;
	var $shuffleContainer = document.querySelector('.case-study-grid__shuffle');
	if (!$shuffleContainer) {
		return false;
	}

	var projectShuffle = new Shuffle($shuffleContainer, {
		itemSelector: '.case-study-grid__js-item',
		sizer: '.my-sizer-element',
		buffer: 1,
	});

	var $categoryNav = $projects.querySelector('.case-study-grid__category-nav');
	$categoryNav.addEventListener('click', function(ev) {
		var target = ev.target;
		if (target.hasAttribute('data-group')) {
			var activeLinks = $categoryNav.querySelectorAll('li a.active');
			activeLinks.forEach(function(link) {
				link.classList.remove('active');
			});
			target.classList.add('active');
			projectShuffle.filter(target.getAttribute('data-group'));
		}
		ev.preventDefault();
	});
}

shuffle();

	});
	
}

