@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('autogenerador.logs') }}">Autogenerador</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle #{{ $log->id }}</li>
                </ol>
            </nav>
            <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-6 mb-0"><i class="fas fa-magic me-3"></i>Detalle de Autogeneración</h1>
                            <p class="mb-0 mt-2 opacity-75">Información detallada de la descripción generada</p>
                        </div>
                        <a href="{{ route('autogenerador.logs') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0 rounded-4 h-100">
                <div class="card-header bg-white py-4 border-bottom">
                    <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-info-circle me-2"></i>Información General</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar-lg bg-primary-subtle text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Generado por</h6>
                            <h5 class="mb-0 fw-bold">{{ $log->trabajador?->usuario ?? 'N/A' }}</h5>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-sm bg-success-subtle text-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Fecha de Creación</h6>
                                <p class="mb-0">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm bg-info-subtle text-info rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Última Actualización</h6>
                                <p class="mb-0">{{ $log->updated_at->format('d/m/Y H:i:s') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('productos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Crear Nuevo Producto
                        </a>
                        <a href="{{ route('autogenerador.logs') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8 mb-4">
            <div class="card shadow-lg border-0 rounded-4 h-100">
                <div class="card-header bg-white py-4 border-bottom">
                    <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-file-alt me-2"></i>Contenido Generado</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Título del Producto</h6>
                        <div class="p-3 bg-light rounded-3 border">
                            <p class="mb-0 fw-bold">{{ $log->titulo }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <h6 class="fw-bold mb-3">Descripción Generada</h6>
                        <div class="p-4 bg-light rounded-3 border" style="min-height: 200px;">
                            <p class="mb-0" style="white-space: pre-line;">{{ $log->descripcion }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection