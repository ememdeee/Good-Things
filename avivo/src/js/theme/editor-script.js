/**
 * Disable click behavior for external and non-anchor links within Gutenberg blocks 
 * wrapped in '.section' while allowing anchor links (starting with '#') to function 
 * normally for in-page navigation.
 *
 * This script executes only in the Gutenberg editor, preventing unintended link actions 
 * during content editing. It ensures that external links do not open when clicked, 
 * while still allowing anchor links to work as expected.
 *
 * A delay of 500ms is implemented to ensure that all blocks are fully loaded 
 * before applying the link restrictions. Adjust the delay if necessary.
 */

wp.domReady(() => {
	if (navigator.userAgent.indexOf('Windows') !== -1) {
		document.body.classList.add('windows-os');
	}
	
	// Function to prevent clicks on links
	const preventLinkClicks = () => {
		const sections = document.querySelectorAll('.editor-visual-editor .block-editor-block-list__layout section.section a:not([href^="#"])');

		sections.forEach(function(link) {
			// Ensure the event listener is only added once
			if (!link.dataset.preventClick) {
				link.dataset.preventClick = 'true'; // Flag to indicate the listener is added
				link.addEventListener('click', function(event) {
					event.preventDefault(); // Stop default click action
					event.stopImmediatePropagation(); // Prevent other click handlers from executing
				});
			}
		});
	};

	// Initial call to apply link prevention when the editor loads
	setTimeout(preventLinkClicks, 500);

	// Subscribe to editor state changes
	let previousBlockCount = wp.data.select('core/block-editor').getBlockCount();

	wp.data.subscribe(() => {
		const currentBlockCount = wp.data.select('core/block-editor').getBlockCount();

		// Only re-run if block count has changed (a new block was added or removed)
		if (currentBlockCount !== previousBlockCount) {
			previousBlockCount = currentBlockCount;
			preventLinkClicks(); // Reapply link prevention for new or updated blocks
		}
	});

});

