// Archivo: resources/js/filters-toggle.js
document.addEventListener('DOMContentLoaded', function() {
    const toggleDesktopBtn = document.getElementById('toggleFiltersDesktop');
    const filtersContainer = document.getElementById('filtersContainer');
    const toggleMobileBtn = document.getElementById('toggleFiltersBtn');
    const closeMobileBtn = document.getElementById('closeFiltersBtn');
    const filterSidebar = document.querySelector('.filter-sidebar');
    const filterSection = document.querySelector('.filter-section');

    // MOBILE TOGGLE
    if (toggleMobileBtn && filterSidebar) {
        toggleMobileBtn.addEventListener('click', function() {
            filterSidebar.classList.toggle('active');
            
            if (filterSidebar.classList.contains('active')) {
                filterSection.classList.remove('hide');
            } else {
                filterSection.classList.add('hide');
            }
            
            const btnText = document.getElementById('filterBtnText');
            if (btnText) {
                btnText.textContent = filterSidebar.classList.contains('active') ? 'Ocultar Filtros' : 'Mostrar Filtros';
            }
        });
    }

    // Cerrar mobile
    if (closeMobileBtn && filterSidebar) {
        closeMobileBtn.addEventListener('click', function() {
            filterSidebar.classList.remove('active');
            filterSection.classList.add('hide');
            
            const btnText = document.getElementById('filterBtnText');
            if (btnText) {
                btnText.textContent = 'Mostrar Filtros';
            }
        });
    }

    // Cerrar al hacer click fuera en mobile
    if (filterSidebar) {
        filterSidebar.addEventListener('click', function(e) {
            if (e.target === filterSidebar) {
                filterSidebar.classList.remove('active');
                filterSection.classList.add('hide');
            }
        });
    }

    // Filtros colapsables
    const collapsibleTitles = document.querySelectorAll('.filter-title.collapsible');
    collapsibleTitles.forEach(title => {
        title.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            const content = document.getElementById(target);
            
            if (content) {
                content.classList.toggle('collapsed');
                this.classList.toggle('collapsed');
            }
        });
    });

    // Cerrar filtros al aplicar (solo mobile)
    const filterForm = document.getElementById('filterForm');
    if (filterForm && filterSidebar) {
        filterForm.addEventListener('submit', function() {
            if (window.innerWidth < 992) {
                filterSidebar.classList.remove('active');
                filterSection.classList.add('hide');
            }
        });
    }
});

