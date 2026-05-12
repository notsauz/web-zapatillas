@extends('admin.layout')

@section('admin-content')
    <link rel="stylesheet" href="{{ asset('css/admin/sneakers-form.css') }}">

    <!-- Encabezado de la página -->
    <div class="mb-4">
        <h2>{{ __('Crear Nueva Marca') }}</h2>
        <p class="text-muted">{{ __('Completa el formulario para agregar una nueva marca') }}</p>
    </div>

    <!-- Contenedor del formulario de creación de marca -->
    <div class="card">
        <div class="card-body">
            <!-- Formulario POST para guardar la nueva marca -->
            <form method="POST" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Campo de nombre de la marca (obligatorio) -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Nombre de la Marca') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name') }}" required placeholder="{{ __('Ej: Nike, Adidas, Puma...') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sección para carga del logo de la marca (obligatorio) -->
                <div class="mb-3">
                    <label class="form-label d-block">{{ __('Logo de la Marca') }} <span class="text-danger">*</span>
                        ({{ __('obligatorio') }})</label>

                    <!-- Zona interactiva para soltar archivo del logo -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card border-2 border-dashed" id="dropZone"
                                style="min-height: 150px; display: flex; align-items: center; justify-content: center; cursor: pointer; background-color: #f8f9fa; transition: all 0.3s;">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-2"><strong>{{ __('Arrastra el logo aquí') }}</strong></p>
                                    <p class="text-muted mb-0 small">{{ __('o haz clic para seleccionar') }}</p>
                                </div>
                            </div>
                            <input type="file" id="logoFile" name="logo_file"
                                accept="image/jpeg,image/png,image/gif,image/webp,image/avif" style="display: none;">
                        </div>

                        <!-- Vista previa del logo con opción de eliminar -->
                        <div class="col-md-6">
                            <div id="logoPreviewContainer" style="display: none;">
                                <img id="logoPreview" src="" alt="Preview"
                                    style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2 w-100" id="clearLogoBtn">
                                    <i class="fas fa-trash me-2"></i>{{ __('Limpiar logo') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Campo alternativo para ingresar URL del logo -->
                    <div class="mb-3">
                        <label for="logo_url" class="form-label">{{ __('O ingresa una URL del logo') }}</label>
                        <input type="url" class="form-control @error('logo_url') is-invalid @enderror" id="logo_url"
                            name="logo_url" value="{{ old('logo_url') }}"
                            placeholder="{{ __('https://ejemplo.com/logo.png') }}">
                        @error('logo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="description_es" class="form-label">{{ __('Descripción (ES)') }}</label>
                        <textarea class="form-control @error('description_es') is-invalid @enderror" id="description_es"
                            name="description_es" rows="4"
                            placeholder="{{ __('Describe la marca en español...') }}">{{ old('description_es') }}</textarea>
                        @error('description_es')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="description_en" class="form-label">{{ __('Descripción (EN)') }}</label>
                        <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en"
                            name="description_en" rows="4"
                            placeholder="{{ __('Describe the brand in English...') }}">{{ old('description_en') }}</textarea>
                        @error('description_en')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botones de acción para enviar el formulario o cancelar -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>{{ __('Crear Marca') }}
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>{{ __('Cancelar') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/admin/brands-form.js')
@endsection