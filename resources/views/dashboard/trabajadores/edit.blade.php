@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('trabajadores.index') }}" class="text-decoration-none"><i class="fas fa-users"></i> Trabajadores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Trabajador</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary"><i class="fas fa-user-edit me-2"></i>Editar Trabajador</h2>
            <p class="text-muted">Modifique la información del trabajador <strong>{{ $trabajador->nombre_completo }}</strong></p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom border-light">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-user-edit text-primary fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $trabajador->nombre_completo }} {{ $trabajador->apellidos }}</h5>
                            <p class="mb-0 text-muted"><i class="fas fa-id-badge me-2"></i>{{ $trabajador->usuario }} | <i class="fas fa-id-card me-2"></i>{{ $trabajador->dni }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('trabajadores.update', $trabajador) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="usuario" class="form-label fw-bold"><i class="fas fa-user me-2 text-primary"></i>Usuario</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-at text-muted"></i></span>
                                        <input type="text" class="form-control bg-light border-0 @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario', $trabajador->usuario) }}" required>
                                    </div>
                                    @error('usuario')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold"><i class="fas fa-lock me-2 text-primary"></i>Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Nueva contraseña">
                                    </div>
                                    <div class="form-text"><i class="fas fa-info-circle me-1"></i>Dejar en blanco para mantener la contraseña actual.</div>
                                    @error('password')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h6 class="mb-3 text-primary"><i class="fas fa-id-card me-2"></i>Información Personal</h6>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="nombre_completo" class="form-label fw-bold">Nombre Completo</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-user-tag text-muted"></i></span>
                                        <input type="text" class="form-control bg-light border-0 @error('nombre_completo') is-invalid @enderror" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $trabajador->nombre_completo) }}" required>
                                    </div>
                                    @error('nombre_completo')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="apellidos" class="form-label fw-bold">Apellidos</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-user-tag text-muted"></i></span>
                                        <input type="text" class="form-control bg-light border-0 @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos', $trabajador->apellidos) }}" required>
                                    </div>
                                    @error('apellidos')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="dni" class="form-label fw-bold">DNI</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-id-card text-muted"></i></span>
                                        <input type="text" class="form-control bg-light border-0 @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{ old('dni', $trabajador->dni) }}" required maxlength="8">
                                    </div>
                                    @error('dni')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('trabajadores.index') }}" class="btn btn-outline-secondary rounded-pill me-2">
                                <i class="fas fa-arrow-left me-2"></i>Volver
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fas fa-save me-2"></i>Actualizar Trabajador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-3 bg-light mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-info-circle me-2 text-primary"></i>Información</h5>
                    <p class="card-text">Está editando la información del trabajador. Los cambios se aplicarán una vez que guarde el formulario.</p>
                    
                    <div class="alert alert-info border-0 mt-3">
                        <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Recomendaciones:</h6>
                        <ul class="mb-0 ps-3">
                            <li>Si no desea cambiar la contraseña, deje el campo en blanco</li>
                            <li>Verifique que el DNI tenga exactamente 8 dígitos</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Información del Registro</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item bg-transparent px-0 py-2 d-flex justify-content-between">
                            <span class="text-muted"><i class="fas fa-calendar-plus me-2"></i>Fecha de registro:</span>
                            <span class="fw-bold">{{ $trabajador->created_at->format('d/m/Y') }}</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-2 d-flex justify-content-between">
                            <span class="text-muted"><i class="fas fa-calendar-check me-2"></i>Última actualización:</span>
                            <span class="fw-bold">{{ $trabajador->updated_at->format('d/m/Y H:i') }}</span>
                        </li>
                        <li class="list-group-item bg-transparent px-0 py-2 d-flex justify-content-between">
                            <span class="text-muted"><i class="fas fa-fingerprint me-2"></i>ID:</span>
                            <span class="fw-bold">{{ $trabajador->id }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection