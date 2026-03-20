@extends('layouts.app')

@section('content')
    <h1>Editar Zapatilla</h1>

    <form action="{{ route('zapatillas.update', $zapatilla) }}" method="POST">
        @csrf
        @method('PUT')

        <label>SKU</label><br>
        <input name="sku" value="{{ old('sku', $zapatilla->sku) }}"><br>

        <label>Nombre</label><br>
        <input name="nombre" value="{{ old('nombre', $zapatilla->nombre) }}"><br>

        <label>Precio</label><br>
        <input name="precio" value="{{ old('precio', $zapatilla->precio) }}"><br>

        <label>Marca</label><br>
        <select name="marca_id">
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ $zapatilla->marca_id == $marca->id ? 'selected' : '' }}>{{ $marca->nombre }}
                </option>
            @endforeach
        </select><br>

        <label>Modelo</label><br>
        <select name="modelo_id">
            @foreach($modelos as $modelo)
                <option value="{{ $modelo->id }}" {{ $zapatilla->modelo_id == $modelo->id ? 'selected' : '' }}>
                    {{ $modelo->nombre }}</option>
            @endforeach
        </select><br>

        <label>Imagen URL</label><br>
        <input name="imagen_url" value="{{ old('imagen_url', $zapatilla->imagen_url) }}"><br>

        <label>Tendencia</label>
        <input type="checkbox" name="tendencia" value="1" {{ old('tendencia', $zapatilla->tendencia) ? 'checked' : '' }}><br>

        <button type="submit">Actualizar</button>
    </form>
    <a href="{{ route('zapatillas.index') }}">Volver</a>
@endsection