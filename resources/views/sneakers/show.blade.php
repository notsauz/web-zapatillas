@extends('layouts.app')

@section('content')
    <div class="row">
        <!-- Imagen del Producto -->
        <div class="col-md-6 mb-4">
            <img src="{{ $sneaker->image_url ?? 'https://via.placeholder.com/400x400?text=Sneaker' }}"
                alt="{{ $sneaker->name }}" class="img-fluid rounded">
        </div>

        <!-- Información del Producto -->
        <div class="col-md-6">
            <h1>{{ $sneaker->name }}</h1>

            <!-- SKU -->
            <p class="text-muted">
                SKU: <strong>{{ $sneaker->sku }}</strong>
            </p>

            <!-- Precio -->
            <h3 class="text-success my-3">${{ number_format($sneaker->price, 2) }}</h3>

            <!-- Información Adicional -->
            <div class="mb-4">
                <p>
                    <strong>Marca:</strong> {{ $sneaker->brand }}
                </p>
                <p>
                    <strong>Categoría:</strong> {{ ucfirst($sneaker->category) }}
                </p>
                @if($sneaker->color)
                    <p>
                        <strong>Color:</strong> {{ $sneaker->color }}
                    </p>
                @endif
                @if($sneaker->sizes)
                    <p>
                        <strong>Tallas Disponibles:</strong>
                        {{ implode(', ', $sneaker->sizes) }}
                    </p>
                @endif
            </div>

            <!-- Descripción -->
            @if($sneaker->description)
                <div class="mb-4">
                    <h5>Descripción</h5>
                    <p>{{ $sneaker->description }}</p>
                </div>
            @endif

            <!-- Botones -->
            <div class="d-flex gap-2">
                <a href="{{ route('catalogo') }}" class="btn btn-outline-secondary">Volver al Catálogo</a>
            </div>
        </div>
    </div>

    <!-- Productos Relacionados -->
    @if($relatedSneakers->count() > 0)
        <div class="row mt-5 pt-4 border-top">
            <div class="col-12">
                <h4>Otros modelos {{ $sneaker->brand }}</h4>
            </div>

            @foreach($relatedSneakers as $related)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $related->name }}</h5>
                            <p class="text-muted mb-2">
                                <small>{{ $related->sku }}</small>
                            </p>
                            <h6 class="text-success">${{ number_format($related->price, 2) }}</h6>
                            <a href="{{ route('sneaker.show', $related->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection