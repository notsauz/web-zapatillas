<div class="sneaker-card">
    <div class="sneaker-image">
        <img src="{{ $sneaker->image_url ?? 'https://via.placeholder.com/250x200?text=No+Image' }}"
            alt="{{ $sneaker->name }}" loading="lazy">
    </div>
    <!-- Información del Producto -->
    <div class="sneaker-info">
        <!-- Nombre -->
        <h6 class="sneaker-name">{{ $sneaker->name }}</h6>
        <!-- SKU -->
        <small class="sneaker-sku"><strong>SKU:</strong> {{ $sneaker->sku }}</small>
        <!-- Categoría y Marca -->
        <small class="sneaker-meta">
            <span class="badge bg-info">{{ ucfirst($sneaker->category) }}</span>
            <span class="badge bg-secondary">{{ $sneaker->brand }}</span>
        </small>
        <!-- Color -->
        @if($sneaker->color)
            <small class="sneaker-meta"><strong>Color:</strong> {{ $sneaker->color }}</small>
        @endif
        <div class="sneaker-price">${{ number_format($sneaker->price, 2) }}</div>
    </div>
</div>