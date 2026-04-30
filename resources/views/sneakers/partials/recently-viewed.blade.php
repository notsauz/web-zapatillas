@php $vistasRecently = $vistasRecently ?? collect([]); @endphp
@if($vistasRecently->count() > 0)
    <div class="recently-viewed-section mb-4">
        <h5 class="mb-3">
            <i class="fas fa-history me-2"></i>Últimas visitadas
        </h5>
        <div class="row g-2">
            @foreach($vistasRecently as $sneaker)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route("sneaker.show", $sneaker->id) }}" class="text-decoration-none">
                        <div class="recently-viewed-card p-2 border rounded shadow-sm h-100">
                            <img src="{{ $sneaker->image_url }}" alt="{{ $sneaker->name }}" class="img-fluid rounded"
                                style="height: 80px; object-fit: cover; width: 100%;">
                            <div class="mt-2">
                                <small class="text-dark d-block text-truncate">{{ $sneaker->name }}</small>
                                <small class="text-success">${{ number_format($sneaker->price, 2) }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif