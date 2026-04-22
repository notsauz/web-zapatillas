@forelse($zapatillas as $sneaker)
    <div class="col-4 col-sm-6 col-lg-4">
        <!-- Tarjeta de Producto -->
        <div class="position-relative">
            <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
                @auth
                    @php
                        $isFavorited = in_array($sneaker->id, $idsFavoritos);
                    @endphp
                    @if($isFavorited)
                        <form class="favorite-form" action="{{ route('favorites.remove') }}" method="POST"
                            data-add-url="{{ route('favorites.add') }}"
                            data-remove-url="{{ route('favorites.remove') }}"
                            data-card-selector=".card">
                            @csrf
                            <input type="hidden" name="sneaker_id" value="{{ $sneaker->id }}">
                            <button type="submit" class="btn btn-danger btn-sm shadow-sm"
                                style="width: 40px; height: 40px; border-radius: 50%;">
                                <i class="fas fa-heart text-white"></i>
                            </button>
                        </form>
                    @else
                        <form class="favorite-form" action="{{ route('favorites.add') }}" method="POST"
                            data-add-url="{{ route('favorites.add') }}"
                            data-remove-url="{{ route('favorites.remove') }}"
                            data-card-selector=".card">
                            @csrf
                            <input type="hidden" name="sneaker_id" value="{{ $sneaker->id }}">
                            <button type="submit" class="btn btn-outline-danger btn-sm shadow-sm"
                                style="width: 40px; height: 40px; border-radius: 50%;">
                                <i class="far fa-heart"></i>
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm shadow-sm"
                        style="width: 40px; height: 40px; border-radius: 50%;">
                        <i class="fas fa-heart"></i>
                    </a>
                @endauth
            </div>

            <a href="{{ route('sneaker.show', $sneaker->id) }}" class="text-decoration-none">
                <!-- Imagen del Producto -->
                <div class="card sneaker-card h-100" style="transition: all 0.3s ease;">
                    <div class="position-relative overflow-hidden" style="height: 250px;">
                        <img src="{{ $sneaker->image_url }}" alt="{{ $sneaker->name }}" class="w-100 h-100"
                            style="object-fit: cover; transition: transform 0.3s ease;">
                    </div>
                    <!-- Detalles del Producto -->
                    <div class="card-body d-flex flex-column">
                        <!-- Nombre -->
                        <h5 class="card-title text-dark fw-bold mb-2">{{ $sneaker->name }}</h5>
                        <!-- SKU -->
                        <p class="text-muted mb-2 product-sku" style="font-size: 0.9rem;">
                            <strong>SKU:</strong> {{ $sneaker->sku }}
                        </p>
                        <!-- Marca -->
                        <p class="text-muted mb-2 product-brand" style="font-size: 0.85rem;">
                            <small><strong>Marca:</strong> {{ $sneaker->brand }}</small>
                        </p>
                        <!-- Color (si existe) -->
                        @if($sneaker->color)
                            <p class="text-muted mb-3 product-color" style="font-size: 0.85rem;">
                                <small><strong>Color:</strong> {{ $sneaker->color }}</small>
                            </p>
                        @endif
                        <!-- Precio -->
                        <h5 class="text-primary fw-bold mb-3">${{ number_format($sneaker->price, 2) }}</h5>
                        <!-- Botón de Detalles -->
                        <button class="btn btn-primary btn-sm w-100 mt-auto">
                            <i class="fas fa-eye me-1"></i> Ver Detalles
                        </button>
                    </div>
                </div>
            </a>
        </div>
    </div>
@empty
    <div class="alert alert-info text-center">
        <h5>No se encontraron zapatillas</h5>
        <p>Intenta ajustar los filtros o la búsqueda</p>
    </div>
@endforelse