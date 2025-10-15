@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard.trabajadores') }}" class="text-decoration-none"><i class="fas fa-users"></i> Trabajadores</a></li>
            <li class="breadcrumb-item active" aria-current="page">Crear Nuevo</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="text-primary"><i class="fas fa-user-plus me-2"></i>Crear Nuevo Trabajador</h2>
            <p class="text-muted">Complete el formulario para registrar un nuevo trabajador en el sistema</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom border-light">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i>Formulario de Registro</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('trabajadores.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="usuario" class="form-label fw-bold"><i class="fas fa-user me-2 text-primary"></i>Usuario</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-at text-muted"></i></span>
                                        <input type="text" class="form-control bg-light border-0 @error('usuario') is-invalid @enderror" id="usuario" name="usuario" value="{{ old('usuario') }}" placeholder="Nombre de usuario" required>
                                    </div>
                                    @error('usuario')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">El nombre de usuario debe ser único en el sistema.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold"><i class="fas fa-lock me-2 text-primary"></i>Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="password" class="form-control bg-light border-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contraseña segura" required>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Mínimo 8 caracteres, incluya letras y números.</div>
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
                                        <input type="text" class="form-control bg-light border-0 @error('nombre_completo') is-invalid @enderror" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" placeholder="Nombres" required>
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
                                        <input type="text" class="form-control bg-light border-0 @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" value="{{ old('apellidos') }}" placeholder="Apellidos" required>
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
                                        <input type="text" class="form-control bg-light border-0 @error('dni') is-invalid @enderror" id="dni" name="dni" value="{{ old('dni') }}" placeholder="Número de DNI" required maxlength="8">
                                    </div>
                                    @error('dni')
                                        <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('dashboard.trabajadores') }}" class="btn btn-outline-secondary rounded-pill me-2">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fas fa-save me-2"></i>Guardar Trabajador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-3 bg-light">
                <div class="card-body p-4">
                    <h5 class="card-title"><i class="fas fa-info-circle me-2 text-primary"></i>Información</h5>
                    <p class="card-text">Al crear un nuevo trabajador, se generará una cuenta de acceso al sistema con los datos proporcionados.</p>
                    
                    <div class="alert alert-info border-0 mt-3">
                        <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Recomendaciones:</h6>
                        <ul class="mb-0 ps-3">
                            <li>Use nombres de usuario fáciles de recordar pero seguros</li>
                            <li>Las contraseñas deben tener al menos 8 caracteres</li>
                            <li>Verifique que el DNI sea correcto</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning border-0 mt-3">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Importante:</h6>
                        <p class="mb-0">Todos los campos son obligatorios para el registro exitoso del trabajador.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection