@extends("layouts.app")

@section("content")
    <div class="mb-4">
        <h1 class="mb-4">{{ __('Marcas Disponibles') }}</h1>
        <p class="text-muted">{{ __('Explora todas nuestras marcas de zapatillas premium') }}</p>
    </div>

    <div class="row g-4">
        @forelse($marcas as $brand)
            <div class="col-12 col-md-6 col-lg-4">
                <a href="/marcas/{{ urlencode($brand) }}" class="text-decoration-none">
                    <div class="card h-100 text-center p-4 brand-card" style="cursor: pointer; transition: all 0.3s;">
                        <div
                            style="height: 100px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <h3 style="margin: 0; font-weight: bold; color: #333;">{{ $brand }}</h3>
                        </div>
                        <p class="text-muted mb-0 mt-auto">{{ __('Ver productos') }}</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h5>{{ __('No hay marcas disponibles') }}</h5>
                </div>
            </div>
        @endforelse
    </div>

    <style>
        .brand-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .brand-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
            background-color: #f8f9fa;
            border-color: #007bff;
        }

        .brand-card h3 {
            margin: 0;
            color: #333;
            font-weight: bold;
        }
    </style>
@endsection