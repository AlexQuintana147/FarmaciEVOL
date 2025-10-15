@extends('layouts.app')

@php
    use App\Models\ChatbotLog;
    use Carbon\Carbon;
@endphp

@section('title', 'Métricas del Chatbot')

@section('content')
<style>
    /* Efecto de escala al pasar el ratón */
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
    
    /* Colores personalizados */
    .bg-gradient-purple {
        background: linear-gradient(45deg, #6f42c1, #9c27b0);
    }
    .text-purple {
        color: #6f42c1 !important;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4361ee, #3a0ca3);
    }
    .bg-gradient-info {
        background: linear-gradient(45deg, #0096c7, #00b4d8);
    }
    .bg-gradient-success {
        background: linear-gradient(45deg, #2e7d32, #4caf50);
    }
    .bg-gradient-warning {
        background: linear-gradient(45deg, #f8961e, #f9c74f);
    }
    
    /* Mejoras en las tarjetas */
    .card {
        border: none;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    .card-title {
        font-size: 1.1rem;
        letter-spacing: 0.5px;
    }
    
    .card-subtitle {
        font-size: 0.85rem;
        letter-spacing: 0.3px;
    }
    
    .display-4 {
        font-weight: 700;
        letter-spacing: -1px;
    }
    
    /* Mejoras en la tabla */
    .table th {
        border-top: none;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    /* Mejoras en los badges */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
    
    /* Mejoras en la paginación */
    .pagination .page-link {
        border: none;
        margin: 0 3px;
        border-radius: 50% !important;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #495057;
        font-weight: 500;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #4361ee;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
    }
    /* Ajustes para las columnas personalizadas */
    @media (min-width: 1200px) {
        .col-xl-2_4 {
            flex: 0 0 auto;
            width: 20%;
        }
    }
    
    /* Ajustes para las tarjetas en móviles */
    @media (max-width: 767.98px) {
        .card {
            margin-bottom: 1rem;
        }
        .display-4 {
            font-size: 1.8rem;
        }
    }
    
    /* Asegurar que las tarjetas tengan la misma altura */
    .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-body > div:last-child {
        margin-top: auto;
    }
</style>
<div class="container-fluid py-5 bg-light min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-5">
                <div class="bg-white p-4 rounded-4 shadow-sm border-0 d-inline-block">
                    <h2 class="text-primary fw-bold mb-2">
                        <i class="fas fa-chart-bar me-3 fs-1"></i>
                        Panel de Métricas
                    </h2>
                    <p class="text-muted fs-5 mb-0">Resumen completo de actividad del chatbot</p>
                </div>
            </div>

            <div class="col-12">
                <div class="row g-3">
                    <div class="col-xl-2_4 col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-primary text-white h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative hover-scale">
                    <div class="position-absolute top-0 end-0 p-3" style="opacity: 0.1;">
                        <i class="fas fa-comments" style="font-size: 5rem;"></i>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-comments fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">Total de Interacciones</h5>
                                <h6 class="card-subtitle mb-0" style="opacity: 0.8;">Historial completo</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <h1 class="display-4 fw-bold mb-0">{{ number_format($totalInteracciones ?? 0) }}</h1>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-white text-primary p-2">{{ $interaccionesHoy ?? 0 }} hoy</span>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Tarjeta de Interacciones Hoy -->
                    <div class="col-xl-2_4 col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-info text-white h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative hover-scale">
                    <div class="position-absolute top-0 end-0 p-3" style="opacity: 0.1;">
                        <i class="fas fa-calendar-day" style="font-size: 5rem;"></i>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-calendar-day fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">Interacciones Hoy</h5>
                                <h6 class="card-subtitle mb-0" style="opacity: 0.8;">{{ now()->format('d M, Y') }}</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <h1 class="display-4 fw-bold mb-0">{{ $interaccionesHoy ?? 0 }}</h1>
                            </div>
                            @php
                                $porcentajeHoy = $totalInteracciones > 0 ? round(($interaccionesHoy / $totalInteracciones) * 100) : 0;
                            @endphp
                            <div class="text-end">
                                <span class="badge bg-white text-info p-2">{{ $porcentajeHoy }}% del total</span>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: {{ min($porcentajeHoy, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Tarjeta de Preguntas Únicas -->
                    <div class="col-xl-2_4 col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-purple text-white h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative hover-scale">
                    <div class="position-absolute top-0 end-0 p-3" style="opacity: 0.1;">
                        <i class="fas fa-question-circle" style="font-size: 5rem;"></i>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-question-circle fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">Preguntas Únicas</h5>
                                <h6 class="card-subtitle mb-0" style="opacity: 0.8;">Diferentes preguntas</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <h1 class="display-4 fw-bold mb-0">{{ $preguntasUnicas ?? 0 }}</h1>
                            </div>
                            @php
                                $porcentajeUnicas = $totalInteracciones > 0 ? round(($preguntasUnicas / $totalInteracciones) * 100) : 0;
                            @endphp
                            <div class="text-end">
                                <span class="badge bg-white text-purple p-2">{{ $porcentajeUnicas }}% de repetición</span>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: {{ $porcentajeUnicas }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Tarjeta de Usuarios Autenticados -->
                    <div class="col-xl-2_4 col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-success text-white h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative hover-scale">
                    <div class="position-absolute top-0 end-0 p-3" style="opacity: 0.1;">
                        <i class="fas fa-user-shield" style="font-size: 5rem;"></i>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-shield fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">Usuarios Autenticados</h5>
                                <h6 class="card-subtitle mb-0" style="opacity: 0.8;">Personal autorizado</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <h1 class="display-4 fw-bold mb-0">{{ number_format($interaccionesAutenticadas ?? 0) }}</h1>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-white text-success p-2">{{ $porcentajeAutenticados ?? 0 }}% del total</span>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: {{ $porcentajeAutenticados ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

                    <!-- Tarjeta de Usuarios No Autenticados -->
                    <div class="col-xl-2_4 col-lg-4 col-md-6 mb-4">
                <div class="card bg-gradient-warning text-white h-100 shadow-lg border-0 rounded-4 overflow-hidden position-relative hover-scale">
                    <div class="position-absolute top-0 end-0 p-3" style="opacity: 0.1;">
                        <i class="fas fa-user" style="font-size: 5rem;"></i>
                    </div>
                    <div class="card-body p-4 position-relative">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-lg"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title fw-bold mb-1">Usuarios Invitados</h5>
                                <h6 class="card-subtitle mb-0" style="opacity: 0.8;">Acceso público</h6>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <h1 class="display-4 fw-bold mb-0">{{ number_format($interaccionesNoAutenticadas ?? 0) }}</h1>
                            </div>
                            <div class="text-end">
                                @php
                                    $porcentajeNoAutenticados = 100 - ($porcentajeAutenticados ?? 0);
                                @endphp
                                <span class="badge bg-white text-warning p-2">{{ $porcentajeNoAutenticados }}% del total</span>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background-color: rgba(255,255,255,0.2);">
                            <div class="progress-bar bg-white" style="width: {{ $porcentajeNoAutenticados }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de logs -->
            <div class="col-12 mt-4">
                <div class="card shadow-sm rounded-4 border-0 overflow-hidden">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="card-title mb-0 d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                        <i class="fas fa-history text-primary fa-lg"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark">Historial de Interacciones</span>
                                        <small class="d-block text-muted">Registro detallado de conversaciones</small>
                                    </div>
                                </h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        @if(isset($chatbotLogs) && count($chatbotLogs) > 0)
                        <div class="table-responsive">
                            <div class="d-flex justify-content-between align-items-center px-4 py-3 bg-primary bg-opacity-5 border-bottom border-primary border-opacity-10">
                                <h6 class="mb-0 text-primary fw-semibold">
                                    <i class="fas fa-list-ul me-2"></i>
                                    Mostrando {{ $chatbotLogs->firstItem() }} - {{ $chatbotLogs->lastItem() }} de {{ $chatbotLogs->total() }} registros
                                </h6>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('chatbot.metrics.export', request()->query()) }}" class="btn btn-success btn-sm d-flex align-items-center">
                                        <i class="fas fa-file-excel me-2"></i> Exportar a Excel
                                    </a>
                                </div>
                            </div>
                            
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-4 fw-bold text-dark border-0">
                                            <i class="fas fa-user me-2 text-primary"></i>Usuario / Tipo
                                        </th>
                                        <th class="px-4 py-4 fw-bold text-dark border-0">
                                            <i class="fas fa-question me-2 text-success"></i>Pregunta
                                        </th>
                                        <th class="px-4 py-4 fw-bold text-dark border-0">
                                            <i class="fas fa-reply me-2 text-info"></i>Respuesta
                                        </th>
                                        <th class="px-4 py-4 fw-bold text-dark border-0">
                                            <i class="fas fa-clock me-2 text-warning"></i>Fecha
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($chatbotLogs as $log)
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-{{ $log->es_autenticado ? 'primary' : 'secondary' }} bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-user-{{ $log->es_autenticado ? 'shield' : 'alt' }} text-{{ $log->es_autenticado ? 'primary' : 'secondary' }}"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-semibold text-dark d-block">
                                                        @if($log->trabajador)
                                                            {{ $log->trabajador->nombre }}
                                                        @else
                                                            {{ $log->es_autenticado ? 'Usuario' : 'Visitante' }}
                                                        @endif
                                                    </span>
                                                    <small class="text-{{ $log->es_autenticado ? 'primary' : 'secondary' }} fw-bold">
                                                        @if($log->trabajador)
                                                            Trabajador
                                                        @else
                                                            {{ $log->es_autenticado ? 'Usuario Autenticado' : 'No Autenticado' }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="bg-success bg-opacity-10 p-3 rounded-3 border border-success border-opacity-20">
                                                <span class="text-dark fw-medium">{{ $log->pregunta }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="flex-grow-1">
                                                    <div class="bg-light p-3 rounded-3 border">
                                                        <p class="mb-0 text-muted" style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                            {{ substr($log->respuesta, 0, 100) }}
                                                            @if(strlen($log->respuesta) > 100)...@endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <button type="button" 
                                                    class="btn btn-outline-primary btn-sm rounded-pill px-3" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#respuestaModal{{ $log->id }}">
                                                    <i class="fas fa-expand-alt me-2"></i>Ver completa
                                                </button>
                                            </div>

                                            <!-- Modal para la respuesta completa -->
                                            <div class="modal fade" id="respuestaModal{{ $log->id }}" tabindex="-1" aria-labelledby="respuestaModalLabel{{ $log->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                                        <div class="modal-header bg-primary bg-opacity-10 border-0 rounded-top-4">
                                                            <h5 class="modal-title fw-bold text-primary" id="respuestaModalLabel{{ $log->id }}">
                                                                <i class="fas fa-comment-dots me-2"></i>
                                                                Respuesta Completa
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <div class="bg-light p-4 rounded-3 border">
                                                                <p class="mb-0 text-dark lh-lg">{{ $log->respuesta }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 bg-light rounded-bottom-4">
                                                            <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal">
                                                                <i class="fas fa-check me-2"></i>Cerrar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                    <i class="fas fa-calendar-alt text-warning"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-semibold text-dark d-block">
                                                        {{ $log->created_at->format('d/m/Y') }}
                                                    </span>
                                                    <small class="text-muted">
                                                        {{ $log->created_at->format('H:i:s') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="px-4 py-4 bg-light border-top">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Total de {{ $chatbotLogs->total() }} interacciones registradas
                                </div>
                                <div>
                                    {{ $chatbotLogs->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 120px; height: 120px;">
                                <i class="fas fa-robot fa-4x text-muted opacity-50"></i>
                            </div>
                            <h4 class="text-muted fw-bold mb-3">No hay registros disponibles</h4>
                            <p class="text-muted fs-5 mb-4">Las interacciones con el chatbot aparecerán aquí</p>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 d-inline-block">
                                <small class="text-primary fw-semibold">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    Los registros se actualizan automáticamente
                                </small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection