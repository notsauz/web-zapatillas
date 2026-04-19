@forelse($sneakers as $sneaker)
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
            <i class="fas fa-inbox me-2"></i>No hay más zapatillas
        </td>
    </tr>
@endforelse
