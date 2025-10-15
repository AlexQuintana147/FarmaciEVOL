@extends('layouts.app')

@section('content')
<div class="container py-4">
    <style>
        /* Estilos personalizados para mejorar la vista de productos */
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
        .productos-header {
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
        .product-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .category-badge {
            border-radius: 20px;
            padding: 5px 12px;
            font-size: 0.75rem;
            font-weight: 600;
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
    </style>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Header de Productos con estilo médico -->
    <div class="productos-header text-white mb-4">
        <!-- Iconos flotantes decorativos -->
        <div class="floating-icon" style="top: 10%; right: 10%;"><i class="fas fa-pills"></i></div>
        <div class="floating-icon" style="bottom: 10%; left: 15%;"><i class="fas fa-capsules"></i></div>
        
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2">Gestión de Productos</h1>
                <p class="mb-0 opacity-75">Administra el catálogo de productos farmacéuticos de DrodiPharma.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('productos.export', request()->query()) }}" class="btn btn-success fw-bold rounded-pill">
                        <i class="fas fa-file-excel me-2"></i>Exportar a Excel
                    </a>
                    <a href="{{ route('productos.create') }}" class="btn btn-light text-primary fw-bold rounded-pill">
                        <i class="fas fa-plus-circle me-2"></i>Nuevo Producto
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <form action="{{ route('dashboard.productos') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-box" placeholder="Buscar productos..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <div class="d-flex align-items-center">
                        <span class="me-2 text-muted"><i class="fas fa-filter me-1"></i>Filtrar por:</span>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle rounded-pill" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-tag me-1"></i> Categoría
                            </button>
                            <ul class="dropdown-menu shadow-sm border-0" aria-labelledby="categoryDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard.productos', ['categoria' => 'Medicamentos']) }}">
                                    <i class="fas fa-pills text-primary me-2"></i>Medicamentos
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.productos', ['categoria' => 'Vitaminas']) }}">
                                    <i class="fas fa-apple-alt text-success me-2"></i>Vitaminas
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.productos', ['categoria' => 'Cuidado Personal']) }}">
                                    <i class="fas fa-pump-soap text-info me-2"></i>Cuidado Personal
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.productos', ['categoria' => 'Primeros Auxilios']) }}">
                                    <i class="fas fa-first-aid text-danger me-2"></i>Primeros Auxilios
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.productos', ['categoria' => 'Suplementos']) }}">
                                    <i class="fas fa-capsules text-warning me-2"></i>Suplementos
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('dashboard.productos') }}">
                                    <i class="fas fa-list-ul text-secondary me-2"></i>Todos los productos
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-nowrap">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Trabajador</th>
                            <th>Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td class="ps-4">{{ $producto->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($producto->imagen)
                                            <div class="rounded-circle overflow-hidden me-3 shadow-sm" style="width: 50px; height: 50px;">
                                                <img src="{{ asset($producto->imagen) }}" alt="{{ $producto->titulo }}" class="w-100 h-100" style="object-fit: cover;">
                                            </div>
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                                                <i class="fas fa-pills text-primary"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0 fw-bold text-primary">{{ $producto->titulo }}</h6>
                                            <small class="text-muted">{{ Str::limit($producto->descripcion, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-badge bg-{{ $producto->categoria == 'Medicamentos' ? 'primary' : ($producto->categoria == 'Vitaminas' ? 'success' : ($producto->categoria == 'Cuidado Personal' ? 'info' : ($producto->categoria == 'Primeros Auxilios' ? 'danger' : 'warning'))) }}">
                                        <i class="fas fa-{{ $producto->categoria == 'Medicamentos' ? 'pills' : ($producto->categoria == 'Vitaminas' ? 'apple-alt' : ($producto->categoria == 'Cuidado Personal' ? 'pump-soap' : ($producto->categoria == 'Primeros Auxilios' ? 'first-aid' : 'capsules'))) }} me-1"></i>
                                        {{ $producto->categoria }}
                                    </span>
                                </td>
                                <td>{{ $producto->trabajador ? $producto->trabajador->nombre_completo : 'Desconocido' }}</td>
                                <td><i class="far fa-calendar-alt me-1 text-muted"></i>{{ $producto->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('productos.show', $producto) }}" class="btn btn-outline-primary action-btn" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-outline-success action-btn" title="Editar producto">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger action-btn" title="Eliminar producto" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $producto->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade" id="deleteModal{{ $producto->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $producto->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $producto->id }}"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="text-center mb-4">
                                                        <div class="avatar-lg mx-auto mb-3">
                                                            <div class="avatar-title bg-light text-danger rounded-circle">
                                                                <i class="fas fa-trash-alt fa-2x"></i>
                                                            </div>
                                                        </div>
                                                        <h5 class="mb-3">¿Eliminar este producto?</h5>
                                                        <p class="text-muted mb-0">¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->titulo }}</strong>?</p>
                                                        <p class="text-danger small">Esta acción no se puede deshacer.</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display: inline;">
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
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center bg-light rounded-3 py-5 px-4">
                                        <div class="avatar-lg mb-3">
                                            <div class="avatar-title bg-white text-primary rounded-circle shadow-sm" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-pills fa-3x"></i>
                                            </div>
                                        </div>
                                        <h4 class="text-primary mb-2">No hay productos disponibles</h4>
                                        <p class="text-muted mb-4">Aún no se han creado productos en el sistema</p>
                                        <a href="{{ route('productos.create') }}" class="btn btn-primary rounded-pill px-4">
                                            <i class="fas fa-plus-circle me-2"></i>Crear nuevo producto
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
            <div class="text-muted small">Total de registros: {{ count($productos) }}</div>
        </div>
    </div>
</div>
@endsection