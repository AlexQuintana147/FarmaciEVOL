@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="bg-gradient-primary-to-secondary p-3 rounded-3 mb-4 shadow-sm" style="background: linear-gradient(135deg, #ff6b6b, #ff8e53);">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="text-white mb-0"><i class="fas fa-tag me-2"></i>Detalles de la Oferta</h1>
            <a href="{{ route('dashboard.ofertas') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow border-0 rounded-3 overflow-hidden mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-danger"><i class="fas fa-info-circle me-2"></i>Información de la Oferta</h5>
                </div>
                <div class="card-body p-4">
                    <h2 class="h3 mb-4 pb-2 border-bottom">{{ $oferta->titulo }}</h2>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong><i class="fas fa-calendar-alt text-danger me-2"></i>Creado:</strong></p>
                            <p class="text-muted">{{ $oferta->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong><i class="fas fa-calendar-check text-danger me-2"></i>Última actualización:</strong></p>
                            <p class="text-muted">{{ $oferta->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="mb-1"><strong><i class="fas fa-user-tie text-danger me-2"></i>Creado por:</strong></p>
                        <p class="text-muted">{{ $oferta->trabajador->nombre ?? 'No asignado' }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('ofertas.edit', $oferta->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash-alt me-2"></i>Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow border-0 rounded-3 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-danger"><i class="fas fa-image me-2"></i>Imagen de la Oferta</h5>
                </div>
                <div class="card-body p-4 text-center">
                    @if($oferta->imagen)
                        <img src="{{ asset($oferta->imagen) }}" alt="{{ $oferta->titulo }}" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                    @else
                        <div class="p-5 bg-light rounded">
                            <i class="fas fa-image fa-4x text-muted opacity-50"></i>
                            <p class="mt-3 text-muted">No hay imagen disponible</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar esta oferta? Esta acción no se puede deshacer.</p>
                <p class="fw-bold">{{ $oferta->titulo }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection