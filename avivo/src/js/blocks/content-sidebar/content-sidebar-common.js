function initializeContentSidebar() {
	window.cdApp = window.cdApp || {};

	// this function only runs once
	if (typeof window.cdApp.cdbContentSidebarInitialized !== 'undefined') {
		return;
	}
	window.cdApp.cdbContentSidebarInitialized = true;

	// console.log('DEBUG: content sidebar', document.querySelectorAll('.content-sidebar').length);

	// side subnav for blog category
	cdApp.sidebarBoxToggle = (function() {
		var sidebarBox = document.querySelector('.sidebar-box--dropdown');

		if (!sidebarBox) {
			return false;
		}

		var subNavTitle = 'In this section';
		var toggle = document.createElement('button');
		toggle.className = 'sidebar-box-toggle';
		toggle.textContent = subNavTitle;
		toggle.setAttribute('aria-expanded', 'false');
		toggle.setAttribute('aria-controls', 'sidebar-box');
		sidebarBox.id = 'sidebar-box';

		sidebarBox.parentNode.insertBefore(toggle, sidebarBox);

		toggle.addEventListener('click', function () {
			var isOpen = this.getAttribute('aria-expanded') === 'true';
			this.setAttribute('aria-expanded', !isOpen);
			this.classList.toggle('open');
			sidebarBox.classList.toggle('open');
		});

		toggle.addEventListener('keydown', function (event) {
			if (event.key === 'Enter' || event.key === ' ') {
				event.preventDefault();
				this.click();
			}
		});
	})();
}