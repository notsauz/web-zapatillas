@extends('layouts.app')

@section('styles')
    @vite('resources/css/sneakers.index.css')
@endsection

@section('content')
    <!-- Botón Toggle Filtros (Móvil) -->
    <button class="btn-toggle-filters" id="toggleFiltersBtn">
        <i class="fas fa-sliders-h"></i> <span id="filterBtnText">Mostrar Filtros</span>
    </button>

    <div class="row">
        <!-- Filtros (Sidebar) -->
        <div class="col-lg-3 mb-4 filters-container" id="filtersContainer">
            <div class="filter-sidebar">
                <div class="filter-section">
                    <h5 class="mb-3" style="display: flex; justify-content: space-between; align-items: center;">
                        Filtros
                        <button type="button" class="btn-close d-lg-none" id="closeFiltersBtn" style="font-size: 1.5rem;"></button>
                    </h5>

                    <form id="filterForm" class="filter-form">
                        <!-- Categorías -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="categoryFilter">
                                <span>Categoría</span>
                                @if(request('category'))
                                    <span style="font-size: 0.8rem; color: #007bff; font-weight: 500;">(Filtrado)</span>
                                @endif
                            </label>
                            <div class="filter-content collapsed" id="categoryFilter">
                                @if(request('category'))
                                    <div style="padding: 10px; background: #e7f3ff; border-radius: 6px; margin-bottom: 10px;">
                                        <p style="margin: 0; font-size: 0.9rem; color: #004085;">
                                            <strong>Categoría actual:</strong> {{ ucfirst(request('category')) }}
                                        </p>
                                        <a href="{{ route('catalogo') }}" style="font-size: 0.85rem; color: #007bff; text-decoration: none;">
                                            Ver todas las categorías
                                        </a>
                                    </div>
                                @else
                                    @foreach(['hombre', 'mujer', 'niño', 'unisex'] as $cat)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="category" id="cat_{{ $cat }}" value="{{ $cat }}">
                                            <label class="form-check-label" for="cat_{{ $cat }}">
                                                {{ ucfirst($cat) }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="cat_all" value="" checked>
                                        <label class="form-check-label" for="cat_all">
                                            Todas
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Marca (Botones en lugar de Select) -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="brandFilter">
                                <span>Marca</span>
                                @if(request('brand'))
                                    <span style="font-size: 0.8rem; color: #007bff; font-weight: 500;">(Filtrado)</span>
                                @endif
                            </label>
                            <div class="filter-content collapsed" id="brandFilter">
                                @if(request('brand'))
                                    <div style="padding: 10px; background: #e7f3ff; border-radius: 6px; margin-bottom: 10px;">
                                        <p style="margin: 0; font-size: 0.9rem; color: #004085;">
                                            <strong>Marca actual:</strong> {{ request('brand') }}
                                        </p>
                                        <a href="{{ route('catalogo') }}" style="font-size: 0.85rem; color: #007bff; text-decoration: none;">
                                            Ver todas las marcas
                                        </a>
                                    </div>
                                @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="brand" id="brand_all" value="" checked>
                                        <label class="form-check-label" for="brand_all">
                                            Todas las marcas
                                        </label>
                                    </div>
                                    @foreach($brands as $brand)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="brand" id="brand_{{ str_replace(' ', '_', $brand) }}" value="{{ $brand }}">
                                            <label class="form-check-label" for="brand_{{ str_replace(' ', '_', $brand) }}">
                                                {{ $brand }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Rango de Precio -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="priceFilter">
                                <span>Rango de Precio</span>
                            </label>
                            <div class="filter-content collapsed" id="priceFilter">
                                <div class="price-inputs">
                                    <input type="number" class="form-control" name="min_price" placeholder="Mín" value="{{ request('min_price') }}" min="0">
                                    <span>-</span>
                                    <input type="number" class="form-control" name="max_price" placeholder="Máx" value="{{ request('max_price') }}" min="0">
                                </div>
                            </div>
                        </div>

                        <!-- Color -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="colorFilter">
                                <span>Color</span>
                            </label>
                            <div class="filter-content collapsed" id="colorFilter">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="color" id="color_all" value="" {{ !request('color') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="color_all">
                                        Todos los colores
                                    </label>
                                </div>
                                @foreach($colors as $color)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color" id="color_{{ str_replace(' ', '_', $color) }}" value="{{ $color }}" {{ request('color') == $color ? 'checked' : '' }}>
                                        <label class="form-check-label" for="color_{{ str_replace(' ', '_', $color) }}">
                                            {{ $color }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Talla -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="sizeFilter">
                                <span>Talla</span>
                            </label>
                            <div class="filter-content collapsed" id="sizeFilter">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="size_all" value="" {{ !request('size') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="size_all">
                                        Todas las tallas
                                    </label>
                                </div>
                                @foreach($sizes as $size)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="size" id="size_{{ str_replace(' ', '_', str_replace('.', '', $size)) }}" value="{{ $size }}" {{ request('size') == $size ? 'checked' : '' }}>
                                        <label class="form-check-label" for="size_{{ str_replace(' ', '_', str_replace('.', '', $size)) }}">
                                            {{ $size }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-apply-filters">
                            <i class="fas fa-check me-1"></i> Aplicar Filtros
                        </button>
                        <a href="{{ route('catalogo') }}" class="btn btn-secondary btn-clear-filters">
                            <i class="fas fa-times me-1"></i> Limpiar Filtros
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Grid de Zapatillas -->
        <div class="col-lg-9">
            <div class="d-lg-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-3 mb-lg-0">
                    @if(request('search'))
                        Resultados para "{{ request('search') }}"
                    @elseif(request('category'))
                        Zapatillas para {{ ucfirst(request('category')) }}
                    @elseif(request('brand'))
                        Zapatillas {{ request('brand') }}
                    @else
                        Catálogo de Zapatillas
                    @endif
                </h2>
            </div>

            @if($sneakers->count() > 0)
                <!-- Grid de Zapatillas con Lazy Load -->
                <div class="row g-4" id="sneakerGrid">
                    @foreach($sneakers as $sneaker)
                        <div class="col-4 col-sm-6 col-lg-4">
                            <a href="{{ route('sneaker.show', $sneaker->id) }}" class="text-decoration-none">
                                <div class="card sneaker-card" style="transition: all 0.3s ease;">
                                    <div class="position-relative overflow-hidden" style="height: 250px;">
                                        <img src="{{ $sneaker->image_url }}"
                                            alt="{{ $sneaker->name }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.3s ease;">
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-dark fw-bold mb-2">{{ $sneaker->name }}</h5>
                                        <p class="text-muted mb-2 product-sku" style="font-size: 0.9rem;">
                                            <strong>SKU:</strong> {{ $sneaker->sku }}
                                        </p>
                                        <p class="text-muted mb-2 product-brand" style="font-size: 0.85rem;">
                                            <small><strong>Marca:</strong> {{ $sneaker->brand }}</small>
                                        </p>
                                        @if($sneaker->color)
                                            <p class="text-muted mb-3 product-color" style="font-size: 0.85rem;">
                                                <small><strong>Color:</strong> {{ $sneaker->color }}</small></p>
                                        @endif
                                        <h5 class="text-primary fw-bold mb-3">${{ number_format($sneaker->price, 2) }}</h5>
                                        <button class="btn btn-primary btn-sm w-100 mt-auto">
                                            <i class="fas fa-eye me-1"></i> Ver Detalles
                                        </button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Spinner de Carga -->
                <div id="loadingSpinner" class="text-center mt-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>

                <!-- Lazy Load Infinito -->
                <div id="sentinel" style="height: 1px; margin-top: 50px;"></div>
            @else
                <div class="alert alert-info text-center">
                    <h5>No se encontraron zapatillas</h5>
                    <p>Intenta ajustar los filtros o la búsqueda</p>
                    <a href="{{ route('catalogo') }}" class="btn btn-primary">Ver todas las zapatillas</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/catalog-lazy-load.js')
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Movil: Toggle Filtros
            const mobileBtn = document.getElementById('toggleFiltersBtn');
            const sidebar = document.querySelector('.filter-sidebar');
            const section = document.querySelector('.filter-section');
            const closeBtn = document.getElementById('closeFiltersBtn');
            
            if (mobileBtn && sidebar) {
                mobileBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    if (sidebar.classList.contains('active')) {
                        section?.classList.remove('hide');
                    }
                });
            }
            
            if (closeBtn && sidebar) {
                closeBtn.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    section?.classList.add('hide');
                });
            }
            
            if (sidebar) {
                sidebar.addEventListener('click', function(e) {
                    if (e.target === sidebar) {
                        sidebar.classList.remove('active');
                        section?.classList.add('hide');
                    }
                });
            }

            // Collapsible filters
            document.querySelectorAll('.filter-title.collapsible').forEach(title => {
                title.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    const target = document.getElementById(targetId);
                    if (target) {
                        target.classList.toggle('collapsed');
                        this.classList.toggle('collapsed');
                    }
                });
            });

            // Búsqueda en tiempo real
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const query = this.value.trim();
                        const sneakerGrid = document.getElementById('sneakerGrid');
                        if (sneakerGrid) {
                            if (query.length > 0) {
                                fetch(`/buscar?q=${encodeURIComponent(query)}&ajax=1`)
                                    .then(response => response.json())
                                    .then(data => {
                                        sneakerGrid.innerHTML = data.html;
                                    })
                                    .catch(error => console.error('Error en búsqueda:', error));
                            } else {
                                // Si vacío, recargar la página o mostrar todos
                                location.reload();
                            }
                        }
                    }, 300); // Debounce 300ms
                });
            }
        });
    </script>
@endsection
