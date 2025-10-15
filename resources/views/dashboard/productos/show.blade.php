@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalles del Producto</h1>
        <div>
            <a href="{{ route('dashboard.productos') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fas fa-box text-primary me-2"></i>
                    <h5 class="mb-0">Información del Producto</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h2 class="h3 fw-bold text-primary">{{ $producto->titulo }}</h2>
                        <span class="badge bg-{{ $producto->categoria == 'Medicamentos' ? 'primary' : ($producto->categoria == 'Vitaminas' ? 'success' : ($producto->categoria == 'Cuidado Personal' ? 'info' : ($producto->categoria == 'Primeros Auxilios' ? 'danger' : 'warning'))) }} mb-3 px-3 py-2">{{ $producto->categoria }}</span>
                        <p class="text-muted"><i class="far fa-calendar-alt me-1"></i> Creado el {{ $producto->created_at->format('d/m/Y') }} | <i class="far fa-clock me-1"></i> Última actualización: {{ $producto->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold"><i class="fas fa-align-left text-secondary me-2"></i>Descripción</h5>
                        <p class="mb-0 p-3 bg-light rounded">{{ $producto->descripcion }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Trabajador que creó el producto:</label>
                        <div>{{ $producto->trabajador ? $producto->trabajador->nombre_completo : 'Desconocido' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fas fa-cogs text-secondary me-2"></i>
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-success">
                            <i class="fas fa-edit"></i> Editar Producto
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Eliminar Producto
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex align-items-center">
                    <i class="fas fa-image text-info me-2"></i>
                    <h5 class="mb-0">Imagen del Producto</h5>
                </div>
                <div class="card-body text-center p-4">
                    @if($producto->imagen)
                        <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->titulo }}" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                        <p class="mt-3 text-muted small">Imagen de referencia del producto</p>
                    @else
                        <div class="py-5 bg-light rounded d-flex flex-column align-items-center justify-content-center border">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No hay imagen disponible</p>
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
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->titulo }}</strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('productos.destroy', $producto) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection