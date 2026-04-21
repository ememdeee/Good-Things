/**
 * This script initializes scroll spy functionality on the front end of a WordPress site once the DOM is fully loaded.
 * It ensures that any scroll spy elements are properly set up as soon as the page content is ready.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "richtext-form-common.js"
 * at the top of this file. This ensures that the `initializeForm()` function is available within this script.
 *
 * Key Elements:
 * - `document.addEventListener('DOMContentLoaded', ...)`: This event listener waits until the entire DOM is fully loaded 
 *   before executing the code, ensuring that all scroll spy elements are available for initialization.
 * - `initializeForm()`: This function, imported from "richtext-form-common.js", handles the initialization 
 *   of scroll spy functionality for elements that haven't been initialized yet. It is executed immediately after the 
 *   DOM is loaded.
 *
 * Usage:
 * - This script is meant for the front end of a WordPress site. It ensures that scroll spy behavior is ready as soon as 
 *   the page content has fully loaded, contributing to a seamless user experience.
 */

// @prepros-prepend "richtext-form-common.js";

// Wait until DOM loaded
document.addEventListener('DOMContentLoaded', function () {

    // Call initializeForm() right after DOM is loaded
    initializeForm();
	//console.log('SpyScroll initialized');

});
