@extends('layouts.app')

@section('styles')
    @vite('resources/css/sneakers.index.css')
@endsection

@section('content')
    <div class="favorites-header mb-4 p-4 shadow-sm rounded-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <h2 class="mb-2">Mis Zapatillas Favoritas</h2>
                <p class="text-muted mb-0">Tu catálogo personal de favoritos, con el mismo estilo de visualización que el catálogo normal.</p>
            </div>
            <div class="favorites-actions btn-group" role="group" aria-label="Acciones de navegación">
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Perfil
                </a>
                <a href="{{ route('catalogo') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-th-large me-1"></i> Volver al Catálogo
                </a>
            </div>
        </div>
    </div>

    @if($sneakers->count() > 0)
        <div class="row g-4" id="sneakerGrid">
            @include('sneakers.partials.grid', ['sneakers' => $sneakers, 'favoriteSneakerIds' => $favoriteSneakerIds])
        </div>

        <div id="loadingSpinner" class="text-center mt-4" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <div id="sentinel" style="height: 1px; margin-top: 50px;"></div>
    @else
        <div class="alert alert-info text-center">
            <h5>No tienes zapatillas favoritas aún</h5>
            <p>Explora el catálogo y agrega tus preferidas haciendo clic en el corazón.</p>
            <a href="{{ route('catalogo') }}" class="btn btn-primary">Ir al Catálogo</a>
        </div>
    @endif
@endsection

@section('scripts')
    @vite(['resources/js/catalog-lazy-load.js', 'resources/js/catalog-favorites.js'])
@endsection