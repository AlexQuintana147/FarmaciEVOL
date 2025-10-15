@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="display-6 mb-0"><i class="fas fa-magic me-3"></i>Registros de Autogeneración</h1>
                            <p class="mb-0 mt-2 opacity-75">Gestiona y visualiza el historial de descripciones autogeneradas</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-history me-2"></i>Historial de Descripciones</h5>
                            <p class="text-muted small mb-0 mt-1">Lista completa de todas las descripciones generadas automáticamente</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('autogenerador.logs.export', request()->query()) }}" class="btn btn-success">
                                <i class="fas fa-file-excel me-2"></i>Exportar a Excel
                            </a>
                            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nuevo Producto
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col" class="ps-4">#</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">Trabajador</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col" class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="ps-4">{{ $log->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-alt text-primary me-2"></i>
                                                <div>
                                                    <h6 class="mb-0">{{ Str::limit($log->titulo, 50) }}</h6>
                                                    <small class="text-muted">ID: #{{ $log->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary-subtle text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                {{ $log->trabajador?->usuario ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-calendar text-muted me-2"></i>
                                                {{ $log->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('autogenerador.logs.show', $log) }}" class="btn btn-primary">
                                                <i class="fas fa-eye me-2"></i>Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="text-primary mb-3" style="font-size: 3rem;">
                                                    <i class="fas fa-clipboard-list"></i>
                                                </div>
                                                <h5 class="text-primary mb-2">No hay registros disponibles</h5>
                                                <p class="text-muted mb-4">Aún no se han generado descripciones automáticas</p>
                                                <a href="{{ route('productos.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Crear Nuevo Producto
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-center">
                        {{ $logs->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection