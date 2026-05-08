@php
    $topFavoritesReturnUrl = request()->url();
    $topFavoritesQuery = http_build_query(request()->except('ajax'));
    if ($topFavoritesQuery) {
        $topFavoritesReturnUrl .= '?' . $topFavoritesQuery;
    }
    $zapatillasTop = $zapatillasTop ?? collect([]);
@endphp
<div id="topFavoritesSection" data-url="{{ route('sneaker.top-favorites.ajax') }}">
    @if($zapatillasTop->count() > 0)
        <div class="top-favorites-section mb-4">
            <h5 class="mb-3">
                <i class="fas fa-heart text-danger me-2"></i>{{ __('Más Favoritas') }}
            </h5>
            <div class="row g-2">
                @foreach($zapatillasTop as $index => $sneaker)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('sneaker.show', [$sneaker->id, 'return_url' => $topFavoritesReturnUrl]) }}" class="text-decoration-none">
                            <div class="top-favorite-card p-2 border rounded shadow-sm h-100">
                                <img src="{{ $sneaker->image_url }}" alt="{{ $sneaker->name }}" class="img-fluid rounded"
                                    style="height: 80px; object-fit: cover; width: 100%;">
                                <div class="mt-2">
                                    <small class="text-dark d-block text-truncate">{{ $sneaker->name }}</small>
                                    <small class="text-danger">
                                        <i class="fas fa-heart"></i> {{ $sneaker->favorited_by_users_count }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>