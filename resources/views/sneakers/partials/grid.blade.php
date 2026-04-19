@forelse($sneakers as $sneaker)
    <div class="col-4 col-sm-6 col-lg-4">
        <!-- Tarjeta de Producto -->
        <a href="{{ route('sneaker.show', $sneaker->id) }}" class="text-decoration-none">
            <!-- Imagen del Producto -->
            <div class="card sneaker-card h-100" style="transition: all 0.3s ease;">
                <!-- Contenedor de la Imagen -->
                <div class="position-relative overflow-hidden" style="height: 250px;">
                    <img src="{{ $sneaker->image_url }}" alt="{{ $sneaker->name }}" class="w-100 h-100"
                        alt="{{ $sneaker->name }}" class="w-100 h-100"
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
@empty
    <div class="alert alert-info text-center">
        <h5>No se encontraron zapatillas</h5>
        <p>Intenta ajustar los filtros o la búsqueda</p>
    </div>
@endforelse