/**
 * This script initializes Toggle elements on the front end of a WordPress site once the DOM is fully loaded.
 * It ensures that all Toggle elements are properly activated as soon as the page content is ready.
 *
 * The `@prepros-prepend` directive is used by Prepros to include shared functions from "richtext-toggle-common.js"
 * at the beginning of this file. This guarantees the availability of the `initializeToggle()` function within the script.
 *
 * Key Features:
 * - `document.addEventListener('DOMContentLoaded', ...)`: This event listener waits for the full DOM to load before
 *   executing the code, ensuring all Toggle elements are present for initialization.
 * - `initializeToggle()`: This function, sourced from "richtext-toggle-common.js", handles the setup of all uninitialized
 *   Toggle elements. It's triggered immediately after the DOM is loaded to make sure toggles are functional.
 *
 * Usage:
 * - This script is meant for use on the front end of a WordPress site. It ensures that Toggles are initialized
 *   once the page content is fully loaded, providing a seamless user experience.
 */

// @prepros-prepend "richtext-toggle-common.js";

// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {

    // Initialize Toggles after DOM load
    initializeToggle();
    // console.log('Toggle initialized');

});