@extends('layouts.app')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<div class="container py-4">
    <div class="bg-gradient-primary-to-secondary p-3 rounded-3 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0"><i class="fas fa-pen-fancy me-2"></i>Crear Nuevo Blog</h1>
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
            <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="titulo" class="form-label fw-bold text-primary"><i class="fas fa-heading me-1"></i> Título del Blog <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" placeholder="Ingrese un título atractivo" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="subtitulo" class="form-label fw-bold text-primary"><i class="fas fa-align-left me-1"></i> Subtítulo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subtitulo') is-invalid @enderror" id="subtitulo" name="subtitulo" value="{{ old('subtitulo') }}" placeholder="Breve descripción del contenido" required>
                            @error('subtitulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="contenido" class="form-label fw-bold text-primary mb-0">
                                    <i class="fas fa-file-alt me-1"></i> Contenido <span class="text-danger">*</span>
                                </label>
                                <button type="button" id="medirBlogBtn" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-ruler me-1"></i>Medir Contenido
                                </button>
                            </div>
                            <textarea class="form-control @error('contenido') is-invalid @enderror" id="contenido" name="contenido" rows="10" placeholder="Escriba el contenido detallado del blog" required>{{ old('contenido') }}</textarea>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle text-primary"></i> El contenido será analizado para evaluar su calidad y relevancia.
                            </div>
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
                                        <img id="preview" src="#" alt="Vista previa" class="img-fluid rounded shadow-sm" style="max-width: 100%; max-height: 200px; display: none;">
                                        <div id="no-preview" class="py-5 d-flex flex-column align-items-center justify-content-center">
                                            <i class="fas fa-image fa-4x text-primary opacity-50 mb-3"></i>
                                            <p class="text-muted">Vista previa de la imagen</p>
                                        </div>
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
                        <i class="fas fa-save me-2"></i>Guardar Blog
                    </button>
                </div>
                
                <!-- Resultado de la medición -->
                <div id="medicionResultado" class="mt-4 d-none">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light py-3">
                            <h6 class="mb-0 text-primary"><i class="fas fa-chart-bar me-2"></i>Resultado de la Medición</h6>
                        </div>
                        <div class="card-body">
                            <!-- Progress Bar -->
                            <div id="progressContainer" class="d-none mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Progreso del análisis</span>
                                    <span id="progressPercentage">0%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            
                            <div id="loadingState" class="text-center py-4">
                                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-3 mb-0 fw-medium">Analizando contenido del blog...</p>
                                <p class="text-muted small mt-2">Esto puede tomar unos segundos</p>
                            </div>
                            
                            <div id="resultadoContenido" class="d-none">
                                <!-- Aquí se mostrarán los resultados -->
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Botón de Análisis */
    #medirContenido {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    
    #medirContenido:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
    }
    
    #medirContenido:active {
        transform: translateY(0);
    }
    
    /* Medidor de Calidad */
    .gauge-container {
        width: 220px;
        height: 180px;
        margin: 0 auto;
        position: relative;
    }
    
    .gauge {
        width: 100%;
        height: 100%;
        position: relative;
    }
    
    .gauge-body {
        width: 100%;
        height: 0;
        padding-bottom: 50%;
        position: relative;
        border-top-left-radius: 110px 100px;
        border-top-right-radius: 110px 100px;
        overflow: hidden;
        background-color: #f5f8ff;
        border: 10px solid #f0f4ff;
        border-bottom: 0;
        box-sizing: border-box;
    }
    
    .gauge-fill {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        transform-origin: center top;
        transform: rotate(0.5turn);
        transition: transform 1s ease-out;
    }
    
    .gauge-cover {
        position: absolute;
        border-radius: 50%;
        background: white;
        width: 65%;
        height: 130%;
        bottom: -30%;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border: 8px solid #f8f9fe;
    }
    
    .gauge-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2d3748;
        line-height: 1;
        font-family: 'Lato', sans-serif;
    }
    
    .gauge-label {
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Grid de Métricas */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    
    .metric-item {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
        border: 1px solid #edf2f7;
    }
    
    .metric-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    
    .metric-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 1.1rem;
    }
    
    .metric-details {
        flex: 1;
    }
    
    .metric-title {
        display: block;
        font-size: 0.8rem;
        color: #718096;
        margin-bottom: 2px;
    }
    
    .metric-value {
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
    }
    
    /* Sección de Recomendaciones */
    .analysis-summary {
        background: #f8f9fe;
        border-radius: 10px;
        padding: 1.25rem;
        border: 1px solid #edf2f7;
    }
    
    .analysis-summary h6 {
        color: #4a5568;
        font-weight: 600;
    }
    
    #recommendations-list li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #edf2f7;
    }
    
    #recommendations-list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    #recommendations-list li i {
        font-size: 0.9rem;
    }
    
    /* Animaciones */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .analysis-results {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Elementos del DOM
            const medirBlogBtn = document.getElementById('medirBlogBtn');
            const tituloInput = document.getElementById('titulo');
            const contenidoInput = document.getElementById('contenido');
            const resultadoContenido = document.getElementById('resultadoContenido');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            if (!medirBlogBtn || !tituloInput || !contenidoInput || !resultadoContenido) {
                console.error('No se encontraron todos los elementos necesarios');
                return;
            }
            
            // Función para verificar si el botón debe estar habilitado
            function actualizarEstadoBoton() {
                const tituloValido = tituloInput.value.trim().length >= 4;
                const contenidoValido = contenidoInput.value.trim().length >= 4;
                const esValido = tituloValido && contenidoValido;
                
                // Actualizar estado y apariencia del botón
                medirBlogBtn.disabled = !esValido;
                medirBlogBtn.classList.toggle('btn-outline-primary', esValido);
                medirBlogBtn.classList.toggle('btn-outline-secondary', !esValido);
                medirBlogBtn.style.cursor = esValido ? 'pointer' : 'not-allowed';
                
                return esValido;
            }
            
            // Función para mostrar notificaciones con Toastr
            function mostrarAlerta(mensaje, tipo = 'success') {
                console.log(`[${tipo}] ${mensaje}`);
                
                // Verificar si Toastr está disponible
                if (typeof toastr === 'undefined') {
                    console.warn('Toastr no está cargado, usando alerta nativa');
                    alert(`${tipo.toUpperCase()}: ${mensaje}`);
                    return;
                }
                
                // Configuración de Toastr
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 5000,
                    extendedTimeOut: 1000,
                    showEasing: 'swing',
                    hideEasing: 'linear',
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut',
                    tapToDismiss: false
                };
                
                // Mostrar notificación según el tipo
                switch(tipo) {
                    case 'success':
                        toastr.success(mensaje, '¡Éxito!');
                        break;
                    case 'warning':
                        toastr.warning(mensaje, 'Advertencia');
                        break;
                    case 'error':
                        toastr.error(mensaje, 'Error');
                        break;
                    default:
                        toastr.info(mensaje, 'Información');
                }
            }
            
            // Event Listeners
            tituloInput.addEventListener('input', actualizarEstadoBoton);
            contenidoInput.addEventListener('input', actualizarEstadoBoton);
            
            // Estado inicial
            medirBlogBtn.disabled = true; // Deshabilitar por defecto
            actualizarEstadoBoton();

            // Función para actualizar el estado del botón durante operaciones
            function actualizarEstadoCarga(estado) {
                console.log('Actualizando estado del botón a:', estado);
                switch(estado) {
                    case 'cargando':
                        medirBlogBtn.disabled = true;
                        medirBlogBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Analizando...';
                        medirBlogBtn.classList.add('disabled');
                        break;
                    case 'listo':
                        actualizarEstadoBoton(); // Vuelve a verificar el estado de validación
                        medirBlogBtn.innerHTML = '<i class="fas fa-ruler me-1"></i>Medir Contenido';
                        break;
                    case 'error':
                        medirBlogBtn.disabled = false;
                        medirBlogBtn.innerHTML = '<i class="fas fa-redo me-1"></i>Reintentar';
                        medirBlogBtn.classList.remove('disabled');
                        break;
                }
                console.log('Estado del botón actualizado');
            }

            // Función para actualizar el estado del botón
            function actualizarEstadoBoton(estado) {
                switch(estado) {
                    case 'cargando':
                        medirBlogBtn.disabled = true;
                        medirBlogBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Analizando...';
                        break;
                    case 'error':
                        medirBlogBtn.disabled = false;
                        medirBlogBtn.innerHTML = '<i class="fas fa-redo me-1"></i> Reintentar';
                        break;
                    default: // 'listo'
                        medirBlogBtn.disabled = false;
                        medirBlogBtn.innerHTML = '<i class="fas fa-search me-1"></i> Medir Contenido';
                }
            }

            // Manejador del botón Medir Contenido
            medirBlogBtn.addEventListener('click', async function() {
                // Si el botón ya está deshabilitado, no hacer nada
                if (medirBlogBtn.disabled) {
                    console.log('El botón ya está en proceso, espere...');
                    return;
                }

                console.log('=== Inicio del evento click ===');
                const titulo = tituloInput.value.trim();
                const contenido = contenidoInput.value.trim();
                
                console.log('Validando campos:', { titulo, contenido });
                
                if (titulo.length < 4 || contenido.length < 4) {
                    const errorMsg = 'El título y el contenido deben tener al menos 4 caracteres';
                    console.error(errorMsg);
                    mostrarAlerta(errorMsg, 'warning');
                    return;
                }
                
                console.log('Iniciando medición de contenido...');

                // Iniciar carga
                actualizarEstadoBoton('cargando');
                
                // Mostrar el contenedor de resultados y el estado de carga
                const medicionResultado = document.getElementById('medicionResultado');
                const loadingState = document.getElementById('loadingState');
                const resultadoContenido = document.getElementById('resultadoContenido');
                
                // Mostrar el contenedor principal
                medicionResultado.classList.remove('d-none');
                // Mostrar estado de carga
                loadingState.classList.remove('d-none');
                // Ocultar resultados anteriores
                resultadoContenido.classList.add('d-none');
                
                // Desplazarse al área de resultados
                setTimeout(() => {
                    medicionResultado.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
                
                try {
                    const url = '{{ route("blogs.medir") }}';
                    console.log('Enviando solicitud a:', url);
                    
                    // Crear FormData para enviar los datos
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('titulo', titulo);
                    formData.append('contenido', contenido);
                    
                    console.log('Datos del formulario:', {
                        titulo: titulo.substring(0, 50) + (titulo.length > 50 ? '...' : ''),
                        contenido_length: contenido.length
                    });
                    
                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        credentials: 'same-origin',
                        body: formData
                    });

                    console.log('Respuesta HTTP recibida. Estado:', response.status);
                    
                    let data;
                    try {
                        data = await response.json();
                        console.log('Datos de respuesta:', data);
                    } catch (e) {
                        console.error('Error al analizar la respuesta JSON:', e);
                        throw new Error('La respuesta del servidor no es un JSON válido');
                    }

                    if (response.ok) {
                    // Ocultar el estado de carga
                    document.getElementById('loadingState').classList.add('d-none');
                    document.getElementById('progressContainer').classList.add('d-none');
                    
                    // Mostrar el contenedor de resultados
                    const resultadoContenido = document.getElementById('resultadoContenido');
                    const medicionResultado = document.getElementById('medicionResultado');
                    
                    // Determinar la clase de alerta según el puntaje
                    let alertClass = 'alert-success';
                    if (data.puntuacion < 50) {
                        alertClass = 'alert-danger';
                    } else if (data.puntuacion < 80) {
                        alertClass = 'alert-warning';
                    }
                    
                    // Actualizar la interfaz con los resultados
                    resultadoContenido.innerHTML = `
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-chart-pie me-2"></i>Resultado del Análisis
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="alert ${alertClass} mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas ${alertClass === 'alert-success' ? 'fa-check-circle' : alertClass === 'alert-warning' ? 'fa-exclamation-triangle' : 'fa-times-circle'} me-3"></i>
                                        <div>
                                            <h5 class="alert-heading">${data.message || 'Análisis completado'}</h5>
                                            ${data.recomendacion ? `<p class="mb-0">${data.recomendacion}</p>` : ''}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-center py-4">
                                    <div class="position-relative d-inline-block mb-3">
                                        <div class="position-relative" style="width: 180px; height: 180px;">
                                            <svg class="progress-ring" width="180" height="180">
                                                <circle class="progress-ring-circle" 
                                                    stroke="#e9ecef" 
                                                    stroke-width="10" 
                                                    fill="transparent" 
                                                    r="80" 
                                                    cx="90" 
                                                    cy="90" />
                                                <circle class="progress-ring-circle" 
                                                    stroke="${alertClass === 'alert-success' ? '#28a745' : alertClass === 'alert-warning' ? '#ffc107' : '#dc3545'}" 
                                                    stroke-width="10" 
                                                    stroke-linecap="round"
                                                    fill="transparent" 
                                                    r="80" 
                                                    cx="90" 
                                                    cy="90"
                                                    style="stroke-dasharray: 502.65; stroke-dashoffset: ${502.65 - (data.puntuacion / 100 * 502.65)};" />
                                            </svg>
                                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                                <h1 class="display-4 fw-bold mb-0">${data.puntuacion}%</h1>
                                                <small class="text-muted">Puntuación</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <h5>Detalles del Análisis</h5>
                                        <div class="row mt-3">
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100 border-0 shadow-sm">
                                                    <div class="card-body text-center">
                                                        <div class="bg-${alertClass === 'alert-success' ? 'success' : alertClass === 'alert-warning' ? 'warning' : 'danger'}-subtle rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                                            <i class="fas ${alertClass === 'alert-success' ? 'fa-check' : alertClass === 'alert-warning' ? 'fa-exclamation' : 'fa-times'} text-${alertClass === 'alert-success' ? 'success' : alertClass === 'alert-warning' ? 'warning' : 'danger'} fa-2x"></i>
                                                        </div>
                                                        <h6 class="mb-1">Calificación</h6>
                                                        <p class="mb-0 text-${alertClass === 'alert-success' ? 'success' : alertClass === 'alert-warning' ? 'warning' : 'danger'} fw-bold">
                                                            ${data.puntuacion < 50 ? 'Baja' : data.puntuacion < 80 ? 'Media' : 'Alta'}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100 border-0 shadow-sm">
                                                    <div class="card-body text-center">
                                                        <div class="bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                                            <i class="fas fa-info-circle text-primary fa-2x"></i>
                                                        </div>
                                                        <h6 class="mb-1">Recomendación</h6>
                                                        <p class="mb-0 small">
                                                            ${data.puntuacion < 50 ? 'Se recomienda revisar y mejorar el contenido' : data.puntuacion < 80 ? 'El contenido es aceptable, pero puede mejorarse' : '¡Excelente contenido!'}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Mostrar los resultados
                    resultadoContenido.classList.remove('d-none');
                    medicionResultado.classList.remove('d-none');
                    
                    // Desplazarse suavemente a los resultados
                    setTimeout(() => {
                        medicionResultado.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 300);
                    
                    // Mostrar alerta de éxito
                    mostrarAlerta('Análisis completado correctamente', 'success');
                    
                } else {
                    throw new Error(data.message || 'Error en la solicitud');
                }
                } catch (error) {
                    console.error('Error:', error);
                    
                    // Ocultar estado de carga
                    document.getElementById('loadingState').classList.add('d-none');
                    
                    // Mostrar mensaje de error en el contenedor
                    const errorMessage = error.message || 'Ocurrió un error al analizar el contenido';
                    const resultadoContenido = document.getElementById('resultadoContenido');
                    
                    resultadoContenido.innerHTML = `
                        <div class="alert alert-danger">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-3"></i>
                                <div>
                                    <h5 class="alert-heading">Error en el análisis</h5>
                                    <p class="mb-0">${errorMessage}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn btn-outline-primary" onclick="document.getElementById('medirBlogBtn').click()">
                                <i class="fas fa-redo me-2"></i>Intentar de nuevo
                            </button>
                        </div>
                    `;
                    
                    resultadoContenido.classList.remove('d-none');
                    actualizarEstadoBoton('error');
                    
                    // Mostrar alerta de error
                    mostrarAlerta(errorMessage, 'error');
                } finally {
                    // Asegurarse de que el botón no quede atascado
                    if (medirBlogBtn.disabled) {
                        actualizarEstadoBoton('listo');
                    }
                }
            });

            // Image preview functionality
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
    });

    // AI Analysis Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const analyzeButton = document.getElementById('medirContenido');
        const gaugeFill = document.querySelector('.gauge-fill');
        const gaugeValue = document.querySelector('.gauge-value');
        const gaugeLabel = document.querySelector('.gauge-label');
        const analysisResults = document.querySelector('.analysis-results');
        const recommendationsList = document.getElementById('recommendations-list');
        
        // Sample metrics data
        const metrics = {
            length: { value: 'Óptima', icon: 'fas fa-ruler-horizontal', color: 'bg-primary' },
            relevance: { value: 'Alta', icon: 'fas fa-bullseye', color: 'bg-success' },
            structure: { value: 'Buena', icon: 'fas fa-layer-group', color: 'bg-info' },
            seo: { value: 'Mejorable', icon: 'fas fa-search', color: 'bg-warning' }
        };
        
        // Sample recommendations based on content analysis
        const recommendations = [
            'Incluye más palabras clave relacionadas en el contenido',
            'Añade más subtítulos para mejorar la legibilidad',
            'Considera incluir más imágenes o videos',
            'El título podría ser más atractivo para los lectores'
        ];

        analyzeButton.addEventListener('click', function() {
            if (analyzeButton.classList.contains('analyzing')) return;
            
            // Reset state
            analyzeButton.classList.add('analyzing');
            analyzeButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Analizando...';
            analysisResults.style.display = 'none';
            
            // Reset gauge
            gaugeFill.style.transform = 'rotate(0.5turn)';
            gaugeValue.textContent = '0';
            gaugeLabel.textContent = 'Iniciando análisis...';
            
            // Simulate analysis
            let progress = 0;
            const interval = setInterval(() => {
                progress += 1;
                const rotation = 0.5 + (progress * 0.5 / 100); // 0.5 to 1.0 rotation
                
                // Update gauge
                gaugeFill.style.transform = `rotate(${rotation}turn)`;
                gaugeValue.textContent = `${progress}`;
                
                // Update button text during analysis
                if (progress < 30) {
                    gaugeLabel.textContent = 'Analizando texto...';
                } else if (progress < 70) {
                    gaugeLabel.textContent = 'Evaluando estructura...';
                } else if (progress < 100) {
                    gaugeLabel.textContent = 'Generando recomendaciones...';
                }
                
                if (progress === 100) {
                    clearInterval(interval);
                    completeAnalysis();
                }
            }, 30);
            
            // Show loading state for metrics
            document.querySelectorAll('.metric-value').forEach(el => {
                el.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            });
        });
        
        function completeAnalysis() {
            // Update gauge final state
            gaugeLabel.textContent = 'Análisis completo';
            
            // Update metrics
            updateMetrics();
            
            // Update recommendations
            updateRecommendations();
            
            // Update button state
            analyzeButton.innerHTML = '<i class="fas fa-redo me-2"></i>Volver a analizar';
            analyzeButton.classList.remove('analyzing');
            
            // Show results with animation
            analysisResults.style.display = 'block';
            analysisResults.style.opacity = '0';
            analysisResults.style.transform = 'translateY(20px)';
            analysisResults.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            
            // Trigger reflow
            void analysisResults.offsetWidth;
            
            // Animate in
            analysisResults.style.opacity = '1';
            analysisResults.style.transform = 'translateY(0)';
            
            // Smooth scroll to results
            setTimeout(() => {
                analysisResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 500);
        }
        
        function updateMetrics() {
            const metricElements = document.querySelectorAll('.metric-item');
            metricElements.forEach((el, index) => {
                const metricKey = Object.keys(metrics)[index];
                const metric = metrics[metricKey];
                
                setTimeout(() => {
                    const iconDiv = el.querySelector('.metric-icon');
                    iconDiv.className = `metric-icon ${metric.color} text-white`;
                    iconDiv.innerHTML = `<i class="${metric.icon}"></i>`;
                    
                    el.querySelector('.metric-value').textContent = metric.value;
                    
                    // Add animation
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(10px)';
                    el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    
                    setTimeout(() => {
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, 50);
                }, 100 * index);
            });
        }
        
        function updateRecommendations() {
            recommendationsList.innerHTML = '';
            
            recommendations.forEach((rec, index) => {
                const li = document.createElement('li');
                li.className = 'd-flex align-items-center mb-2';
                li.innerHTML = `
                    <i class="fas fa-check-circle text-success me-2"></i>
                    <span>${rec}</span>
                `;
                li.style.opacity = '0';
                li.style.transform = 'translateX(-10px)';
                li.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                
                // Staggered animation
                setTimeout(() => {
                    li.style.opacity = '1';
                    li.style.transform = 'translateX(0)';
                }, 100 * index);
                
                recommendationsList.appendChild(li);
            });
        }
    });
</script>
@endpush
@endsection