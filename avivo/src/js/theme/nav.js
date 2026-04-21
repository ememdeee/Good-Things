// wait until DOM loaded
document.addEventListener('DOMContentLoaded', function () {


  const body = document.body;

  //-----------------------------------
  // body scrolled
  //-----------------------------------
  // Function to handle scroll logic
  function handleScroll() {
    if (window.scrollY > 60) { // Check if scrolled past 60px (the menu bar height on mobile)
      body.classList.add('isScrolled');
    } else {
      body.classList.remove('isScrolled');
    }
  }

  // Run the scroll check on page load
  handleScroll();

  // Run the scroll check when the user scrolls
  window.addEventListener('scroll', handleScroll);

  //-----------------------------------
  // Navbar hover
  //-----------------------------------
  // Function to handle hover logic
  function handleHover(isNavHovering) {
    if (isNavHovering) {
      body.classList.add('isNavHover');
    } else {
      body.classList.remove('isNavHover');
    }
  }

  // Get the navbar element
  const navbar = document.getElementById('wrapper-navbar');

  // Add event listeners for hover
  if (navbar) {
    navbar.addEventListener('mouseenter', () => handleHover(true));
    navbar.addEventListener('mouseleave', () => handleHover(false));
  }



  //-----------------------------------
  // megamenu
  //-----------------------------------
  function initMegamenu() {
    // Get all sections with class 'cdb-megamenu'
    var megaMenus = document.querySelectorAll('.cdb-megamenu');

    // Loop through each section
    megaMenus.forEach(function (megaMenu) {
      // Get the value from the 'data-menuid' attribute
      var menuId = megaMenu.getAttribute('data-menuid');

      if (menuId) {
        // Find the corresponding <li> by constructing the menu-item ID
        var menuItem = document.querySelector(`#menu-item-${menuId} > .dropdown-menu`);

        // If the corresponding menu item is found, replace the <ul> with the <section>
        if (menuItem) {
          menuItem.parentNode.replaceChild(megaMenu, menuItem);
        }
      }
    });
  }

  // Call the function to perform the replacement
  initMegamenu();


  //-----------------------------------
  // Mobile nav
  //-----------------------------------

  // // set the first child of menu (service) to active
  // let firstChild = document.querySelector('.mobile-menu > li:first-child');
  // firstChild.setAttribute('data-nav-active', 'true');

  var mobileNav = new hcOffcanvasNav('#mobileMenu', {
  	width: 430,
  	position: 'right',
  	disableAt: 1200,				// mobile nav breakpoint
  	levelOpen: 'expand',		// options: 'overlap', 'expand', 'none' or false.
  	levelSpacing: 0,			// default: 40
  	removeOriginalNav: true,	// remove the original mobile nav
  	swipeGestures: false,
  	closeOnClick: false
  });

  // mobileNav.on('open', (e, settings) => {
  // 	mobileNav.open(1,0);
  // });

  // set delay
  setTimeout(() => {
  	// Get the nav burger element
  	const navTrigger = document.querySelector('a.hc-nav-trigger');

  	// Add event listeners for hover if navTrigger exists
  	if (navTrigger) {
  		navTrigger.addEventListener('mouseenter', () => handleHover(true));
  		navTrigger.addEventListener('mouseleave', () => handleHover(false));
  	}

  	// Get the logo and cta element from the footer
  	var logoMarkup = document.getElementById('mobile_nav_brand');
  	var ctaMarkup = document.getElementById('mobile_nav_cta');
  	var navContainer = document.querySelector('.hc-offcanvas-nav');
  	var quickLinksMarkup = document.querySelector('.mobile_nav_quick-links');
    var mobileMenu = document.querySelector('.hc-offcanvas-nav .mobile-menu');

  	// If the logo exists and it's not already in the nav, insert it
  	if (logoMarkup && !document.querySelector('.hc-offcanvas-nav .mobile-brand__wrapper')) {
  		if (navContainer) {
  			// Append the logo to the mobile nav container
  			navContainer.insertAdjacentElement('afterbegin', logoMarkup);
  		}
  	}

    if (quickLinksMarkup && !document.querySelector('.hc-offcanvas-nav .mobile_nav_quick-links')) {
  		if (navContainer) {
          mobileMenu.insertAdjacentElement('afterend', quickLinksMarkup);
  		}
  	}

  	// If the cta exists and it's not already in the nav, insert it
  	if (ctaMarkup && !document.querySelector('.hc-offcanvas-nav .mobile-cta__wrapper')) {
  		if (navContainer) {
  			// Append the logo to the mobile nav container
  			navContainer.insertAdjacentElement('beforeend', ctaMarkup);
  		}
  	}


  }, 500);



// ClueEdit: workaround for mobile nav search, the mobile nav library keep closing whenever non link element inside it clicked, and we append the mobile nav search outside mobile nav
document.querySelectorAll('.mobile-nav-search').forEach(el => {
  el.addEventListener('click', event => {
    event.stopPropagation();
  });
});











});



// navbar with basic accessibility
(function () {
  class CDNavBar {
    constructor(selector) {
      this.navbar = document.querySelector(selector);
      if (!this.navbar) return;

      this.currentFocus = null;
      this.init();
    }

    init() {
      this.setupAccessibility();
      this.setupHoverBehavior();
      this.setupKeyboardNavigation();
    }

    setupAccessibility() {
      // Set proper ARIA attributes
      const dropdownToggles = this.navbar.querySelectorAll('.dropdown-toggle');

      dropdownToggles.forEach(toggle => {
        const menuId = toggle.id.replace('menu-item-dropdown-', 'megamenu-');
        let dropdown = document.getElementById(menuId);

        if (!dropdown) {
          dropdown = toggle.nextElementSibling;
        }

        if (dropdown) {
          toggle.setAttribute('aria-expanded', 'false');
          toggle.setAttribute('aria-haspopup', 'true');
          dropdown.setAttribute('aria-hidden', 'true');
        }
      });
    }

    setupHoverBehavior() {
      const menuItems = this.navbar.querySelectorAll('.menu-item-has-children');

      menuItems.forEach(item => {
        let hoverTimeout;

        item.addEventListener('mouseenter', () => {
          clearTimeout(hoverTimeout);
          this.showDropdown(item);
        });

        item.addEventListener('mouseleave', () => {
          hoverTimeout = setTimeout(() => {
            this.hideDropdown(item);
          }, 150);
        });
      });

      // Mouse focus management
      this.navbar.addEventListener('mouseenter', () => {
        document.body.classList.add('mouse-nav');
      });

      this.navbar.addEventListener('mouseleave', () => {
        document.body.classList.remove('mouse-nav');
      });
    }

    setupKeyboardNavigation() {
      this.navbar.addEventListener('keydown', (e) => {
        this.handleKeyPress(e);
      });

      this.navbar.addEventListener('focusin', (e) => {
        this.currentFocus = e.target;
      });
    }

    handleKeyPress(e) {
      const { key } = e;

      switch (key) {
        case 'ArrowRight':
          e.preventDefault();
          this.handleRightKey();
          break;
        case 'ArrowLeft':
          e.preventDefault();
          this.handleLeftKey();
          break;
        case 'ArrowDown':
          e.preventDefault();
          this.handleDownKey();
          break;
        case 'ArrowUp':
          e.preventDefault();
          this.handleUpKey();
          break;
        case 'Enter':
        case ' ':
          if (this.currentFocus?.classList.contains('dropdown-toggle')) {
            e.preventDefault();
            this.toggleCurrentDropdown();
          }
          break;
        case 'Escape':
          e.preventDefault();
          this.closeAllDropdowns();
          this.focusFirstMainItem();
          break;
        case 'Tab':
          setTimeout(() => {
            if (!this.navbar.contains(document.activeElement)) {
              this.closeAllDropdowns();
            }
          }, 0);
          break;
      }
    }

    handleRightKey() {
      const level = this.getCurrentLevel();

      if (level === 1) {
        // Main level: move to next main item
        this.moveToNextMainItem();
      } else {
        // Inside dropdown: open child submenu if available
        this.openChildSubmenu();
      }
    }

    handleLeftKey() {
      const level = this.getCurrentLevel();

      if (level === 1) {
        // Main level: move to previous main item
        this.moveToPreviousMainItem();
      } else {
        // Inside dropdown: go up one level
        this.goUpOneLevel();
      }
    }

    handleDownKey() {
      const level = this.getCurrentLevel();

      if (level === 1) {
        // Main level: open dropdown
        this.openCurrentMainDropdown();
      } else {
        // Inside dropdown: move to next item at same level
        this.moveToNextItemSameLevel();
      }
    }

    handleUpKey() {
      const level = this.getCurrentLevel();

      if (level === 1) {
        // Main level: do nothing
        return;
      } else {
        // Inside dropdown: move to previous item or go up level
        this.moveToPreviousItemOrUpLevel();
      }
    }

    getCurrentLevel() {
      if (!this.currentFocus) return 1;

      // Check if we're inside any dropdown
      const inMegamenu = this.currentFocus.closest('.cdb-megamenu');
      const inDropdown = this.currentFocus.closest('.dropdown-menu');

      if (inMegamenu || inDropdown) {
        // Count how deep we are
        let level = 1;
        let element = this.currentFocus;

        while (element && element !== this.navbar) {
          if (element.classList.contains('dropdown-menu') || element.classList.contains('cdb-megamenu')) {
            level++;
          }
          element = element.parentElement;
        }

        return level;
      }

      return 1; // Main level
    }

    moveToNextMainItem() {
      const mainItems = Array.from(this.navbar.children);
      const currentMainItem = this.getCurrentMainItem();
      const currentIndex = mainItems.indexOf(currentMainItem);

      if (currentIndex !== -1 && currentIndex < mainItems.length - 1) {
        this.closeAllDropdowns();
        const nextItem = mainItems[currentIndex + 1];
        const nextLink = nextItem.querySelector('.nav-link');
        if (nextLink) {
          nextLink.focus();
        }
      }
    }

    moveToPreviousMainItem() {
      const mainItems = Array.from(this.navbar.children);
      const currentMainItem = this.getCurrentMainItem();
      const currentIndex = mainItems.indexOf(currentMainItem);

      if (currentIndex > 0) {
        this.closeAllDropdowns();
        const prevItem = mainItems[currentIndex - 1];
        const prevLink = prevItem.querySelector('.nav-link');
        if (prevLink) {
          prevLink.focus();
        }
      }
    }

    openCurrentMainDropdown() {
      const mainItem = this.getCurrentMainItem();
      if (mainItem && mainItem.classList.contains('menu-item-has-children')) {
        this.showDropdown(mainItem);
        const dropdown = mainItem.querySelector('.dropdown-menu, .cdb-megamenu');
        if (dropdown) {
          const firstItem = dropdown.querySelector('.dropdown-item, .nav-link');
          if (firstItem) {
            firstItem.focus();
          }
        }
      }
    }

    openChildSubmenu() {
      const currentItem = this.currentFocus?.closest('.nav-item');
      if (currentItem && currentItem.classList.contains('menu-item-has-children')) {
        const childDropdown = currentItem.querySelector('.dropdown-menu');
        if (childDropdown) {
          this.showDropdown(currentItem);
          const firstChild = childDropdown.querySelector('.dropdown-item, .nav-link');
          if (firstChild) {
            firstChild.focus();
          }
        }
      }
    }

    goUpOneLevel() {
      const currentDropdown = this.getCurrentDropdownContainer();
      if (!currentDropdown) return;

      const parentItem = currentDropdown.closest('.nav-item');
      if (!parentItem) return;

      // Check if parent is in another dropdown (3rd level going to 2nd)
      const parentDropdown = parentItem.parentElement;
      if (parentDropdown && (parentDropdown.classList.contains('dropdown-menu') || parentDropdown.classList.contains('cdb-megamenu'))) {
        // Go to parent dropdown item
        const parentLink = parentItem.querySelector('.dropdown-item, .nav-link');
        if (parentLink) {
          parentLink.focus();
        }
      } else {
        // Go to main level
        const mainLink = parentItem.querySelector('.nav-link');
        if (mainLink) {
          mainLink.focus();
        }
      }
    }

    moveToNextItemSameLevel() {
      const siblings = this.getCurrentLevelSiblings();
      const currentIndex = siblings.indexOf(this.currentFocus);

      if (currentIndex !== -1 && currentIndex < siblings.length - 1) {
        siblings[currentIndex + 1].focus();
      }
    }

    moveToPreviousItemOrUpLevel() {
      const siblings = this.getCurrentLevelSiblings();
      const currentIndex = siblings.indexOf(this.currentFocus);

      if (currentIndex > 0) {
        // Move to previous sibling
        siblings[currentIndex - 1].focus();
      } else {
        // Go up one level (we're at first item)
        this.goUpOneLevel();
      }
    }

    getCurrentMainItem() {
      if (!this.currentFocus) return null;
      return this.currentFocus.closest('#main-menu > .nav-item');
    }

    getCurrentDropdownContainer() {
      if (!this.currentFocus) return null;

      let element = this.currentFocus;
      while (element && element !== this.navbar) {
        if (element.classList.contains('dropdown-menu') || element.classList.contains('cdb-megamenu')) {
          return element;
        }
        element = element.parentElement;
      }
      return null;
    }

    getCurrentLevelSiblings() {
      const currentDropdown = this.getCurrentDropdownContainer();
      if (!currentDropdown) return [];

      // Get direct children that are menu items
      return Array.from(currentDropdown.children)
        .filter(child => child.classList.contains('nav-item'))
        .map(item => item.querySelector('.dropdown-item, .nav-link'))
        .filter(link => link !== null);
    }

    showDropdown(menuItem) {
      const toggle = menuItem.querySelector('.dropdown-toggle, .dropdown-item');
      const dropdown = menuItem.querySelector('.dropdown-menu, .cdb-megamenu');

      if (dropdown) {
        if (toggle) {
          toggle.setAttribute('aria-expanded', 'true');
        }
        dropdown.setAttribute('aria-hidden', 'false');
      }
    }

    hideDropdown(menuItem) {
      const toggle = menuItem.querySelector('.dropdown-toggle, .dropdown-item');
      const dropdown = menuItem.querySelector('.dropdown-menu, .cdb-megamenu');

      if (dropdown) {
        if (toggle) {
          toggle.setAttribute('aria-expanded', 'false');
        }
        dropdown.setAttribute('aria-hidden', 'true');

        // Close nested dropdowns
        const nestedDropdowns = dropdown.querySelectorAll('.dropdown-menu');
        nestedDropdowns.forEach(nested => {
          nested.setAttribute('aria-hidden', 'true');
          const nestedParent = nested.closest('.nav-item');
          if (nestedParent) {
            const nestedToggle = nestedParent.querySelector('.dropdown-item, .nav-link');
            if (nestedToggle && nestedToggle.hasAttribute('aria-expanded')) {
              nestedToggle.setAttribute('aria-expanded', 'false');
            }
          }
        });
      }
    }

    toggleCurrentDropdown() {
      const currentItem = this.currentFocus?.closest('.menu-item-has-children');
      if (!currentItem) return;

      const toggle = currentItem.querySelector('.dropdown-toggle');
      const isExpanded = toggle?.getAttribute('aria-expanded') === 'true';

      if (isExpanded) {
        this.hideDropdown(currentItem);
      } else {
        this.closeAllDropdowns();
        this.showDropdown(currentItem);
      }
    }

    closeAllDropdowns() {
      const allMenuItems = this.navbar.querySelectorAll('.menu-item-has-children');
      allMenuItems.forEach(item => {
        this.hideDropdown(item);
      });
    }

    focusFirstMainItem() {
      const firstMainLink = this.navbar.querySelector('#main-menu > .nav-item .nav-link');
      if (firstMainLink) {
        firstMainLink.focus();
      }
    }
  }

  // Initialize when DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
    new CDNavBar('#main-menu');
  });

  // CSS for mouse navigation
  const style = document.createElement('style');
  style.textContent = `
  .mouse-nav *:focus {
    outline: none !important;
    border-color: transparent !important;
  }
`;
  document.head.appendChild(style);
}());

















// dropdown
(function () {
  document.addEventListener('DOMContentLoaded', () => {
    const cdDropdowns = document.querySelectorAll('.cd-dropdown'); // Select the main .cd-dropdown container

    // Function to close all open dropdowns
    function closeAllCDDropdowns() {
      document.querySelectorAll('.cd-dropdown__menu--show').forEach(menu => {
        menu.classList.remove('cd-dropdown__menu--show');
        // Find the associated toggle button
        const toggle = menu.previousElementSibling; // Assuming menu is direct sibling
        if (toggle && toggle.classList.contains('cd-dropdown__toggle')) {
          toggle.setAttribute('aria-expanded', 'false');
          toggle.removeAttribute('data-opened-by-click'); // Clear click state on close
          toggle.classList.remove('is-active');
        }
      });
    }

    // Helper to open a specific dropdown
    function openCDDropdown(menu, toggle) {
      if (!menu.classList.contains('cd-dropdown__menu--show')) {
        closeAllCDDropdowns(); // Close others first
        menu.classList.add('cd-dropdown__menu--show');
        toggle.setAttribute('aria-expanded', 'true');
        toggle.classList.add('is-active');
        // Optional: focus on first item when opened by click/keyboard
        // (Prevents accidental focus when opened purely by hover)
        if (toggle.dataset.openedByClick === 'true') {
          const firstItem = menu.querySelector('.cd-dropdown__item:not([disabled])');
          if (firstItem) {
            firstItem.focus();
          }
        }
      }
    }

    // Helper to close a specific dropdown
    function closeCDDropdown(menu, toggle) {
      if (menu.classList.contains('cd-dropdown__menu--show')) {
        menu.classList.remove('cd-dropdown__menu--show');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.removeAttribute('data-opened-by-click'); // Clear click state on close
        toggle.classList.remove('is-active');
      }
    }

    cdDropdowns.forEach(dropdownContainer => {
      const toggle = dropdownContainer.querySelector('.cd-dropdown__toggle');
      const dropdownMenu = dropdownContainer.querySelector('.cd-dropdown__menu');

      if (!toggle || !dropdownMenu) {
        console.error('Missing toggle or menu in .cd-dropdown container:', dropdownContainer);
        return;
      }

      // --- Basic Setup & Accessibility ---
      if (!dropdownMenu.id) {
        dropdownMenu.id = `${toggle.id || 'cd-dropdown'}-menu`;
      }
      toggle.setAttribute('aria-controls', dropdownMenu.id);

      // Store timeouts unique to this dropdown instance
      let openTimeoutId = null;
      let closeTimeoutId = null;

      // --- Click Toggle (always active for accessibility and primary for touch) ---
      toggle.addEventListener('click', (event) => {
        event.stopPropagation(); // Stop propagation to prevent document click from closing immediately

        // Clear any pending hover timeouts when clicked, as click takes precedence
        clearTimeout(openTimeoutId);
        clearTimeout(closeTimeoutId);

        if (dropdownMenu.classList.contains('cd-dropdown__menu--show')) {
          closeCDDropdown(dropdownMenu, toggle);
        } else {
          // If opening via click, ensure others are closed and mark this one as click-opened
          openCDDropdown(dropdownMenu, toggle);
          toggle.setAttribute('data-opened-by-click', 'true');
        }
      });

      // --- Hover Functionality (if .cd-dropdown--hover class is present) ---
      if (dropdownContainer.classList.contains('cd-dropdown--hover')) {
        const hoverOpenDelay = 200; // milliseconds
        const hoverCloseDelay = 300; // milliseconds

        dropdownContainer.addEventListener('mouseenter', () => {
          clearTimeout(closeTimeoutId); // Cancel any pending close
          // Only open if not already open (or explicitly clicked open)
          if (!dropdownMenu.classList.contains('cd-dropdown__menu--show') || toggle.dataset.openedByClick === 'true') {
            openTimeoutId = setTimeout(() => {
              openCDDropdown(dropdownMenu, toggle);
              // Do NOT remove data-opened-by-click here, if it was clicked.
              // It will only be removed when explicitly closed.
            }, hoverOpenDelay);
          }
        });

        dropdownContainer.addEventListener('mouseleave', () => {
          clearTimeout(openTimeoutId); // Cancel any pending open

          // Only close on mouseleave if it was NOT opened by a click
          if (toggle.dataset.openedByClick !== 'true') {
            closeTimeoutId = setTimeout(() => {
              closeCDDropdown(dropdownMenu, toggle);
            }, hoverCloseDelay);
          }
        });
      }
    });

    // --- Global Handlers ---

    // Close dropdowns when clicking outside
    document.addEventListener('click', (event) => {
      // If the click target is NOT within any .cd-dropdown container
      if (!event.target.closest('.cd-dropdown')) {
        closeAllCDDropdowns();
      }
    });

    // Close dropdowns when Escape key is pressed
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeAllCDDropdowns();
        // Optional: return focus to the toggle button that was active
        const activeToggle = document.querySelector('.cd-dropdown__toggle[aria-expanded="true"]');
        if (activeToggle) {
          activeToggle.focus();
        }
      }
    });

    // Keyboard navigation within the dropdown menu (only works if opened and focused)
    document.querySelectorAll('.cd-dropdown__menu').forEach(menu => {
      menu.addEventListener('keydown', (event) => {
        const focusableItems = Array.from(menu.querySelectorAll('.cd-dropdown__item:not([disabled])'));
        const focusedItem = document.activeElement;
        const focusedIndex = focusableItems.indexOf(focusedItem);

        if (event.key === 'ArrowDown') {
          event.preventDefault();
          const nextIndex = (focusedIndex + 1) % focusableItems.length;
          focusableItems[nextIndex].focus();
        } else if (event.key === 'ArrowUp') {
          event.preventDefault();
          const prevIndex = (focusedIndex - 1 + focusableItems.length) % focusableItems.length;
          focusableItems[prevIndex].focus();
        } else if (event.key === 'Tab') {
          // If tabbing out of the last item or shift-tabbing out of the first
          // close the dropdown and potentially move focus to the toggle.
          if ((focusedIndex === focusableItems.length - 1 && !event.shiftKey) || (focusedIndex === 0 && event.shiftKey)) {
            closeAllCDDropdowns();
            // If shift-tabbing from first, return focus to toggle
            if (focusedIndex === 0 && event.shiftKey) {
              const toggle = menu.previousElementSibling; // Assuming direct sibling
              if (toggle && toggle.classList.contains('cd-dropdown__toggle')) {
                toggle.focus();
              }
            }
          }
        }
      });
    });
  });
}());




































// (function (window) {
//   // // jquery version
//   // window.cdApp = window.cdApp || {};

//   // cdApp.GlobalNav = (function() {
//   // 	var selectors = {
//   // 		body: 'body',
//   // 		close: '.global-nav-close',
//   // 		sideNav: '.global-nav',
//   // 		primary: '.global-nav-primary',
//   // 		backgrounds: '.global-nav-menu__backgrounds > div'
//   // 	};

//   // 	var config = {
//   // 		activeClass: 'global-nav-open',
//   // 		closingClass: 'global-nav-closing',
//   // 		searchActiveClass: 'searchbar-active'
//   // 	};

//   // 	var cache = {};

//   // 	function init(container) {
//   // 		// console.log('DEBUG: global nav init', container);

//   // 		// $('<li><a class="global-nav-toggle">SideNav</a></li>').appendTo('#AccessibleNav #SiteNav');

//   // 		cacheSelectors(container);

//   // 		//cache.$toggle.on('click',toggle);

//   // 		cache.$toggle.on('click',function(ev) {
//   // 			$(this).toggleClass("is-active");
//   // 			toggle();
//   // 		});  

//   // 		cache.$close.on('click',function(ev) {
//   // 		 $(".global-nav-toggler").removeClass("is-active");
//   // 			if (ev) {
//   // 				ev.preventDefault();
//   // 			}
//   // 			close();
//   // 		});      


//   // 		/*$('body')[0].addEventListener('headerUpdated', function(ev) {
//   // 			// console.log('DEBUG: target', $(container));

//   // 			// if ($('body').hasClass('on-scroll')) {
//   // 			//   $(container).css('top', '0px');

//   // 			// } else {
//   // 				$(container).css('top', ev.detail.announcementBarHeight + 'px');        
//   // 			// }

//   // 		}.bind(this), false);*/


//   // 	//   primaryNav();
//   // 	}

//   // 	function cacheSelectors(container) {
//   // 		cache = {
//   // 			$document: $(document),
//   // 			$body: $('body'),
//   // 			container: container,
//   // 			$container:$(container),
//   // 			$toggle: $('.global-nav-toggle'),
//   // 			$close: $('.global-nav-close'),
//   // 			$primary: $(selectors.primary),
//   // 			$backgrounds: $(selectors.backgrounds)
//   // 		};
//   // 	}

//   // 	function open(ev) {
//   // 		var target = ev && ev.currentTarget;
//   // 		$(window).scrollTop(0);
//   // 		if (ev) {
//   // 			ev.preventDefault();
//   // 		}
//   // 		cache.$body.addClass(config.activeClass);
//   // 		cache.$body.addClass(config.searchActiveClass);

//   // 	}

//   // 	function close(ev) {
//   // 		cache.$body.addClass(config.closingClass);
//   // 		window.setTimeout(function() {
//   // 			cache.$body.removeClass(config.activeClass+' '+config.closingClass);
//   // 			cache.$body.removeClass(config.searchActiveClass);
//   // 		},0);
//   // 	}

//   // 	function toggle(ev) {
//   // 		if (cache.$body.hasClass(config.activeClass)) {
//   // 			close(ev);
//   // 		} else {
//   // 			open(ev);
//   // 		}
//   // 	}

//   // 	// function primaryNav() {
//   // 	//   // console.log('DEBUG: primary nav', cache.$primary);
//   // 	//   cache.$primary.find('li').hover(function(ev){
//   // 	//     var index = $(this).data('index');
//   // 	//     // console.log('DEBUG: hover index', index);
//   // 	//     if (index) {
//   // 	//       cache.$backgrounds.filter('[data-index="'+ index +'"]').addClass('active');
//   // 	//     }
//   // 	//   }, function(ev){
//   // 	//     cache.$backgrounds.removeClass('active');
//   // 	//   });
//   // 	// }

//   // 	function unload() {
//   // 	}

//   // 	return {
//   // 		init: init,
//   // 		unload: unload
//   // 	};
//   // })();


//   // cdApp.GlobalNav.init($('.global-nav-wrapper')[0]);


//   // non jquery version
//   window.cdApp = window.cdApp || {};

//   cdApp.GlobalNav = (function () {
//     var selectors = {
//       body: "body",
//       close: ".global-nav-close",
//       sideNav: ".global-nav",
//       primary: ".global-nav-primary",
//       backgrounds: ".global-nav-menu__backgrounds > div",
//     };

//     var config = {
//       activeClass: "global-nav-open",
//       closingClass: "global-nav-closing",
//       searchActiveClass: "searchbar-active",
//     };

//     var cache = {};

//     function init(container) {
//       cacheSelectors(container);

//       // Add event listener to toggle button
//       cache.toggle.addEventListener("click", function () {
//         this.classList.toggle("is-active");
//         toggle();
//       });

//       // Add event listener to close button
//       cache.close.addEventListener("click", function (ev) {
//         document.querySelector(".global-nav-toggler").classList.remove("is-active");
//         if (ev) {
//           ev.preventDefault();
//         }
//         close();
//       });

//       /* Example commented functionality:
//       document.body.addEventListener("headerUpdated", function (ev) {
//         container.style.top = `${ev.detail.announcementBarHeight}px`;
//       });
//       */
//     }

//     function cacheSelectors(container) {
//       cache = {
//         document: document,
//         body: document.querySelector(selectors.body),
//         container: container,
//         toggle: document.querySelector(".global-nav-toggle"),
//         close: document.querySelector(selectors.close),
//         primary: document.querySelector(selectors.primary),
//         backgrounds: document.querySelectorAll(selectors.backgrounds),
//       };
//     }

//     function open(ev) {
//       if (ev) {
//         ev.preventDefault();
//       }
//       window.scrollTo(0, 0);
//       cache.body.classList.add(config.activeClass);
//       cache.body.classList.add(config.searchActiveClass);
//     }

//     function close(ev) {
//       cache.body.classList.add(config.closingClass);
//       setTimeout(function () {
//         cache.body.classList.remove(config.activeClass, config.closingClass);
//         cache.body.classList.remove(config.searchActiveClass);
//       }, 0);
//     }

//     function toggle(ev) {
//       if (cache.body.classList.contains(config.activeClass)) {
//         close(ev);
//       } else {
//         open(ev);
//       }
//     }

//     function unload() { }

//     return {
//       init: init,
//       unload: unload,
//     };
//   })();

//   // Initialize the GlobalNav
//   cdApp.GlobalNav.init(document.querySelector(".global-nav-wrapper"));


//   // slinky menu
//   // not sure why there's delay
//   setTimeout(function () {
//     // console.log('DEBUG: slinky menu');
//     // var $globalMenu = $('.global-menu-container');
//     var $globalMenu = document.querySelector('.global-menu-container');


//     // // flatten column nav child to same level as column nav, and remove column nav
//     // $globalMenu.find('.megamenu__col').each(function() {
//     //     // console.log('DEBUG: hello');
//     //     var $col = $(this);
//     //     var $subNavItems = $col.find('> .sub-menu > li');
//     //     $subNavItems.insertAfter($col);
//     //     $col.remove();
//     // });

//     // var $slinky = $globalMenu.slinky({
//     // 		'title': true,
//     // 		'theme': 'slinky-nav'
//     //  });          

//     const menu = new Slinky('.global-menu-container', {
//       'title': true,
//       'theme': 'slinky-nav'
//     })

//     /*
//    // jump to parent of current page
//    var $currentMenuItem = $globalMenu.find('.current-menu-item');
//    var $targetJump = false;
//    // when we are in parent page, jump to parent page
//    if ($currentMenuItem.hasClass('menu-item-has-children')) {
//        $targetJump = $currentMenuItem.children('ul');
//        // console.log('DEBUG: target jump current ', $targetJump);
//    } else {
//        // when we are in child of parent page, jump to parent page
//        $targetJump = $currentMenuItem.closest('ul');
//        // console.log('DEBUG: target jump parent ', $targetJump);
//    }
//    //console.log('DEBUG: target jump', $targetJump); 
//    if ($targetJump.length) {
//     $slinky.jump($targetJump, false);
//    }

//    //  // make header clickable
//    //  $globalMenu.find('.header .title').on('click', function(ev) {
//    //      var href = $(this).closest('ul').siblings('a').attr('href');
//    //     //  console.log('DEBUG: clicked', href);
//    //      if (href) {
//    //         window.location.href = href;
//    //      }
//    //      ev.preventDefault();
//    //  });

//     // make parent nav clickable
//     // hijack click on span area
//     $globalMenu.find('.menu-item-has-children a span').on('click', function(ev) {
//        // console.log('DEBUG: parent nav clicked');
//        var href = $(this).parent('a').attr('href');
//        if (href && href !== '#') {
//            window.location.href = href;
//            ev.stopPropagation();
//        ev.preventDefault();
//        }
//     });

//    //  ClueEdit: make title clickable
//    $globalMenu.find('a.back + .title').on('click', function(ev) {
//        var href = $(this).closest('ul').siblings('a').attr('href');
//        // console.log('DEBUG: title clicked', href);
//        if (href && href !== '#') {
//            window.location.href = href;
//            ev.stopPropagation();
//        }
//        ev.preventDefault();
//    });
//    */



//     // Find the current menu item
//     const currentMenuItem = $globalMenu.querySelector('.current-menu-item');
//     let targetJump = false;

//     if (currentMenuItem) {

//       // When we are in the parent page, jump to the parent page
//       if (currentMenuItem.classList.contains('menu-item-has-children')) {
//         targetJump = currentMenuItem.querySelector('ul');
//         // console.log('DEBUG: target jump current', targetJump);
//       } else {
//         // When we are in the child of the parent page, jump to the parent page
//         targetJump = currentMenuItem.closest('ul');
//         // console.log('DEBUG: target jump parent', targetJump);
//       }
//     }

//     // // console.log('DEBUG: target jump', targetJump);
//     // if (targetJump) {
//     //   $slinky.jump(targetJump, false);
//     // }

//     // Make header clickable
//     $globalMenu.querySelectorAll('.header .title').forEach(title => {
//       title.addEventListener('click', function (ev) {
//         const href = this.closest('ul').previousElementSibling.getAttribute('href');
//         // console.log('DEBUG: clicked', href);
//         if (href) {
//           window.location.href = href;
//         }
//         ev.preventDefault();
//       });
//     });

//     // Make parent nav clickable
//     // Hijack click on span area
//     $globalMenu.querySelectorAll('.menu-item-has-children a span').forEach(span => {
//       span.addEventListener('click', function (ev) {
//         // console.log('DEBUG: parent nav clicked');
//         const href = this.parentElement.getAttribute('href');
//         if (href && href !== '#') {
//           window.location.href = href;
//           ev.stopPropagation();
//           ev.preventDefault();
//         }
//       });
//     });

//     // Make title clickable
//     $globalMenu.querySelectorAll('a.back + .title').forEach(title => {
//       title.addEventListener('click', function (ev) {
//         const href = this.closest('ul').previousElementSibling.getAttribute('href');
//         // console.log('DEBUG: title clicked', href);
//         if (href && href !== '#') {
//           window.location.href = href;
//           ev.stopPropagation();
//         }
//         ev.preventDefault();
//       });
//     });







//   }, 1000);


// }(window));
