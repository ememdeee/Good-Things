// wait until DOM loaded
document.addEventListener("DOMContentLoaded", function() {

	//--------------------------------------------------------------------------
	// Detect Windows OS and add specific class to <body> for button and nav link padding.
	// Purpose:
	// This script checks if the user is on a Windows operating system by examining 
	// the user agent string. If detected, it adds a 'windows-os' class to the <body> tag.
	// This allows you to apply Windows-specific styles to elements like buttons and 
	// navigation links where there might be inconsistencies in padding or alignment 
	// between Windows and macOS browsers due to font rendering differences.
	//
	// Example Use Case:
	// - Apply extra bottom padding for buttons or nav links that appear misaligned 
	//   on Windows (e.g., .windows-os .button { padding-bottom: 0.25rem; }).
	//   This helps maintain consistent spacing across different platforms.
	//
	// Adjust the class name or conditions as needed for other operating systems.
	//--------------------------------------------------------------------------
	if (navigator.userAgent.indexOf('Windows') !== -1) {
		document.body.classList.add('windows-os');
	}
  

	//--------------------------------------------------------------------------
	// navbar height 100, spacing 50. Replace with your navbar height if dynamic
	// or get the navbar height from the element and add spacing 50
	//--------------------------------------------------------------------------
//	const navbarHeight = 100;
	const navbarHeight = document.getElementById('wrapper-navbar').offsetHeight;

	//--------------------------------------------------------------------------
	// This function enables smooth scrolling to anchor links on the page. 
	// It calculates the target element's position and adjusts for a fixed 
	// navbar height to ensure the element is properly aligned in the viewport. 
	// The function also updates the URL hash without reloading the page.
	//--------------------------------------------------------------------------
	function scrollToAnchor() {
		const hash = window.location.hash; // Get the current URL hash

		if (hash) {
			const targetElement = document.querySelector(hash);
			if (targetElement) {
				// Scroll to the target element minus the navbar height
				window.scrollTo({
					top: targetElement.offsetTop - navbarHeight,
					behavior: 'auto' // You can set this to 'smooth' if you want
				});
			}
		}
	}
	scrollToAnchor();

	//--------------------------------------------------------------------------
	// This code attaches click event listeners to all anchor links 
	// that point to internal page anchors (starting with '#'). 
	// When an anchor is clicked, it prevents the default jump behavior, 
	// calculates the target element's position while accounting for 
	// the fixed navbar height, and scrolls smoothly to the target. 
	// It also updates the browser's URL hash using pushState 
	// to reflect the current scroll position without reloading the page.
	//--------------------------------------------------------------------------
	document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
		anchor.addEventListener('click', function (e) {
		e.preventDefault();
	
		const targetId = this.getAttribute('href');
		const targetElement = document.querySelector(targetId);
	
		if (targetElement) {	
			// Smooth scroll to the target position offset by navbar height
			window.scrollTo({
				top: targetElement.offsetTop - navbarHeight,
				behavior: 'smooth'
			});
	
			// Change the URL anchor without reloading the page
			history.pushState(null, null, targetId);
	
			// Optional: Set focus after a delay to avoid interfering with the scroll
			setTimeout(() => {
				targetElement.setAttribute('tabindex', '-1'); // Ensure it can receive focus
				targetElement.focus({ preventScroll: true }); // Prevent browser's default scroll behavior
			}, 300); // Delay in milliseconds, adjust as needed
		} else {
			console.warn(`Target element not found for ID: ${targetId}`);
		}
		});
	});
	  
	
});
