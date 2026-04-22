@extends('admin.layout')

@section('admin-content')
    <!-- Encabezado con título y botón para crear nueva zapatilla -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Zapatillas</h2>
        <a href="{{ route('admin.sneakers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Agregar Zapatilla
        </a>
    </div>

    <!-- Tabla principal que muestra todas las zapatillas registradas -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <!-- Encabezado de la tabla -->
                <thead>
                    <tr class="table-light">
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>SKU</th>
                        <th>Tallas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <!-- Cuerpo de la tabla -->
                <tbody>
                    @forelse($zapatillas as $sneaker)
                        <tr>
                            <td class="fw-bold">{{ $sneaker->name }}</td>
                            <td>
                                @if ($sneaker->brandModel)
                                    <span class="badge bg-secondary">{{ $sneaker->brandModel->name }}</span>
                                @else
                                    <span class="badge bg-danger">Sin marca</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($sneaker->category) }}</span>
                            </td>
                            <td>${{ number_format($sneaker->price, 2) }}</td>
                            <td><code>{{ $sneaker->sku }}</code></td>
                            <td>
                                @if ($sneaker->sizes && count($sneaker->sizes) > 0)
                                    <small>{{ implode(', ', array_slice($sneaker->sizes, 0, 3)) }}{{ count($sneaker->sizes) > 3 ? '...' : '' }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.sneakers.edit', $sneaker->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.sneakers.destroy', $sneaker->id) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta zapatilla?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-2"></i>No hay zapatillas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($zapatillas->hasPages())
            <!-- Paginación para navegar entre páginas -->
            <div class="card-footer">
                {{ $zapatillas->links() }}
            </div>
        @endif
    </div>
@endsection