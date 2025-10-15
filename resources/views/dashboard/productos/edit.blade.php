@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-gradient-primary-to-secondary p-3 rounded-3 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0"><i class="fas fa-pills me-2"></i>Editar Producto</h1>
            <a href="{{ route('dashboard.productos') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="fas fa-box-open me-2"></i>Información del Producto</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="titulo" class="form-label fw-bold text-primary"><i class="fas fa-tag me-1"></i> Título del Producto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $producto->titulo) }}" placeholder="Nombre del producto" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="categoria" class="form-label fw-bold text-primary"><i class="fas fa-folder me-1"></i> Categoría <span class="text-danger">*</span></label>
                            <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="" disabled>Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria }}" {{ old('categoria', $producto->categoria) == $categoria ? 'selected' : '' }}>{{ $categoria }}</option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><i class="fas fa-info-circle"></i> Seleccione la categoría que mejor describe su producto.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold text-primary"><i class="fas fa-align-left me-1"></i> Descripción <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="7" placeholder="Describa las características y beneficios del producto" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><i class="fas fa-info-circle"></i> Incluya información relevante como composición, beneficios y modo de uso.</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light py-3">
                                <h6 class="mb-0 text-primary"><i class="fas fa-camera-retro me-2"></i>Imagen del Producto</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label fw-bold">Seleccionar imagen</label>
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" id="imagen" name="imagen" accept="image/*">
                                    <div class="form-text"><i class="fas fa-info-circle me-1"></i> Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mt-4 p-3 border rounded bg-light">
                                    <div class="image-preview text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                                        @if($producto->imagen)
                                            <img id="preview-image" src="{{ asset($producto->imagen) }}" alt="{{ $producto->titulo }}" class="img-fluid rounded shadow-sm" style="max-height: 180px; max-width: 100%;">
                                            <div id="preview-placeholder" style="display: none;">
                                                <i class="fas fa-image fa-3x text-primary opacity-50"></i>
                                                <p class="mt-2 text-muted">Vista previa de imagen</p>
                                            </div>
                                        @else
                                            <div id="preview-placeholder">
                                                <i class="fas fa-image fa-3x text-primary opacity-50"></i>
                                                <p class="mt-2 text-muted">Vista previa de imagen</p>
                                            </div>
                                            <img id="preview-image" src="#" alt="Vista previa" class="img-fluid rounded shadow-sm" style="max-height: 180px; max-width: 100%; display: none;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard.productos') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-2"></i>Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Vista previa de imagen
    document.getElementById('imagen').addEventListener('change', function(e) {
        const previewImage = document.getElementById('preview-image');
        const previewPlaceholder = document.getElementById('preview-placeholder');
        
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                previewPlaceholder.style.display = 'none';
            }
            
            reader.readAsDataURL(file);
        } else {
            @if(!$producto->imagen)
                previewImage.style.display = 'none';
                previewPlaceholder.style.display = 'block';
            @endif
        }
    });
</script>
@endpush
@endsection