document.addEventListener('DOMContentLoaded', function() {
    // Toggle para sidebar
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    // Mostrar u ocultar sidebar al hacer click en el toggle
    if (toggle) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Cerrar sidebar al hacer click en un link
    const navLinks = sidebar.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('show');
            }
        });
    });

    // Cerrar sidebar al redimensionar a desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('show');
        }
    });
});
