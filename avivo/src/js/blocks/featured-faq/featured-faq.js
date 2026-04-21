/**
 * This code is used to initialize FAQ toggles on the front end of a WordPress site once the DOM is fully loaded.
 * It ensures that any FAQ toggle elements on the page are properly initialized as soon as the page content is ready.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "featured-faq-common.js"
 * at the top of this file. This ensures that the `initializeFAQtoggle()` function is available for use within this script.
 *
 * Key Elements:
 * - `document.addEventListener('DOMContentLoaded', ...)`: This event listener waits for the entire DOM to be loaded
 *   before executing the code, ensuring all FAQ toggle elements are available for initialization.
 * - `initializeFAQtoggle()`: This function, imported from "featured-faq-common.js", handles the initialization
 *   of any FAQ toggles that haven't been initialized yet. It's called immediately after the DOM is loaded to ensure
 *   the toggles are ready for use.
 *
 * Usage:
 * - This script is intended for use on the front end of a WordPress site. It ensures that FAQ toggles are initialized
 *   immediately after the page content is fully loaded, providing a smooth user experience.
 */

// @prepros-prepend "featured-faq-common.js";

// Wait until DOM loaded
document.addEventListener('DOMContentLoaded', function () {

    // Call initializeFAQtoggle() right after DOM is loaded
    initializeFAQtoggle();
	//console.log('toggle initialized');

});
