// Catálogo simple con Lazy Load
class CatalogManager {
    constructor() {
        this.page = 1;
        this.isLoading = false;
        this.hasMore = true;
        // Usa siempre la ruta raíz del catálogo
        this.catalogUrl = '/';
        this.searchTimeout = null;
        this.init();
    }

    init() {
        this.setupFilters();
        this.setupIntersectionObserver();
    }

    setupFilters() {
        // Búsqueda con debounce
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                console.log('Búsqueda escribida:', e.target.value);
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    console.log('Aplicando búsqueda:', e.target.value);
                    this.resetAndApplyFilters();
                }, 500); // Espera 500ms después de dejar de escribir
            });
        }

        // Filtros por categoría
        document.querySelectorAll('input[name="category"]').forEach(el => {
            el.addEventListener('change', () => {
                console.log('Categoría cambió:', el.value);
                this.resetAndApplyFilters();
            });
        });

        // Filtros por marca
        document.querySelectorAll('input[name="brand"]').forEach(el => {
            el.addEventListener('change', () => {
                console.log('Marca cambió:', el.value);
                this.resetAndApplyFilters();
            });
        });

        // Filtros por color
        document.querySelectorAll('input[name="color"]').forEach(el => {
            el.addEventListener('change', () => {
                console.log('Color cambió:', el.value);
                this.resetAndApplyFilters();
            });
        });

        // Filtros por precio
        document.querySelectorAll('input[name="min_price"], input[name="max_price"]').forEach(el => {
            el.addEventListener('change', () => {
                const min = document.querySelector('input[name="min_price"]')?.value;
                const max = document.querySelector('input[name="max_price"]')?.value;
                console.log('Precio cambió:', min, '-', max);
                this.resetAndApplyFilters();
            });
        });

        // Filtros por talla
        document.querySelectorAll('input[name="size"]').forEach(el => {
            el.addEventListener('change', () => {
                console.log('Talla cambió:', el.value);
                this.resetAndApplyFilters();
            });
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
        const params = this.getFilterParams();
        
        this.isLoading = true;
        const loader = document.getElementById('loadingSpinner');
        if (loader) loader.style.display = 'flex';

        const url = `${this.catalogUrl}?${params}&ajax=1`;

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const gridEl = document.getElementById('sneakerGrid');
                if (gridEl && data.html) {
                    gridEl.innerHTML = data.html;
                }
                this.hasMore = data.hasMore || false;
                this.isLoading = false;
                if (loader) loader.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                this.isLoading = false;
                if (loader) loader.style.display = 'none';
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
