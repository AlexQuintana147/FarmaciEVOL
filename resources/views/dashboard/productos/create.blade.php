@extends('layouts.app')

@push('styles')
<style>
    .spinner-border {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    #descripcion {
        white-space: pre-wrap;
        font-family: inherit; /* Mejor que Courier New para texto normal */
        line-height: 1.6;
        padding: 10px;
        background-color: #f8f9fa;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tituloInput = document.getElementById('titulo');
        const descripcionTextarea = document.getElementById('descripcion');
        const autogenerarBtn = document.getElementById('autogenerar-descripcion');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Función para actualizar el estado del botón
        function actualizarEstadoBoton(estado) {
            switch(estado) {
                case 'cargando':
                    autogenerarBtn.disabled = true;
                    autogenerarBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando...';
                    break;
                case 'listo':
                    autogenerarBtn.disabled = false;
                    autogenerarBtn.innerHTML = '<i class="fas fa-magic me-1"></i>Autogenerar';
                    break;
                case 'error':
                    autogenerarBtn.disabled = false;
                    autogenerarBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Reintentar';
                    break;
            }
        }

        autogenerarBtn.addEventListener('click', async function() {
            const titulo = tituloInput.value.trim();
            
            if (!titulo) {
                mostrarAlerta('Por favor ingrese un título para el producto', 'warning');
                return;
            }

            actualizarEstadoBoton('cargando');
            
            try {
                const response = await fetch('{{ route("generar.descripcion") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: titulo })
                });

                const data = await response.json();
                
                if (response.ok && data && data.success) {
                    if (data.message && data.message.trim() !== '') {
                        // Aplicar formato aquí
                        const formattedDescription = formatProductDescription(data.message);
                        descripcionTextarea.value = formattedDescription;
                        mostrarAlerta('¡Descripción generada con éxito!', 'success');
                    } else {
                        throw new Error('La descripción generada está vacía');
                    }
                } else {
                    throw new Error(data.message || 'No se pudo generar la descripción');
                }
            } catch (error) {
                console.error('Error:', error);
                mostrarAlerta(error.message || 'Ocurrió un error al generar la descripción', 'error');
                actualizarEstadoBoton('error');
            } finally {
                if (autogenerarBtn.disabled) {
                    actualizarEstadoBoton('listo');
                }
            }
        });

        function formatProductDescription(description) {
            // Versión que mantiene estructura pero mejora formato
            return description
                .replace(/\*\*(.*?)\*\*/g, '$1') // Mantiene el texto en negrita pero sin **
                .replace(/(\n|^)\s*/g, '$1')     // Elimina espacios iniciales
                .replace(/\n{3,}/g, '\n\n')       // Máximo 2 saltos de línea seguidos
                .trim();
        }


        function mostrarAlerta(mensaje, tipo = 'success') {
            // Aquí puedes implementar tu propio sistema de notificaciones
            // Por ahora usaremos alertas nativas
            if (tipo === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: mensaje,
                    confirmButtonColor: '#3085d6',
                });
            } else if (tipo === 'warning') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: mensaje,
                    confirmButtonColor: '#3085d6',
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: mensaje,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    });
</script>
@endpush
<div class="container py-4">
    <div class="bg-gradient-primary-to-secondary p-3 rounded-3 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0"><i class="fas fa-pills me-2"></i>Crear Nuevo Producto</h1>
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
            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="titulo" class="form-label fw-bold text-primary"><i class="fas fa-tag me-1"></i> Título del Producto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Nombre del producto" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="categoria" class="form-label fw-bold text-primary"><i class="fas fa-folder me-1"></i> Categoría <span class="text-danger">*</span></label>
                            <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="" selected disabled>Seleccionar categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria }}" {{ old('categoria') == $categoria ? 'selected' : '' }}>{{ $categoria }}</option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text"><i class="fas fa-info-circle"></i> Seleccione la categoría que mejor describe su producto.</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold text-primary"><i class="fas fa-align-left me-1"></i> Descripción <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="7" placeholder="Describa las características y beneficios del producto" required>{{ old('descripcion') }}</textarea>
                                <button type="button" class="btn btn-outline-primary" id="autogenerar-descripcion">
                                    <i class="fas fa-magic me-1"></i>Autogenerar
                                </button>
                            </div>
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
                                        <div id="preview-placeholder">
                                            <i class="fas fa-image fa-3x text-primary opacity-50"></i>
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
                    <a href="{{ route('dashboard.productos') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection