@extends('admin.layout')

@section('admin-content')
    <!-- Encabezado con título y botón para crear nueva marca -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Marcas</h2>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Agregar Marca
        </a>
    </div>

    <!-- Tabla principal que muestra todas las marcas registradas -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">

                <!-- Encabezado de la tabla -->
                <thead>
                    <tr class="table-light">
                        <th>Nombre</th>
                        <th>Zapatillas</th>
                        <th>Logo</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <!-- Cuerpo de la tabla -->
                <tbody>
                    @forelse($marcas as $brand)
                        <tr>
                            <td class="fw-bold">{{ $brand->name }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $brand->sneakers_count ?? 0 }} zapatillas</span>
                            </td>
                            <!-- Logo -->
                            <td>
                                @if ($brand->logo_url)
                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}"
                                        style="height: 40px; width: auto; max-width: 100px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <!-- Descripción -->
                            <td>
                                @if ($brand->description)
                                    <small>{{ Str::limit($brand->description, 50) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <!-- Acciones -->
                            <td>
                                <!-- Botón para editar marca -->
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Formulario para eliminar marca -->
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta marca y sus zapatillas asociadas?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox me-2"></i>No hay marcas registradas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($marcas->hasPages())
            <!-- Paginación para navegar entre páginas -->
            <div class="card-footer">
                {{ $marcas->links() }}
            </div>
        @endif
    </div>

@endsection