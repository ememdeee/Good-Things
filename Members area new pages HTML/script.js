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
});
