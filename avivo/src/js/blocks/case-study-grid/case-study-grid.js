/**
 * This code is used to initialize Case Study Grid on the front end of a WordPress site once the DOM is fully loaded.
 * It ensures that any Case Study Grid elements on the page are properly initialized as soon as the page content is ready.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "case-study-grid-common.js"
 * at the top of this file. This ensures that the `initializeCaseStudyMasonary()` function is available for use within this script.
 *
 * Key Elements:
 * - `document.addEventListener('DOMContentLoaded', ...)`: This event listener waits for the entire DOM to be loaded
 *   before executing the code, ensuring all Case Study Grid elements are available for initialization.
 * - `initializeCaseStudyMasonary()`: This function, imported from "case-study-grid-common.js", handles the initialization
 *   of any Case Study Grid that haven't been initialized yet. It's called immediately after the DOM is loaded to ensure
 *   the toggles are ready for use.
 *
 * Usage:
 * - This script is intended for use on the front end of a WordPress site. It ensures that Case Study Grid are initialized
 *   immediately after the page content is fully loaded, providing a smooth user experience.
 */

// @prepros-prepend "case-study-grid-common.js";

// Wait until DOM loaded
document.addEventListener('DOMContentLoaded', function () {

    // Call initializeCaseStudyMasonary() right after DOM is loaded
    initializeCaseStudyMasonary();
	//console.log('toggle initialized');

});
