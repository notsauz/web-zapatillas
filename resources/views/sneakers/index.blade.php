@extends("layouts.app")

@section("styles")
    @vite(["resources/css/sneakers.index.css", "resources/css/filter-summary.css"])
@endsection

@section("content")

    <!-- Botón Toggle Filtros (Móvil) -->
    <button class="btn-toggle-filters" id="toggleFiltersBtn">
        <i class="fas fa-sliders-h"></i> <span id="filterBtnText">{{ __('Mostrar Filtros') }}</span>
    </button>

    <div class="row">
        <!-- Filtros (Sidebar) -->
        <div class="col-lg-3 mb-4 filters-container" id="filtersContainer">
            <div class="filter-sidebar">
                <div class="filter-section">
                    <h5 class="mb-3" style="display: flex; justify-content: space-between; align-items: center;">
                        <span>
                            {{ __('Filtros') }}
                            <span class="filter-badge" data-section="filters" style="display: {{ request()->filled('search') || request()->filled('category') || request()->filled('brand') || request()->filled('min_price') || request()->filled('max_price') || request()->filled('color') || request()->filled('size') ? 'inline' : 'none' }}; font-size: 0.9rem; color: #007bff; font-weight: 500; margin-left: 0.5rem;">({{ __('Filtrado') }})</span>
                        </span>
                        <button type="button" class="btn-close d-lg-none" id="closeFiltersBtn" style="font-size: 1.5rem;" aria-label="{{ __('Cerrar filtros') }}"></button>
                    </h5>

                    <form id="filterForm" class="filter-form" action="{{ route('catalogo') }}" method="GET">
                        <!-- Categorías -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="categoryFilter">
                                <span>{{ __('Categoría') }}</span>
                                <span class="filter-badge" data-section="category" style="display: {{ request('category') ? 'inline' : 'none' }}; font-size: 0.8rem; color: #007bff; font-weight: 500;">({{ __('Filtrado') }})</span>
                            </label>
                            <div class="filter-content collapsed" id="categoryFilter">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" id="cat_all" value="" {{ !request("category") ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat_all">
                                        {{ __('Todas') }}
                                    </label>
                                </div>
                                @foreach(["hombre", "mujer", "niño", "unisex"] as $cat)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="category" id="cat_{{ $cat }}" value="{{ $cat }}" {{ request("category") === $cat ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cat_{{ $cat }}">
                                            {{ __(ucfirst($cat)) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Marca (Botones en lugar de Select) -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="brandFilter">
                                <span>{{ __('Marca') }}</span>
                                <span class="filter-badge" data-section="brand" style="display: {{ request('brand') ? 'inline' : 'none' }}; font-size: 0.8rem; color: #007bff; font-weight: 500;">({{ __('Filtrado') }})</span>
                            </label>
                            <div class="filter-content collapsed" id="brandFilter">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="brand" id="brand_all" value="" {{ !request("brand") ? 'checked' : '' }}>
                                    <label class="form-check-label" for="brand_all">
                                        {{ __('Todas las marcas') }}
                                    </label>
                                </div>
                                @foreach($marcas as $brand)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="brand" id="brand_{{ str_replace(" ", "_", $brand) }}" value="{{ $brand }}" {{ request("brand") === $brand ? 'checked' : '' }}>
                                        <label class="form-check-label" for="brand_{{ str_replace(" ", "_", $brand) }}">
                                            {{ $brand }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Rango de Precio -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="priceFilter">
                                <span>{{ __('Rango de Precio') }}</span>
                                <span class="filter-badge" data-section="price" style="display: {{ request()->filled('min_price') || request()->filled('max_price') ? 'inline' : 'none' }}; font-size: 0.8rem; color: #007bff; font-weight: 500;">({{ __('Filtrado') }})</span>
                            </label>
                            <div class="filter-content collapsed" id="priceFilter">
                                <div class="price-range-wrapper">
                                    <div class="price-inputs">
                                        <input type="number" class="form-control" name="min_price" id="minPriceInput" placeholder="{{ __('Mín') }}" value="{{ request('min_price') ?: 0 }}" min="0" max="{{ $maxPrice }}">
                                        <span>-</span>
                                        <input type="number" class="form-control" name="max_price" id="maxPriceInput" placeholder="{{ __('Máx') }}" value="{{ request('max_price') ?: $maxPrice }}" min="0" max="{{ $maxPrice }}">
                                    </div>
                                    <div class="price-slider" data-max-price="{{ $maxPrice }}">
                                        <input type="range" id="minPriceRange" min="0" max="{{ $maxPrice }}" step="1" value="{{ request('min_price') ?: 0 }}">
                                        <input type="range" id="maxPriceRange" min="0" max="{{ $maxPrice }}" step="1" value="{{ request('max_price') ?: $maxPrice }}">
                                        <div class="slider-track"></div>
                                        <div class="slider-range" id="priceSliderRange"></div>
                                    </div>
                                    <div class="price-values">
                                        <span id="minPriceLabel">0</span>
                                        <span id="maxPriceLabel">{{ $maxPrice }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Color -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="colorFilter">
                                <span>{{ __('Color') }}</span>
                                <span class="filter-badge" data-section="color" style="display: {{ request('color') ? 'inline' : 'none' }}; font-size: 0.8rem; color: #007bff; font-weight: 500;">({{ __('Filtrado') }})</span>
                            </label>
                            <div class="filter-content collapsed" id="colorFilter">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="color" id="color_all" value="" {{ !request("color") ? "checked" : "" }}>
                                    <label class="form-check-label" for="color_all">
                                        {{ __('Todos los colores') }}
                                    </label>
                                </div>
                                @foreach($colores as $color)
                                    <div class="form-check">
                                        @php
                                            $sanitizedColorId = preg_replace('/[^A-Za-z0-9_-]/', '_', $color['value']);
                                        @endphp
                                        <input class="form-check-input" type="radio" name="color" id="color_{{ $sanitizedColorId }}" value="{{ $color['value'] }}" {{ request("color") == $color['value'] ? "checked" : "" }}>
                                        <label class="form-check-label" for="color_{{ $sanitizedColorId }}">
                                            {{ $color['label'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Talla -->
                        <div>
                            <label class="filter-title collapsible collapsed" data-target="sizeFilter">
                                <span>{{ __('Talla') }}</span>
                                <span class="filter-badge" data-section="size" style="display: {{ request('size') ? 'inline' : 'none' }}; font-size: 0.8rem; color: #007bff; font-weight: 500;">({{ __('Filtrado') }})</span>
                            </label>
                            <div class="filter-content collapsed" id="sizeFilter">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="size" id="size_all" value="" {{ !request("size") ? "checked" : "" }}>
                                    <label class="form-check-label" for="size_all">
                                        {{ __('Todas las tallas') }}
                                    </label>
                                </div>
                                @foreach($tallas as $size)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="size" id="size_{{ str_replace(" ", "_", str_replace(".", "", $size)) }}" value="{{ $size }}" {{ request("size") == $size ? "checked" : "" }}>
                                        <label class="form-check-label" for="size_{{ str_replace(" ", "_", str_replace(".", "", $size)) }}">
                                            {{ $size }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-apply-filters">
                            <i class="fas fa-check me-1"></i> {{ __('Aplicar Filtros') }}
                        </button>
                        <a href="{{ route("catalogo") }}" class="btn btn-secondary btn-clear-filters">
                            <i class="fas fa-times me-1"></i> {{ __('Limpiar Filtros') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Grid de Zapatillas -->
        <div class="col-lg-9">
            @include('sneakers.partials.filter-summary')

            @if($zapatillas->count() > 0)
                @php
                    $catalogReturnUrl = request()->url();
                    $catalogQuery = http_build_query(request()->except(['ajax', 'page']));
                    if ($catalogQuery) {
                        $catalogReturnUrl .= '?' . $catalogQuery;
                    }
                @endphp

                @include('sneakers.partials.home-widgets')

                <!-- Grid de Zapatillas con Lazy Load -->
                <div class="row g-4" id="sneakerGrid">
                    @foreach($zapatillas as $sneaker)
                        <div class="col-6 col-sm-4 col-lg-4">
                            <div class="card sneaker-card" style="position: relative; transition: all 0.3s ease;">
                                <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                                @auth
                                    @php
                                        $isFavorited = in_array($sneaker->id, $idsFavoritos);
                                    @endphp
                                    @if($isFavorited)
                                        <form class="favorite-form" action="{{ route("favorites.remove") }}" method="POST"
                                            data-add-url="{{ route("favorites.add") }}"
                                            data-remove-url="{{ route("favorites.remove") }}"
                                            data-card-selector=".card">
                                            @csrf
                                            <input type="hidden" name="sneaker_id" value="{{ $sneaker->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                                style="width: 40px; height: 40px; border-radius: 50%;" aria-label="{{ __('Quitar de favoritos') }}">
                                                <i class="fas fa-heart text-white"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form class="favorite-form" action="{{ route("favorites.add") }}" method="POST"
                                            data-add-url="{{ route("favorites.add") }}"
                                            data-remove-url="{{ route("favorites.remove") }}"
                                            data-card-selector=".card">
                                            @csrf
                                            <input type="hidden" name="sneaker_id" value="{{ $sneaker->id }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm"
                                                style="width: 40px; height: 40px; border-radius: 50%;" aria-label="{{ __('Añadir a favoritos') }}">
                                                <i class="far fa-heart"></i>
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login', ['redirect_to' => $catalogReturnUrl]) }}" class="btn btn-outline-primary btn-sm shadow-sm login-redirect"
                                        style="width: 40px; height: 40px; border-radius: 50%;" aria-label="{{ __('Iniciar sesión para añadir a favoritos') }}">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                @endauth
                            </div>

                            <a href="{{ route('sneaker.show', [$sneaker->id, 'return_url' => $catalogReturnUrl]) }}" class="text-decoration-none">
                                    <div class="position-relative overflow-hidden" style="height: 250px;">
                                        <img src="{{ $sneaker->image_url }}"
                                            alt="{{ $sneaker->name }}" class="w-100 h-100"
                                            style="object-fit: cover; transition: transform 0.3s ease;">
                                    </div>
                                </a>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-dark fw-bold mb-2">{{ $sneaker->name }}</h5>
                                    <p class="text-muted mb-2 product-sku" style="font-size: 0.9rem;">
                                        <strong>SKU:</strong> {{ $sneaker->sku }}
                                    </p>
                                    <p class="text-muted mb-2 product-brand" style="font-size: 0.85rem;">
                                        <small><strong>Marca:</strong> {{ $sneaker->brand }}</small>
                                    </p>
                                    @if($sneaker->translated_color)
                                        <p class="text-muted mb-3 product-color" style="font-size: 0.85rem;">
                                            <small><strong>Color:</strong> {{ $sneaker->translated_color }}</small></p>
                                    @endif
                                    <h5 class="text-primary fw-bold mb-3">${{ number_format($sneaker->price, 2) }}</h5>
                                    <a href="{{ route('sneaker.show', [$sneaker->id, 'return_url' => $catalogReturnUrl]) }}" class="btn btn-primary btn-sm w-100 mt-auto">
                                        <i class="fas fa-eye me-1"></i> {{ __('Ver Detalles') }}
                                    </a>
                                </div>
                            </div>
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
                    <h5>{{ __('No se encontraron zapatillas') }}</h5>
                    <p>{{ __('Intenta ajustar los filtros o la búsqueda') }}</p>
                    <a href="{{ route("catalogo") }}" class="btn btn-primary">{{ __('Ver todas las zapatillas') }}</a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section("scripts")
    @vite(["resources/js/filters-toggle.js", "resources/js/catalog-lazy-load.js", "resources/js/catalog-favorites.js", "resources/js/sneaker-recently-viewed.js"])
@endsection
