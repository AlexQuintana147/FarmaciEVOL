@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Trabajadores</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary"><i class="fas fa-users me-2"></i>Gestión de Trabajadores</h2>
            <p class="text-muted">Administre el personal de la farmacia</p>
        </div>
        <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
            @if($isAdmin)
            <a href="{{ route('trabajadores.create') }}" class="btn btn-primary rounded-pill">
                <i class="fas fa-plus-circle me-2"></i>Nuevo Trabajador
            </a>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div>
                <h5 class="alert-heading">¡Operación exitosa!</h5>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
        <div class="d-flex">
            <div class="me-3">
                <i class="fas fa-exclamation-circle fa-2x"></i>
            </div>
            <div>
                <h5 class="alert-heading">¡Error!</h5>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white p-4 border-bottom border-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Lista de Trabajadores</h5>
                </div>
                <div class="col-md-6">
                    <div class="input-group mt-3 mt-md-0">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0" placeholder="Buscar trabajador...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="trabajadoresTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Usuario</th>
                            <th class="py-3 px-4">Nombre Completo</th>
                            <th class="py-3 px-4">Apellidos</th>
                            <th class="py-3 px-4">DNI</th>
                            <th class="py-3 px-4">Fecha Registro</th>
                            <th class="py-3 px-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trabajadores as $trabajador)
                        <tr>
                            <td class="py-3 px-4">{{ $trabajador->id }}</td>
                            <td class="py-3 px-4"><span class="badge bg-light text-dark">{{ $trabajador->usuario }}</span></td>
                            <td class="py-3 px-4 fw-bold">{{ $trabajador->nombre_completo }}</td>
                            <td class="py-3 px-4">{{ $trabajador->apellidos }}</td>
                            <td class="py-3 px-4">{{ $trabajador->dni }}</td>
                            <td class="py-3 px-4"><i class="far fa-calendar-alt me-2 text-muted"></i>{{ $trabajador->created_at->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="btn-group">
                                    <a href="{{ route('trabajadores.show', $trabajador) }}" class="btn btn-sm btn-outline-info rounded-pill me-1" title="Ver detalles">
                                        <i class="fas fa-eye me-1"></i><span class="d-none d-md-inline">Ver</span>
                                    </a>
                                    @if($isAdmin)
                                        <a href="{{ route('trabajadores.edit', $trabajador) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1" title="Editar">
                                            <i class="fas fa-edit me-1"></i><span class="d-none d-md-inline">Editar</span>
                                        </a>
                                        @if($trabajador->usuario !== 'admin')
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" title="Eliminar" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $trabajador->id }}">
                                                <i class="fas fa-trash me-1"></i><span class="d-none d-md-inline">Eliminar</span>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                
                                <!-- Modal de confirmación para eliminar -->
                                @if($isAdmin && $trabajador->usuario !== 'admin')
                                <div class="modal fade" id="deleteModal{{ $trabajador->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $trabajador->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $trabajador->id }}">
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-users-slash text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">No hay trabajadores registrados</h5>
                                    @if($isAdmin)
                                    <a href="{{ route('trabajadores.create') }}" class="btn btn-primary rounded-pill mt-3">
                                        <i class="fas fa-plus-circle me-2"></i>Agregar trabajador
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('trabajadoresTable');
        const rows = table.getElementsByTagName('tr');
        
        searchInput.addEventListener('keyup', function() {
            const searchText = searchInput.value.toLowerCase();
            
            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName('td');
                
                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.indexOf(searchText) > -1) {
                        found = true;
                        break;
                    }
                }
                
                if (found) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>
@endsection