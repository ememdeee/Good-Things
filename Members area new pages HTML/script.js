document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');
    const overlay = document.getElementById('overlay');

    const toggleSidebar = function () {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    };

    hamburgerIcon.addEventListener('click', toggleSidebar);
    closeIcon.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // dropdown
    if (document.getElementById('dataSelected')) {
        document.getElementById('dataSelected').addEventListener('click', function() {
            document.getElementById('selectData').classList.toggle('show');
        });

        document.querySelectorAll('.dropdown-options div').forEach(function(option) {
            option.addEventListener('click', function() {
                var logoText = document.querySelector('.dropdown-selected .logo-text');
                if (logoText) {
                    logoText.innerHTML = this.innerHTML;
                    document.getElementById('selectData').classList.remove('show');
                } else {
                    console.error('Logo text element not found');
                }
            });
        });
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-dropdown')) {
            var dropdowns = document.querySelectorAll('.dropdown-options');
            dropdowns.forEach(function(dropdown) {
                dropdown.classList.remove('show');
            });
        }
    });

    const toggles = [
        { toggle: document.getElementById("damageToggle"), sectionClass: "damage-data" },
        { toggle: document.getElementById("claimsToggle"), sectionClass: "claims-data" },
        { toggle: document.getElementById("statusToggle"), sectionClass: "status-data" },
        { toggle: document.getElementById("attatchPoliceReport"), sectionClass: "attatch-police-report" }
    ];

    // Generic toggle function to handle enabling/disabling and styling
    function toggleSection(toggle, sectionClass) {
        const isChecked = toggle.checked;
        const sections = document.querySelectorAll(`.${sectionClass}`);
        const inputs = document.querySelectorAll(`.${sectionClass} .input`);

        // Disable/Enable inputs and add/remove 'disabled' class based on the toggle state
        inputs.forEach(input => input.disabled = isChecked);
        sections.forEach(section => section.classList.toggle("disabled", isChecked));
    }

    // Initial state check and add event listeners
    toggles.forEach(({ toggle, sectionClass }) => {
        if (toggle) {
            toggleSection(toggle, sectionClass);
            toggle.addEventListener("change", () => toggleSection(toggle, sectionClass));
        }
    });

    // Function to update the character count with safety checks for report stolen page
    function updateCharacterCount(textareaId, indicatorId) {
        const textarea = document.getElementById(textareaId);
        const indicator = document.getElementById(indicatorId);

        // Check if both the textarea and indicator exist
        if (textarea && indicator) {
            const maxLength = textarea.getAttribute('maxlength');

            textarea.addEventListener('input', () => {
                const currentLength = textarea.value.length;
                indicator.textContent = `${currentLength}/${maxLength}`;
            });

            // Trigger the input event once to initialize the indicator
            textarea.dispatchEvent(new Event('input'));
        }
    }

    // Initialize the character count indicators for each textarea
    updateCharacterCount('items', 'items-indicator');
    updateCharacterCount('theft-details', 'theft-details-indicator');
});

