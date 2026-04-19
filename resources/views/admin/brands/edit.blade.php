@extends('admin.layout')

@section('admin-content')
    <link rel="stylesheet" href="{{ asset('css/admin/sneakers-form.css') }}">

    <!-- Encabezado -->
    <div class="mb-4">
        <h2>Editar Marca</h2>
        <p class="text-muted">Modifica los detalles de la marca</p>
    </div>

    <!-- Formulario de Edición -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nombre de la Marca -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre de la Marca <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $brand->name) }}" required placeholder="Ej: Nike, Adidas, Puma...">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Logo de la Marca -->
                <div class="mb-3">
                    <label class="form-label d-block">Logo de la Marca (opcional)</label>

                    <!-- Zona de Soltar -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card border-2 border-dashed" id="dropZone"
                                style="min-height: 150px; display: flex; align-items: center; justify-content: center; cursor: pointer; background-color: #f8f9fa; transition: all 0.3s;">
                                <div class="text-center">
                                    <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                    <p class="mb-2"><strong>Arrastra el logo aquí</strong></p>
                                    <p class="text-muted mb-0 small">o haz clic para seleccionar</p>
                                </div>
                            </div>
                            <input type="file" id="logoFile" name="logo_file"
                                accept="image/jpeg,image/png,image/gif,image/webp,image/avif" style="display: none;">
                        </div>

                        <!-- Vista Previa del Logo -->
                        <div class="col-md-6">
                            <div id="logoPreviewContainer">
                                <img id="logoPreview" src="{{ $brand->logo_url }}" alt="Preview"
                                    style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                                <button type="button" class="btn btn-sm btn-danger mt-2 w-100" id="clearLogoBtn">
                                    <i class="fas fa-trash me-2"></i>Limpiar logo
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- URL del Logo -->
                    <div class="mb-3">
                        <label for="logo_url" class="form-label">O ingresa una URL del logo</label>
                        <input type="url" class="form-control @error('logo_url') is-invalid @enderror" id="logo_url"
                            name="logo_url" value="{{ old('logo_url', '') }}" placeholder="https://ejemplo.com/logo.png">
                        @error('logo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" rows="4"
                        placeholder="Describe la marca, su historia, sus características...">{{ old('description', $brand->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Actualizar Marca
                    </button>
                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @vite('resources/js/admin/brands-form.js')
@endsection