@extends('admin.layout')

@section('admin-content')
<link rel="stylesheet" href="{{ asset('css/admin/sneakers-form.css') }}">

<div class="mb-4">
    <h2>Editar Zapatilla</h2>
    <p class="text-muted">Modifica los detalles de la zapatilla</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.sneakers.update', $sneaker->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nombre de la Zapatilla -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre de la Zapatilla <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name', $sneaker->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Marca -->
                <div class="col-md-6">
                    <label for="brand_id" class="form-label">Marca <span class="text-danger">*</span></label>
                    <select class="form-select @error('brand_id') is-invalid @enderror" 
                            id="brand_id" name="brand_id" required>
                        <option value="">-- Selecciona una marca --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" 
                                    {{ old('brand_id', $sneaker->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- SKU -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                        id="sku" name="sku" value="{{ old('sku', $sneaker->sku) }}" required 
                        placeholder="Ej: NK-AIR-MAX-001">
                    <small class="form-text text-muted">Código único para la zapatilla</small>
                    @error('sku')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Categoría -->
                <div class="col-md-6">
                    <label for="category" class="form-label">Categoría <span class="text-danger">*</span></label>
                    <select class="form-select @error('category') is-invalid @enderror" 
                            id="category" name="category" required>
                        <option value="">-- Selecciona una categoría --</option>
                        <option value="hombre" {{ old('category', $sneaker->category) == 'hombre' ? 'selected' : '' }}>Hombre</option>
                        <option value="mujer" {{ old('category', $sneaker->category) == 'mujer' ? 'selected' : '' }}>Mujer</option>
                        <option value="niño" {{ old('category', $sneaker->category) == 'niño' ? 'selected' : '' }}>Niño</option>
                        <option value="unisex" {{ old('category', $sneaker->category) == 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Precio -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="price" class="form-label">Precio <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                            id="price" name="price" value="{{ old('price', $sneaker->price) }}" required 
                            placeholder="0.00">
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                        id="color" name="color" value="{{ old('color', $sneaker->color) }}" 
                        placeholder="Ej: Negro, Rojo, etc.">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Descripción -->
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                        id="description" name="description" rows="3" 
                        placeholder="Describe las características de la zapatilla...">{{ old('description', $sneaker->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tallas Disponibles -->
            <div class="mb-3">
                <label class="form-label d-block">Tallas Disponibles <span class="text-danger">*</span></label>
                <div class="d-flex flex-wrap gap-2 mb-2" id="sizesContainer">
                    @php
                        $allSizes = ['32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48'];
                        $selectedSizes = old('sizes', $sneaker->sizes && is_array($sneaker->sizes) ? $sneaker->sizes : []);
                    @endphp
                    @foreach ($allSizes as $size)
                        <button type="button" class="btn btn-outline-secondary size-btn {{ in_array($size, (array)$selectedSizes) ? 'active' : '' }}" 
                                data-size="{{ $size }}">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
                <input type="hidden" id="sizes" name="sizes" value="{{ old('sizes', $sneaker->sizes ? implode(', ', (array)$sneaker->sizes) : '') }}">
                @error('sizes')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Haz clic en las tallas disponibles</small>
            </div>

            <!-- Imagen -->
            <div class="mb-3">
                <label class="form-label d-block">Imagen</label>
                
                <!-- Zona de Soltar Imagen -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="card border-2 border-dashed" id="dropZone" style="min-height: 150px; display: flex; align-items: center; justify-content: center; cursor: pointer; background-color: #f8f9fa; transition: all 0.3s;">
                            <div class="text-center">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-2"><strong>Arrastra la imagen aquí</strong></p>
                                <p class="text-muted mb-0 small">o haz clic para seleccionar</p>
                            </div>
                        </div>
                        <input type="file" id="imageFile" name="image_file" accept="image/jpeg,image/png,image/gif,image/webp,image/avif" style="display: none;">
                    </div>
                    
                    <!-- Vista Previa de la Imagen -->
                    <div class="col-md-6">
                        <div id="imagePreviewContainer">
                            <img id="imagePreview" src="{{ $sneaker->image_url }}" alt="Preview" style="max-width: 100%; max-height: 200px; border-radius: 8px;">
                            <button type="button" class="btn btn-sm btn-danger mt-2 w-100" id="clearImageBtn">
                                <i class="fas fa-trash me-2"></i>Limpiar imagen
                            </button>
                        </div>
                    </div>
                </div>

                <!-- URL de la Imagen -->
                <div class="mb-3">
                    <label for="image_url" class="form-label">O ingresa una URL de imagen</label>
                    <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                        id="image_url" name="image_url" value="{{ old('image_url', '') }}" 
                        placeholder="https://ejemplo.com/imagen.jpg">
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Actualizar Zapatilla
                </button>
                <a href="{{ route('admin.sneakers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@vite('resources/js/admin/sneakers-form.js')
@endsection
