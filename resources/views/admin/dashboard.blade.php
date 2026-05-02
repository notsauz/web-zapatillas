@extends('admin.layout')

@section('admin-content')
    <!-- Encabezado del dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('Dashboard') }}</h2>
    </div>

    <!-- Tarjetas de estadísticas generales del sistema -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">{{ __('Total Zapatillas') }}</h5>
                    <h2 class="text-primary">{{ $totalZapatillas }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">{{ __('Total Marcas') }}</h5>
                    <h2 class="text-success">{{ $totalMarcas }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">{{ __('Precio Promedio') }}</h5>
                    <h2 class="text-info">${{ number_format($precioPromedio, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title text-muted">{{ __('Recientes (7d)') }}</h5>
                    <h2 class="text-warning">{{ $zapatillasUltimaSemana }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de accesos rápidos a funcionalidades principales -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="btn-group" role="group" style="width: 100%; gap: 10px;">
                <a href="{{ route('admin.sneakers.create') }}" class="btn btn-primary flex-fill">
                    <i class="fas fa-plus me-2"></i>{{ __('Crear Zapatilla') }}
                </a>
                <a href="{{ route('admin.brands.create') }}" class="btn btn-success flex-fill">
                    <i class="fas fa-plus me-2"></i>{{ __('Crear Marca') }}
                </a>
                <a href="{{ route('admin.sneakers.index') }}" class="btn btn-info flex-fill">
                    <i class="fas fa-list me-2"></i>{{ __('Ver Zapatillas') }}
                </a>
                <a href="{{ route('admin.brands.index') }}" class="btn btn-warning flex-fill">
                    <i class="fas fa-list me-2"></i>{{ __('Ver Marcas') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de últimas zapatillas agregadas para monitoreo rápido -->
    <div class="row">
        <div class="col-md-12">
            <h4 class="mb-3">{{ __('Últimas Zapatillas Agregadas') }}</h4>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Marca') }}</th>
                                <th>{{ __('Categoría') }}</th>
                                <th>{{ __('Precio') }}</th>
                                <th>{{ __('SKU') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($zapatillasRecientes as $sneaker)
                                <tr>
                                    <td>{{ $sneaker->name }}</td>
                                    <td>
                                        @if ($sneaker->brandModel)
                                            <span class="badge bg-secondary">{{ $sneaker->brandModel->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-light text-dark">{{ ucfirst($sneaker->category) }}</span></td>
                                    <td>${{ number_format($sneaker->price, 2) }}</td>
                                    <td><code>{{ $sneaker->sku }}</code></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        {{ __('No hay zapatillas registradas') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection