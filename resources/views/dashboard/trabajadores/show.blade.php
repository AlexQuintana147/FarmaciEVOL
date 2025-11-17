@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('trabajadores.index') }}" class="text-decoration-none">Trabajadores</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $trabajador->nombre_completo }}</li>
                </ol>
            </nav>
            
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom border-light">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-1 text-primary">{{ $trabajador->nombre_completo }} {{ $trabajador->apellidos }}</h4>
                            <p class="text-muted mb-0"><i class="fas fa-id-badge me-2"></i>{{ $trabajador->usuario }}</p>
                        </div>
                        <div class="d-flex mt-3 mt-md-0">
                            <a href="{{ route('trabajadores.index') }}" class="btn btn-outline-secondary rounded-pill me-2">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                            @if(Auth::guard('trabajador')->user()->usuario === 'admin')
                                <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-warning rounded-pill text-white me-2">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                @if($trabajador->usuario !== 'admin')
                                    <button type="button" class="btn btn-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fas fa-trash me-2"></i>Eliminar
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="p-4 bg-light rounded-3 h-100">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-user-circle me-2 text-primary"></i>Información Personal</h5>
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">ID</p>
                                    <p class="fw-bold mb-0">{{ $trabajador->id }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">Usuario</p>
                                    <p class="fw-bold mb-0">{{ $trabajador->usuario }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">Nombre Completo</p>
                                    <p class="fw-bold mb-0">{{ $trabajador->nombre_completo }}</p>
                                </div>
                                <div class="mb-0">
                                    <p class="text-muted small mb-1">Apellidos</p>
                                    <p class="fw-bold mb-0">{{ $trabajador->apellidos }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="p-4 bg-light rounded-3 h-100">
                                <h5 class="border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2 text-primary"></i>Información Adicional</h5>
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">DNI</p>
                                    <p class="fw-bold mb-0">{{ $trabajador->dni }}</p>
                                </div>
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">Fecha de Registro</p>
                                    <p class="fw-bold mb-0"><i class="far fa-calendar-alt me-2 text-secondary"></i>{{ $trabajador->created_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                                <div class="mb-0">
                                    <p class="text-muted small mb-1">Última Actualización</p>
                                    <p class="fw-bold mb-0"><i class="far fa-clock me-2 text-secondary"></i>{{ $trabajador->updated_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación para eliminar -->
@if(Auth::guard('trabajador')->user()->usuario === 'admin' && $trabajador->usuario !== 'admin')
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center fs-5">¿Está seguro que desea eliminar al trabajador?</p>
                <div class="alert alert-secondary">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user me-3 text-primary" style="font-size: 1.5rem;"></i>
                        <div>
                            <p class="fw-bold mb-0">{{ $trabajador->nombre_completo }}</p>
                            <p class="text-muted mb-0">{{ $trabajador->usuario }} - {{ $trabajador->dni }}</p>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Advertencia:</strong> Esta acción no se puede deshacer y eliminará permanentemente todos los datos asociados a este trabajador.
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form action="{{ route('trabajadores.destroy', $trabajador) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill">
                        <i class="fas fa-trash me-2"></i>Eliminar definitivamente
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection