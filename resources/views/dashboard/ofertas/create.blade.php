@extends('layouts.app')

@push('styles')
<style>
    .spinner-border {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="bg-gradient-primary-to-secondary p-3 rounded-3 mb-4 shadow-sm" style="background: linear-gradient(135deg, #ff6b6b, #ff8e53);">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0"><i class="fas fa-tags me-2"></i>Crear Nueva Oferta</h1>
            <a href="{{ route('dashboard.ofertas') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="card shadow border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-danger"><i class="fas fa-percentage me-2"></i>Información de la Oferta</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('ofertas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="titulo" class="form-label fw-bold text-danger"><i class="fas fa-tag me-1"></i> Título de la Oferta <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Nombre de la oferta o promoción" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><i class="fas fa-info-circle"></i> Ejemplo: "Descuento 20% en Medicamentos", "2x1 en Vitaminas"</div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-light py-3">
                                <h6 class="mb-0 text-danger"><i class="fas fa-camera-retro me-2"></i>Imagen de la Oferta</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="imagen" class="form-label fw-bold">Seleccionar imagen <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" id="imagen" name="imagen" accept="image/*" required>
                                    <div class="form-text"><i class="fas fa-info-circle me-1"></i> Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                                    @error('imagen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mt-4 p-3 border rounded bg-light">
                                    <div class="image-preview text-center d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <div id="preview-placeholder">
                                            <i class="fas fa-image fa-3x text-danger opacity-50"></i>
                                            <p class="mt-2 text-muted">Vista previa de imagen</p>
                                        </div>
                                        <img id="preview-image" src="#" alt="Vista previa" class="img-fluid rounded shadow-sm" style="max-height: 180px; max-width: 100%; display: none;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard.ofertas') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="fas fa-save me-2"></i>Guardar Oferta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Vista previa de imagen
    document.addEventListener('DOMContentLoaded', function() {
        const imagenInput = document.getElementById('imagen');
        const previewImage = document.getElementById('preview-image');
        const previewPlaceholder = document.getElementById('preview-placeholder');
        
        imagenInput.addEventListener('change', function(e) {
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
                previewImage.style.display = 'none';
                previewPlaceholder.style.display = 'block';
            }
        });
    });
</script>
@endpush
@endsection