<!-- Componente de fila de tabla para mostrar los datos de cada zapatilla -->
@forelse($zapatillas as $sneaker)
    <!-- Fila de tabla que muestra los datos de una zapatilla -->
    <tr>
        <!-- Nombre de la zapatilla en negrita -->
        <td class="fw-bold">{{ $sneaker->name }}</td>
        <!-- Marca asociada a la zapatilla con badge -->
        <td>
            @if ($sneaker->brandModel)
                <span class="badge bg-secondary">{{ $sneaker->brandModel->name }}</span>
            @else
                <span class="badge bg-danger">{{ __('Sin marca') }}</span>
            @endif
        </td>
        <!-- Categoría de la zapatilla formateada en badge -->
        <td>
            <span class="badge bg-info">{{ ucfirst($sneaker->category) }}</span>
        </td>
        <!-- Precio formateado con símbolo de moneda -->
        <td>${{ number_format($sneaker->price, 2) }}</td>
        <!-- SKU (código único) mostrado en formato code -->
        <td><code>{{ $sneaker->sku }}</code></td>
        <!-- Tallas disponibles (mostrando primeras 3 y puntos suspensivos si hay más) -->
        <td>
            @if ($sneaker->sizes && count($sneaker->sizes) > 0)
                <small>{{ implode(', ', array_slice($sneaker->sizes, 0, 3)) }}{{ count($sneaker->sizes) > 3 ? '...' : '' }}</small>
            @else
                <span class="text-muted">-</span>
            @endif
        </td>
        <!-- Acciones (editar y eliminar) con botones interactivos -->
        <td>
            <a href="{{ route('admin.sneakers.edit', $sneaker->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
            <form method="POST" action="{{ route('admin.sneakers.destroy', $sneaker->id) }}" class="d-inline"
                onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta zapatilla?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
    <!-- Mensaje cuando no hay zapatillas registradas -->
@empty
    <tr>
        <td colspan="7" class="text-center text-muted py-4">
            <i class="fas fa-inbox me-2"></i>{{ __('No hay más zapatillas') }}
        </td>
    </tr>
@endforelse