/**
 * Extracts the value of a specified query string parameter from a given URL.
 * If no URL is provided, the function uses the current page's URL.
 *
 * @param {string} name - The name of the query string parameter to retrieve.
 * @param {string} [url] - The URL to search for the parameter. Defaults to the current page's URL if not provided.
 * @returns {string|null} - The value of the query string parameter if found. Returns an empty string if the parameter has no value, and `null` if the parameter is not present in the URL.
 *
 * Example usage:
 * // Assuming the URL is 'http://example.com/?debug-repeat=1'
 * var debugRepeat = cd_getParameterByName('debug-repeat');
 * console.log(debugRepeat); // Output: '1'
 *
 * // If the URL is 'http://example.com/?debug-repeat=', the output will be an empty string.
 * var emptyParam = cd_getParameterByName('debug-repeat');
 * console.log(emptyParam); // Output: ''
 */
function cd_getParameterByName(name, url) {
	if (!url) {
		url = window.location.href; // Use the current URL if no URL is provided
	}
	name = name.replace(/[\[\]]/g, '\\$&'); // Escape special characters in parameter name
	var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
		results = regex.exec(url); // Execute regex to find the parameter
	if (!results) return null; // Return null if the parameter is not found
	if (!results[2]) return ''; // Return empty string if parameter is found but has no value
	return decodeURIComponent(results[2].replace(/\+/g, ' ')); // Decode and return the parameter value
}


(function (window) {
    window.cdApp = window.cdApp || {};
    
    var app = window.cdApp;


    // // get querystring
    // // https://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
    // app.getParameterByName = function(name, url) {
    //     if (!url) {
    //         url = window.location.href;
    //     }
    //     name = name.replace(/[\[\]]/g, '\\$&');
    //     var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
    //         results = regex.exec(url);
    //     if (!results) return null;
    //     if (!results[2]) return '';
    //     return decodeURIComponent(results[2].replace(/\+/g, ' '));
    // }    

    app.isIE = function() {
        // // Internet Explorer 6-11
        // return isIE = /*@cc_on!@*/ false || !!document.documentMode;

        // ie 11
        return !!window.MSInputMethodContext && !!document.documentMode;
    }
    
    app.isSafari = function() {
        // Safari 3.0+ "[object HTMLElementConstructor]"
        var isSafari =
        /constructor/i.test(window.HTMLElement) ||
        (function(p) {
            return p.toString() === '[object SafariRemoteNotification]';
        })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

        return isSafari;
        
    }

    app.isiOS = function() {
        var userAgent = window.navigator.userAgent;
        return !!(userAgent.match(/iPad/i) || userAgent.match(/iPhone/i));
    }

    // app.throttle60fps = throttle60fps;

    // app.loadJS = loadJS;

}(window));