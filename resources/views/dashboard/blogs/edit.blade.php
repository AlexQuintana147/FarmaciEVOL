@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-gradient-primary-to-secondary p-3 rounded-3 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0"><i class="fas fa-pen-fancy me-2"></i>Editar Blog</h1>
            <a href="{{ route('dashboard.blogs') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="fas fa-edit me-2"></i>Información del Blog</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="titulo" class="form-label fw-bold text-primary"><i class="fas fa-heading me-1"></i> Título del Blog <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $blog->titulo) }}" placeholder="Ingrese un título atractivo" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="subtitulo" class="form-label fw-bold text-primary"><i class="fas fa-align-left me-1"></i> Subtítulo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtitulo') is-invalid @enderror" id="subtitulo" name="subtitulo" value="{{ old('subtitulo', $blog->subtitulo) }}" placeholder="Breve descripción del contenido" required>
                            @error('subtitulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="contenido" class="form-label fw-bold text-primary"><i class="fas fa-file-alt me-1"></i> Contenido <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('contenido') is-invalid @enderror" id="contenido" name="contenido" rows="10" placeholder="Escriba el contenido detallado del blog" required>{{ old('contenido', $blog->contenido) }}</textarea>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><i class="fas fa-info-circle"></i> El contenido debe ser informativo y relevante para los lectores.</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light py-3">
                                <h6 class="mb-0 text-primary"><i class="fas fa-camera-retro me-2"></i>Imagen del Blog</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label fw-bold">Seleccionar imagen</label>
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" id="imagen" name="imagen">
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text"><i class="fas fa-info-circle me-1"></i> Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                                </div>
                                
                                <div class="mt-4 p-3 border rounded bg-light">
                                    <div class="preview-image text-center">
                                        @if($blog->imagen)
                                            <img id="preview" src="{{ asset($blog->imagen) }}" alt="{{ $blog->titulo }}" class="img-fluid rounded shadow-sm" style="max-width: 100%; max-height: 200px;">
                                            <div id="no-preview" class="py-5 d-flex flex-column align-items-center justify-content-center" style="display: none;">
                                                <i class="fas fa-image fa-4x text-primary opacity-50 mb-3"></i>
                                                <p class="text-muted">Vista previa de la imagen</p>
                                            </div>
                                        @else
                                            <img id="preview" src="#" alt="Vista previa" class="img-fluid rounded shadow-sm" style="max-width: 100%; max-height: 200px; display: none;">
                                            <div id="no-preview" class="py-5 d-flex flex-column align-items-center justify-content-center">
                                                <i class="fas fa-image fa-4x text-primary opacity-50 mb-3"></i>
                                                <p class="text-muted">Vista previa de la imagen</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard.blogs') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Actualizar Blog
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('imagen').addEventListener('change', function(e) {
        const preview = document.getElementById('preview');
        const noPreview = document.getElementById('no-preview');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.setAttribute('src', e.target.result);
                preview.style.display = 'block';
                noPreview.style.display = 'none';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            preview.style.display = 'none';
            noPreview.style.display = 'flex';
        }
    });
</script>
@endpush
@endsection