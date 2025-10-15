@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalles del Blog</h1>
        <div>
            <a href="{{ route('dashboard.blogs') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver a la lista
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Información del Blog</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h2 class="h4 fw-bold">{{ $blog->titulo }}</h2>
                        <p class="text-muted mb-3">{{ $blog->subtitulo }}</p>
                        <p class="text-muted">Autor: {{ $blog->trabajador->nombre_completo }} | Creado el {{ $blog->created_at->format('d/m/Y') }} | Última actualización: {{ $blog->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold">Contenido</h5>
                        <div class="blog-content">
                            {{ $blog->contenido }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Acciones</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-success">
                            <i class="fas fa-edit"></i> Editar Blog
                        </a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Eliminar Blog
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Imagen del Blog</h5>
                </div>
                <div class="card-body text-center">
                    @if($blog->imagen)
                        <img src="{{ asset($blog->imagen) }}" alt="{{ $blog->titulo }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="py-5 bg-light rounded d-flex flex-column align-items-center justify-content-center">
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
                <p>¿Estás seguro de que deseas eliminar el blog <strong>{{ $blog->titulo }}</strong>?</p>
                <p class="text-danger"><i class="fas fa-exclamation-triangle"></i> Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('blogs.destroy', $blog) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection