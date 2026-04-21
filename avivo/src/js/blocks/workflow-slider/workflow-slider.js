/**
 * This code is used to initialize sliders on the front end of a WordPress site once the DOM is fully loaded.
 * It ensures that any slider elements on the page are properly initialized as soon as the page content is ready.
 *
 * The `@prepros-prepend` directive is used by Prepros to include the shared functions from "workflow-slider-common.js"
 * at the top of this file. This ensures that the `initializeWorkflowSlider()` function is available for use within this script.
 *
 * Key elements:
 * - `document.addEventListener('DOMContentLoaded', ...)`: This event listener waits for the entire DOM to be loaded
 *   before executing the code inside it, ensuring that all slider elements are available for initialization.
 * - `initializeWorkflowSlider()`: This function, imported from "workflow-slider-common.js", handles the initialization
 *   of any sliders that haven't been initialized yet. It's called immediately after the DOM is loaded to ensure
 *   that the sliders are ready for use.
 *
 * Usage:
 * - This script is intended for use on the front end of a WordPress site. It ensures that sliders are initialized
 *   immediately after the page content is fully loaded, providing a smooth user experience.
 */

// @prepros-prepend "workflow-slider-common.js";

// Wait until DOM loaded
document.addEventListener('DOMContentLoaded', function () {

    // Call initializeWorkflowSlider() right after DOM is loaded
    initializeWorkflowSlider();

});
