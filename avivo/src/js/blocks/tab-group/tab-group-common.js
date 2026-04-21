

function initializeTabGroup() {
	window.cdApp = window.cdApp || {};

	// this function only run once
	if (typeof window.cdApp.cdbTabGroupInitialized !== 'undefined') {
		return;
	}
	window.cdApp.cdbTabGroupInitialized = true;

        /**
         * Represents a single tab component, managing its tabs, panels, and interactions.
         */
        class TabComponent {
            /**
             * @param {HTMLElement} tabGroupElement - The main container element for the tab component.
             * @param {string|null} initialTabId - Optional ID of the tab panel to activate on load.
             */
            constructor(tabGroupElement, initialTabId = null) {
                this.tabGroup = tabGroupElement;
                this.tabListContainer = this.tabGroup.querySelector('.tab-group__tabs');
                this.tabContent = this.tabGroup.querySelector('.tab-group__content');
                // Convert NodeList to Array for easier manipulation
                this.tabPanels = Array.from(this.tabContent.querySelectorAll('.cdb-tab_panel'));
                this.initialTabId = initialTabId;

                // Keep track of the currently active tab button and panel
                this.activeTabButton = null;
                this.activeTabPanel = null;

                this.init();
            }

            /**
             * Initializes the tab component by generating tabs, adding event listeners,
             * and handling the initial active tab state.
             */
            init() {
                // Only generate tabs if they haven't been generated yet for this component
                if (this.tabListContainer.children.length === 0) {
                    this.generateTabs();
                }
                this.addEventListeners();
                this.handleInitialTab();
            }

            /**
             * Dynamically generates the tab buttons based on the existing tab panels.
             * Sets up ARIA attributes for accessibility.
             */
            generateTabs() {
                const ul = document.createElement('ul');
                ul.classList.add('tab-group__tab-list');
                ul.setAttribute('role', 'tablist');

                this.tabPanels.forEach((panel, index) => {
                    const panelId = panel.id;
                    // Try to get title from data-tab-title, fallback to generic
                    const panelTitle = panel.dataset.tabTitle || `Tab ${index + 1}`;

                    const li = document.createElement('li');
                    li.classList.add('tab-group__tab-item');
                    li.setAttribute('role', 'presentation'); // li is a container for the tab

                    const h3 = document.createElement('h3');
                    h3.classList.add('tab-group__tab-heading');

                    const button = document.createElement('button');
                    button.classList.add('tab-group__tab-button');
                    // Create a unique ID for the tab button itself
                    button.setAttribute('id', `${this.tabGroup.id}-tab-${panelId}`);
                    button.setAttribute('role', 'tab');
                    button.setAttribute('aria-controls', panelId); // Links to the panel's ID
                    button.setAttribute('aria-selected', 'false');
                    button.setAttribute('tabindex', '-1'); // Not focusable by default, only active tab is
                    button.textContent = panelTitle;
                    button.dataset.targetPanelId = panelId; // Custom data attribute to link to panel

                    // Set accessibility attributes for the panel
                    panel.setAttribute('role', 'tabpanel');
                    panel.setAttribute('aria-labelledby', `${this.tabGroup.id}-tab-${panelId}`); // Links back to the tab button's ID
                    panel.setAttribute('aria-hidden', 'true'); // Initially hidden for accessibility

                    h3.appendChild(button);
                    li.appendChild(h3);
                    ul.appendChild(li);
                });

                this.tabListContainer.appendChild(ul);
            }

            /**
             * Adds click and keyboard event listeners to the tab buttons for interaction
             * and accessibility.
             */
            addEventListeners() {
                this.tabListContainer.addEventListener('click', (event) => {
                    const targetButton = event.target.closest('.tab-group__tab-button');
                    // Ensure a tab button was clicked and it has a target panel
                    if (targetButton && targetButton.dataset.targetPanelId) {
                        this.activateTab(targetButton.dataset.targetPanelId);
                    }
                    // console.log('DEBUG: scrolled');
                    // event.preventDefault();
                });

                this.tabListContainer.addEventListener('keydown', (event) => {
                    const currentTab = event.target.closest('.tab-group__tab-button');
                    if (!currentTab) return; // Not a tab button

                    const tabButtons = Array.from(this.tabGroup.querySelectorAll('.tab-group__tab-button'));
                    let currentIndex = tabButtons.indexOf(currentTab);

                    if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
                        event.preventDefault(); // Prevent page scrolling with arrow keys
                        let nextIndex;

                        if (event.key === 'ArrowRight') {
                            nextIndex = (currentIndex + 1) % tabButtons.length;
                        } else { // ArrowLeft
                            nextIndex = (currentIndex - 1 + tabButtons.length) % tabButtons.length;
                        }

                        tabButtons[nextIndex].focus(); // Move focus to the next/previous tab
                        this.activateTab(tabButtons[nextIndex].dataset.targetPanelId); // Activate the tab
                    } else if (event.key === 'Home') {
                        event.preventDefault();
                        tabButtons[0].focus(); // Move focus to the first tab
                        this.activateTab(tabButtons[0].dataset.targetPanelId);
                    } else if (event.key === 'End') {
                        event.preventDefault();
                        tabButtons[tabButtons.length - 1].focus(); // Move focus to the last tab
                        this.activateTab(tabButtons[tabButtons.length - 1].dataset.targetPanelId);
                    }
                });
            }

            /**
             * Determines which tab should be active on initial page load.
             * Prioritizes `initialTabId` parameter, then URL hash, then the first tab.
             */
            handleInitialTab() {
                let targetPanelId = this.initialTabId;

                // If no initialTabId is explicitly provided, check URL hash
                if (!targetPanelId) {
                    const hash = window.location.hash.substring(1); // Remove '#' from hash
                    if (hash) {
                        // Check if the hash matches an ID of a panel within THIS tab group
                        const matchingPanel = this.tabPanels.find(panel => panel.id === hash);
                        if (matchingPanel) {
                            targetPanelId = hash;
                        }
                    }
                }

                // If still no target, activate the first tab in this group
                if (!targetPanelId && this.tabPanels.length > 0) {
                    targetPanelId = this.tabPanels[0].id;
                }

                if (targetPanelId) {
                    // Activate the determined tab. Do not update hash if it came from hash initially.
                    this.activateTab(targetPanelId, false);
                }
            }

            /**
             * Activates a specified tab panel and its corresponding tab button.
             * Manages ARIA attributes, CSS classes for styling and transitions,
             * and updates the URL hash.
             * @param {string} targetPanelId - The ID of the tab panel to activate.
             * @param {boolean} updateHash - Whether to update the URL hash (default: true).
             */
            activateTab(targetPanelId, updateHash = true) {
                const newActivePanel = this.tabPanels.find(panel => panel.id === targetPanelId);
                const newActiveButton = this.tabGroup.querySelector(`[data-target-panel-id="${targetPanelId}"]`);

                if (!newActivePanel || !newActiveButton) {
                    console.warn(`Tab or panel with ID "${targetPanelId}" not found in tab group "${this.tabGroup.id}".`);
                    return;
                }

                // Deactivate current tab if one is active
                if (this.activeTabButton && this.activeTabPanel) {
                    this.activeTabButton.setAttribute('aria-selected', 'false');
                    this.activeTabButton.setAttribute('tabindex', '-1');
                    this.activeTabButton.classList.remove('tab-group__tab-button--active');

                    // Start fade out for old panel
                    this.activeTabPanel.classList.remove('tab-panel--active');
                    this.activeTabPanel.style.opacity = '0';
                    this.activeTabPanel.setAttribute('aria-hidden', 'true');

                    // Wait for fade out transition to complete before setting display: none
                    // This ensures the fade out animation is visible.
                    setTimeout(() => {
                        // Check if the panel is still the previously active one before hiding
                        // This prevents issues if a new tab is activated very quickly
                        if (this.activeTabPanel && this.activeTabPanel.id === targetPanelId) {
                            // Do nothing, it's the same panel being activated
                        } else if (this.activeTabPanel) {
                            this.activeTabPanel.style.display = 'none';
                        }
                    }, 300); // Matches the CSS transition duration for opacity
                }

                // Activate new tab
                newActiveButton.setAttribute('aria-selected', 'true');
                newActiveButton.setAttribute('tabindex', '0'); // Make the active tab focusable
                newActiveButton.classList.add('tab-group__tab-button--active');

                // Make sure the new panel is visible (display: block) before applying opacity for fade-in
                newActivePanel.style.display = 'block';
                newActivePanel.setAttribute('aria-hidden', 'false');

                // Trigger reflow to ensure the browser registers the display: block change
                // before applying the opacity transition. This is crucial for the fade-in.
                void newActivePanel.offsetWidth;

                // Start fade in for new panel
                newActivePanel.classList.add('tab-panel--active');
                newActivePanel.style.opacity = '1'; // This triggers the fade-in transition

                // Update active references
                this.activeTabButton = newActiveButton;
                this.activeTabPanel = newActivePanel;

                // Update URL hash if requested
                if (updateHash) {
                    // Only update hash if it's for this specific tab group's active tab
                    // This prevents multiple tab groups from fighting over the hash
                    const newUrl = `${window.location.origin}${window.location.pathname}#${targetPanelId}`;
                    history.replaceState(null, '', newUrl); // Update hash without scrolling
                }
            }
        }


	// document.querySelectorAll('.cdb-tab_group:not(.is-initialized)').forEach(block => {
	// 	// Add the 'is-initialized' class to prevent multiple listeners
	// 	block.classList.add('is-initialized');

    
	// });
        const tabComponentInstances = {};

        const tabGroups = document.querySelectorAll('.cdb-tab_group');
        tabGroups.forEach(tabGroup => {
            // Initialize each tab group and store its instance in the map
            const instance = new TabComponent(tabGroup);
            tabComponentInstances[tabGroup.id] = instance;
        });

        // Handle hash changes if the user manually changes the hash in the URL bar
        // or navigates back/forward in history.
        window.addEventListener('hashchange', () => {
            const hash = window.location.hash.substring(1);
            if (hash) {
                // Find the tab component that contains a panel matching the hash
                const targetPanel = document.getElementById(hash);
                if (targetPanel) {
                    const parentTabGroup = targetPanel.closest('.cdb-tab_group');
                    if (parentTabGroup && tabComponentInstances[parentTabGroup.id]) {
                        // Get the existing TabComponent instance and activate the tab
                        const tabComponentInstance = tabComponentInstances[parentTabGroup.id];
                        tabComponentInstance.activateTab(hash, false); // Don't update hash again
                    }
                }
            }
        });


}

