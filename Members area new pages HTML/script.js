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

window.addEventListener('click', function(e) {
    if (!e.target.closest('.custom-dropdown')) {
        var dropdowns = document.querySelectorAll('.dropdown-options');
        dropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('show');
        });
    }
});
});

