<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - DrodiPharma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c7be5;
            --secondary-color: #6c757d;
            --accent-color: #00d97e;
            --light-bg: #f8fafc;
            --card-shadow: 0 0.5rem 1.5rem rgba(22, 28, 45, 0.1);
        }
        
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e9ecef 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-container {
            max-width: 1200px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: white;
        }
        
        .login-illustration {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a4a8d 100%);
            color: white;
            padding: 3rem 2rem 3rem 0;
            margin-left: -15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-illustration::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
            z-index: 0;
        }
        
        .login-content {
            padding: 3rem 2.5rem;
            position: relative;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }
        
        .logo-icon i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }
        
        h1 {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .welcome-text {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .form-floating > label {
            color: #6b7280;
        }
        
        .form-control {
            height: 3.125rem;
            padding: 1rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(44, 123, 229, 0.15);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #1a4a8d;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(44, 123, 229, 0.3);
        }
        
        .btn-outline-secondary {
            border: 1px solid #e2e8f0;
            color: #4a5568;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary:hover {
            background-color: #f8fafc;
            border-color: #cbd5e0;
            transform: translateY(-2px);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: #4a5568;
            font-size: 0.9rem;
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        
        .forgot-password:hover {
            color: #1a4a8d;
            text-decoration: underline;
        }
        
        .illustration-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
        }
        
        .illustration-text {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 2rem 0 0;
            position: relative;
            z-index: 1;
        }
        
        .feature-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }
        
        .feature-list i {
            color: var(--accent-color);
            margin-right: 0.75rem;
            margin-top: 0.25rem;
            font-size: 1.25rem;
        }
        
        @media (max-width: 991.98px) {
            .login-illustration {
                display: none;
            }
            
            .login-content {
                padding: 2.5rem 2rem;
            }
        }
        
        @media (max-width: 575.98px) {
            .login-content {
                padding: 2rem 1.5rem;
            }
            
            .logo-icon {
                width: 70px;
                height: 70px;
            }
            
            .logo-icon i {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container">
        <div class="row g-0">
            <!-- Columna de ilustración -->
            <div class="col-lg-6 d-none d-lg-flex login-illustration">
                <div class="p-5">
                    <h2 class="illustration-title">Panel de Soporte</h2>
                    <p class="illustration-text">Acceso exclusivo para el equipo de soporte técnico de DrodiPharma.</p>
                    <ul class="feature-list">
                        <li>
                            <i class="bi bi-shield-lock"></i>
                            <div>
                                <h5 class="mb-1">Acceso Seguro</h5>
                                <p class="mb-0 small opacity-75">Conexión cifrada para proteger la información sensible.</p>
                            </div>
                        </li>
                        <li>
                            <i class="bi bi-tools"></i>
                            <div>
                                <h5 class="mb-1">Herramientas de Soporte</h5>
                                <p class="mb-0 small opacity-75">Acceso a las herramientas internas de soporte técnico.</p>
                            </div>
                        </li>
                        <li>
                            <i class="bi bi-people"></i>
                            <div>
                                <h5 class="mb-1">Equipo Especializado</h5>
                                <p class="mb-0 small opacity-75">Personal capacitado para resolver cualquier incidencia.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Formulario de inicio de sesión -->
            <div class="col-lg-6">
                <div class="login-content">
                    <div class="logo-container">
                        <div class="logo-icon">
                            <i class="bi bi-capsule-pill"></i>
                        </div>
                        <h1>DrodiPharma</h1>
                        <p class="welcome-text">Acceso al panel de soporte técnico</p>
                    </div>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="mb-3">
                            <label for="usuario" class="form-label small text-uppercase fw-bold text-muted mb-1">Usuario</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" class="form-control ps-3" id="usuario" name="usuario" value="{{ old('usuario') }}" placeholder="Ingresa tu usuario" required autofocus>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa tu usuario.
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" class="form-control ps-3" id="password" name="password" placeholder="••••••••" required>
                                <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa tu contraseña.
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label small" for="remember">
                                    Recordar sesión
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                        </button>
                        
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg w-100">
                            <i class="bi bi-arrow-left me-2"></i>Volver al inicio
                        </a>
                        
                        <div class="text-center mt-4">
                            <p class="small text-muted mb-0">Acceso exclusivo para el equipo de soporte. <br>Si necesitas acceso, contacta al administrador del sistema.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar contraseña
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('bi-eye');
                this.querySelector('i').classList.toggle('bi-eye-slash');
            });
            
            // Validación de formulario
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
</body>
</html>