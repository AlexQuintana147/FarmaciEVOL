@extends('layouts.app')

@section('content')
<div class="container py-4">
    <style>
        /* Estilos personalizados para mejorar la vista de blogs */
        .table td {
            vertical-align: middle;
        }
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
        .btn-group .btn-sm {
            padding: 0.25rem 0.5rem;
        }
        .dropdown-menu {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .blogs-header {
            background: linear-gradient(135deg, #4a89dc, #37bc9b);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .floating-icon {
            position: absolute;
            opacity: 0.1;
            font-size: 3rem;
            color: #fff;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        .search-box {
            border-radius: 30px;
            padding-left: 20px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .search-btn {
            border-radius: 0 30px 30px 0;
            padding-left: 20px;
            padding-right: 20px;
        }
        .blog-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }
        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }
        .action-btn:hover {
            transform: scale(1.1);
        }
        .blog-author {
            display: inline-flex;
            align-items: center;
            background-color: rgba(74, 137, 220, 0.1);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .category-badge {
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Header de Blogs con estilo médico -->
    <div class="blogs-header text-white mb-4">
        <!-- Iconos flotantes decorativos -->
        <div class="floating-icon" style="top: 10%; right: 10%;"><i class="fas fa-book-medical"></i></div>
        <div class="floating-icon" style="bottom: 10%; left: 15%;"><i class="fas fa-notes-medical"></i></div>
        
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2">Gestión de Blogs</h1>
                <p class="mb-0 opacity-75">Administra los artículos y consejos de salud de DrodiPharma.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('blogs.create') }}" class="btn btn-light text-primary fw-bold rounded-pill">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Blog
                </a>
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <form action="" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-box" placeholder="Buscar blogs..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="{{ route('blogs.export', request()->query()) }}" class="btn btn-success rounded-pill">
                        <i class="fas fa-file-excel me-2"></i>Exportar a Excel
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Blog</th>
                            <th>Autor</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td class="ps-4">{{ $blog->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($blog->imagen)
                                            <div class="rounded-circle overflow-hidden me-3 shadow-sm" style="width: 50px; height: 50px;">
                                                <img src="{{ asset($blog->imagen) }}" alt="{{ $blog->titulo }}" class="w-100 h-100" style="object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                                                <i class="fas fa-book-medical text-primary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 fw-bold text-primary">{{ $blog->titulo }}</h6>
                                            <small class="text-muted">{{ Str::limit($blog->subtitulo, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $blog->trabajador->nombre_completo }}</td>
                                <td><i class="far fa-calendar-alt me-1 text-muted"></i>{{ $blog->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('blogs.show', $blog) }}" class="btn btn-outline-primary action-btn" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('blogs.edit', $blog) }}" class="btn btn-outline-success action-btn" title="Editar blog">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger action-btn" title="Eliminar blog" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blog->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade" id="deleteModal{{ $blog->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $blog->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $blog->id }}"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="text-center mb-4">
                                                        <div class="avatar-lg mx-auto mb-3">
                                                            <div class="avatar-title bg-light text-danger rounded-circle">
                                                                <i class="fas fa-trash-alt fa-2x"></i>
                                                            </div>
                                                        </div>
                                                        <h5 class="mb-3">¿Eliminar este blog?</h5>
                                                        <p class="text-muted mb-0">¿Estás seguro de que deseas eliminar el blog <strong>{{ $blog->titulo }}</strong>?</p>
                                                        <p class="text-danger small">Esta acción no se puede deshacer.</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('blogs.destroy', $blog) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                                                            <i class="fas fa-trash-alt me-2"></i>Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center bg-light rounded-3 py-5 px-4">
                                        <div class="avatar-lg mb-3">
                                            <div class="avatar-title bg-white text-primary rounded-circle shadow-sm" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-book-medical fa-3x"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-primary mb-2">No hay blogs disponibles</h4>
                                        <p class="text-muted mb-4">Aún no se han creado blogs en el sistema</p>
                                        <a href="{{ route('blogs.create') }}" class="btn btn-primary rounded-pill px-4">
                                            <i class="fas fa-plus-circle me-2"></i>Crear nuevo blog
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3 d-flex justify-content-between align-items-center">
            <div class="text-muted small">Total de registros: {{ count($blogs) }}</div>
        </div>
    </div>
</div>
@endsection