/**
 * This file contains shared functions and utilities used across various parts of the website or application.
 * Its purpose is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeForm()` function is designed to activate slider behavior. It ensures that 
 * navigation elements respond to scrolling by highlighting the corresponding section of the page. 
 * The function checks if a block has already been initialized (by looking for the 'is-initialized' class)
 * to prevent duplicate initialization.
 *
 * Usage:
 * - Call the `initializeForm()` function to enable slider for all eligible elements that haven't 
 *   been initialized yet.
 * - This function is flexible and can be applied both on the front-end and within the block editor, 
 *   ensuring consistent behavior across different environments.
 */
 
// Function to initialize the spy scroll
function initializeForm() {
	// Initialize the slider for each block
	document.querySelectorAll('.cdb-richtext_form:not(.is-initialized)').forEach(block => {
		block.classList.add('is-initialized'); // Mark as initialized

		// Get the budget slider object
		const budgetSlider = block.querySelector('#budgetSlider');

		// Check if the budgetSlider exists before creating the slider
		if (budgetSlider) {
			// Create budget range slider using noUiSlider
			const format = {
				to: function(value) {
					return '$' + Math.round(value) + 'K';
				},
				from: function(value) {
					return Number(value);
				}
			};

			const inpMinBudget = block.querySelector('.budget-min input');
			const inpMaxBudget = block.querySelector('.budget-max input');
			const initialMinBudget = 10;
			const initialMaxBudget = 45;
			const minBudget = 10;
			const maxBudget = 300;

			// Function to set budget values in input fields
			function setBudgetValue(min, max) {
				inpMinBudget.value = '$' + min + 'K';
				inpMaxBudget.value = '$' + max + 'K';
			}

			// Initialize the noUiSlider
			noUiSlider.create(budgetSlider, {
				start: [initialMinBudget, initialMaxBudget],
				step: 1,
				tooltips: true,
				connect: true,
				format: format,
				range: {
					'min': minBudget,
					'max': maxBudget
				}
			});

			// Adjust the minimum and maximum values after the user stops dragging the slider
			budgetSlider.noUiSlider.on('set', function(values, handle) {
				// Remove '$' and 'K', then convert to a number
				const minVal = parseFloat(values[0].replace('$', '').replace('K', ''));
				const maxVal = parseFloat(values[1].replace('$', '').replace('K', ''));

				setBudgetValue(minVal, maxVal);
			});

			// Initialize input values
			setBudgetValue(initialMinBudget, initialMaxBudget);
		}

		// move content description on mobile below the form
		var contentContainer = block.querySelector('.content-container');
		var contentDescription = block.querySelector('.content-container .content__description');
		var contentBelowForm = block.querySelector('.content-container .content__below-form');
		var formContainer = block.querySelector('.form-container');
		if (contentContainer && contentDescription && formContainer && contentBelowForm) {
			let belowFormContainer = document.createElement('div');
			belowFormContainer.classList.add('richtext-form__below-form');
			formContainer.appendChild(belowFormContainer);


			function moveContentDescription() {
				if (window.innerWidth < 991) {
					belowFormContainer.appendChild(contentBelowForm);
				} else {
					contentDescription.appendChild(contentBelowForm);
				}
			}

			moveContentDescription();
			window.addEventListener('resize', moveContentDescription);

			contentContainer.classList.add('with-content-below-form');
		}

		// preven double submission, check gform-loader and set loading class
		const observer = new MutationObserver(function(mutations) {
				mutations.forEach(function(mutation) {
						// console.log('DEBUG: Mutation observed:', mutation);
						mutation.addedNodes.forEach(node => {
								if (node.classList && node.classList.contains('gform-loader')) {
										// console.log('DEBUG: gform-loader added');
										formContainer.classList.add('is-loading');
								}
						});
						mutation.removedNodes.forEach(node => {
								if (node.classList && node.classList.contains('gform-loader')) {
										// console.log('DEBUG: gform-loader removed');
										formContainer.classList.remove('is-loading');
								}
						});
				});

				// Check if no gform-loader element at all and remove is-loading class
				if (!formContainer.querySelector('.gform-loader')) {
						formContainer.classList.remove('is-loading');
				}
		});
		if (formContainer) {
				observer.observe(formContainer, {
						childList: true,
						subtree: true
				});
		}
	});



}

