@extends('layouts.app')

@section('content')
    <h1>Zapatillas</h1>
    <a href="{{ route('zapatillas.create') }}">Nueva zapatilla</a>
    <br><br>
    <div>
        @forelse($zapatillas as $zapatilla)
            <div>
                <div>{{ $zapatilla->nombre }}</div>
                <div>{{ $zapatilla->sku }}</div>
                <div>{{ $zapatilla->modelo->marca->nombre ?? 'N/A' }}</div>
                <div>{{ $zapatilla->precio ?? 'N/A' }}</div>
                <div>
                    <a href="{{ route('zapatillas.show', $zapatilla) }}">Mostrar</a> |
                    <a href="{{ route('zapatillas.edit', $zapatilla) }}">Editar</a>
                    <form action="{{ route('zapatillas.destroy', $zapatilla) }}" method="POST" style="display:inline"
                        onsubmit="return confirm('¿Borrar esta zapatilla?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Borrar</button>
                    </form>
                </div>
            </div>
            <br><br>
        @empty
            <div>No hay zapatillas registradas.</div>
        @endforelse
    </div>

    <div>{{ $zapatillas->links() }}</div>
@endsection