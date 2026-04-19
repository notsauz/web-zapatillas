// Catálogo simple con Lazy Load
class CatalogManager {
    constructor() {
        this.page = 1;
        this.isLoading = false;
        this.hasMore = true;
        this.catalogUrl = window.location.pathname;
        this.init();
    }

    init() {
        this.setupFilters();
        this.setupIntersectionObserver();
    }

    setupFilters() {
        // Filtros por categoría
        document.querySelectorAll('input[name="category"]').forEach(el => {
            el.addEventListener('change', () => this.resetAndApplyFilters());
        });

        // Filtros por marca
        document.querySelectorAll('input[name="brand"]').forEach(el => {
            el.addEventListener('change', () => this.resetAndApplyFilters());
        });

        // Filtros por color
        document.querySelectorAll('input[name="color"]').forEach(el => {
            el.addEventListener('change', () => this.resetAndApplyFilters());
        });

        // Filtros por precio
        document.querySelectorAll('input[name="min_price"], input[name="max_price"]').forEach(el => {
            el.addEventListener('change', () => this.resetAndApplyFilters());
        });

        // Filtros por talla
        document.querySelectorAll('input[name="size"]').forEach(el => {
            el.addEventListener('change', () => this.resetAndApplyFilters());
        });
    }

    setupIntersectionObserver() {
        const sentinel = document.getElementById('sentinel');
        if (!sentinel) return;

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting && this.hasMore && !this.isLoading) {
                    this.loadMore();
                }
            });
        }, { rootMargin: '100px' });

        observer.observe(sentinel);
    }

    resetAndApplyFilters() {
        this.page = 1;
        this.hasMore = true;
        this.applyFilters();
    }

    getFilterParams() {
        const params = new URLSearchParams();

        // Búsqueda
        const searchInput = document.getElementById('searchInput');
        if (searchInput?.value) params.append('search', searchInput.value);

        // Categoría
        const categoryInput = document.querySelector('input[name="category"]:checked');
        if (categoryInput?.value) params.append('category', categoryInput.value);

        // Marca
        const brandInput = document.querySelector('input[name="brand"]:checked');
        if (brandInput?.value) params.append('brand', brandInput.value);

        // Color
        const colorInput = document.querySelector('input[name="color"]:checked');
        if (colorInput?.value) params.append('color', colorInput.value);

        // Precio
        const minPrice = document.querySelector('input[name="min_price"]');
        const maxPrice = document.querySelector('input[name="max_price"]');
        if (minPrice?.value) params.append('min_price', minPrice.value);
        if (maxPrice?.value) params.append('max_price', maxPrice.value);

        // Talla
        const sizeInput = document.querySelector('input[name="size"]:checked');
        if (sizeInput?.value) params.append('size', sizeInput.value);

        params.append('page', this.page);
        return params.toString();
    }

    applyFilters() {
        this.isLoading = true;
        document.getElementById('loadingSpinner')?.style.setProperty('display', 'flex');

        fetch(`${this.catalogUrl}?${this.getFilterParams()}&ajax=1`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(data => {
                document.getElementById('sneakerGrid').innerHTML = data.html || '';
                this.hasMore = data.hasMore ?? false;
                this.isLoading = false;
                document.getElementById('loadingSpinner')?.style.setProperty('display', 'none');
            })
            .catch(e => {
                console.error(e);
                this.isLoading = false;
                document.getElementById('loadingSpinner')?.style.setProperty('display', 'none');
            });
    }

    loadMore() {
        this.page++;
        this.isLoading = true;
        document.getElementById('loadingSpinner')?.style.setProperty('display', 'flex');

        fetch(`${this.catalogUrl}?${this.getFilterParams()}&ajax=1`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
            .then(r => r.json())
            .then(data => {
                const gridContainer = document.getElementById('sneakerGrid');
                
                // Agregar el HTML retornado
                if (data.html) {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data.html;
                    const newProducts = tempDiv.querySelectorAll('.col-4, .col-sm-6, .col-lg-4');
                    newProducts.forEach(el => gridContainer.appendChild(el));
                }
                
                // Verificar si hay más páginas
                this.hasMore = data.hasMore ?? false;
                
                this.isLoading = false;
                document.getElementById('loadingSpinner')?.style.setProperty('display', 'none');
            })
            .catch(e => {
                console.error(e);
                this.hasMore = false;
                this.isLoading = false;
                document.getElementById('loadingSpinner')?.style.setProperty('display', 'none');
            });
    }
}

document.addEventListener('DOMContentLoaded', () => new CatalogManager());
