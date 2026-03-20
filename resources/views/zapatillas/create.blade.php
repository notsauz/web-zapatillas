@extends('layouts.app')

@section('content')
    <h1>Crear Zapatilla</h1>
    <form action="{{ route('zapatillas.store') }}" method="POST">
        @csrf
        <label>SKU</label><br>
        <input name="sku" value="{{ old('sku') }}"><br>

        <label>Nombre</label><br>
        <input name="nombre" value="{{ old('nombre') }}"><br>

        <label>Precio</label><br>
        <input name="precio" value="{{ old('precio') }}"><br>

        <label>Marca</label><br>
        <select name="marca_id">
            <option value="">Selecciona marca</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>{{ $marca->nombre }}
                </option>
            @endforeach
        </select><br>

        <label>Modelo</label><br>
        <select name="modelo_id">
            <option value="">Selecciona modelo</option>
            @foreach($modelos as $modelo)
                <option value="{{ $modelo->id }}" {{ old('modelo_id') == $modelo->id ? 'selected' : '' }}>{{ $modelo->nombre }}
                </option>
            @endforeach
        </select><br>

        <label>Imagen URL</label><br>
        <input name="imagen_url" value="{{ old('imagen_url') }}"><br>

        <label>Tendencia</label>
        <input type="checkbox" name="tendencia" value="1" {{ old('tendencia') ? 'checked' : '' }}><br>

        <button type="submit">Guardar</button>
    </form>
    <a href="{{ route('zapatillas.index') }}">Volver</a>
@endsection