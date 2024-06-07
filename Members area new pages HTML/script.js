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

    // const damageToggle = document.getElementById("damageToggle");
    // const claimsToggle = document.getElementById("claimsToggle");
    // const damageDataSection = document.querySelectorAll(".damage-data");
    // const claimnsDataSection = document.querySelectorAll(".claims-data");
    // const damageDataInputs = document.querySelectorAll(".damage-data .input");
    // const claimsDataInputs = document.querySelectorAll(".claims-data .input");

    // function toggleDammage() {
    //     const damageIsChecked = damageToggle.checked;

    //     // Disable/Enable inputs based on the toggle state
    //     damageDataInputs.forEach(input => {
    //         input.disabled = damageIsChecked;
    //     });

    //     // Add/Remove red background color based on the toggle state
    //     if (damageIsChecked) {
    //         damageDataSection.forEach(section => {
    //             section.classList.add("disabled");
    //         });
    //     } else {
    //         damageDataSection.forEach(section => {
    //             section.classList.remove("disabled");
    //         });
    //     }
    // }
    // function toggleClaims() {
    //     const claimsIsChecked = claimsToggle.checked;

    //     // Disable/Enable inputs based on the toggle state
    //     claimsDataInputs.forEach(input => {
    //         input.disabled = claimsIsChecked;
    //     });

    //     // Add/Remove red background color based on the toggle state
    //     if (claimsIsChecked) {
    //         claimnsDataSection.forEach(section => {
    //             section.classList.add("disabled");
    //         });
    //     } else {
    //         claimnsDataSection.forEach(section => {
    //             section.classList.remove("disabled");
    //         });
    //     }
    // }

    // // Initial state check
    // toggleDammage();
    // toggleClaims();

    // // Add event listener for the toggle change
    // damageToggle.addEventListener("change", toggleDammage);
    // claimsToggle.addEventListener("change", toggleClaims);

    // optimize
    // Get all toggles and their corresponding sections
    const toggles = [
        { toggle: document.getElementById("damageToggle"), sectionClass: "damage-data" },
        { toggle: document.getElementById("claimsToggle"), sectionClass: "claims-data" },
        { toggle: document.getElementById("statusToggle"), sectionClass: "status-data" }
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
        toggleSection(toggle, sectionClass);
        toggle.addEventListener("change", () => toggleSection(toggle, sectionClass));
    });

});

