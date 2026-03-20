@extends('layouts.app')

@section('content')
    <h1>Detalle Zapatilla</h1>
    <p>SKU: {{ $zapatilla->sku }}</p>
    <p>Nombre: {{ $zapatilla->nombre }}</p>
    <p>Precio: {{ $zapatilla->precio }}</p>
    <p>Marca: {{ $zapatilla->modelo->marca->nombre ?? '-' }}</p>
    <p>Modelo: {{ $zapatilla->modelo->nombre ?? '-' }}</p>
    <a href="{{ route('zapatillas.index') }}">Volver</a>
@endsection