@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <!-- Estilos específicos para el dashboard médico -->
    <style>
        .dashboard-header {
            background: linear-gradient(135deg, #4a89dc, #37bc9b);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .stats-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .stats-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-footer {
            background: rgba(0, 0, 0, 0.05);
            border-top: none;
        }
        .card-footer a {
            transition: all 0.2s ease;
            font-weight: 500;
        }
        .card-footer a:hover {
            padding-right: 5px;
        }
        .dashboard-section-title {
            position: relative;
            padding-left: 15px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #2c3e50;
        }
        .dashboard-section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 70%;
            width: 4px;
            background: linear-gradient(to bottom, #4a89dc, #37bc9b);
            border-radius: 2px;
        }
        .floating-icon {
            position: absolute;
            opacity: 0.1;
            font-size: 3rem;
            color: #4a89dc;
            z-index: 0;
            animation: float 6s ease-in-out infinite;
        }
        
        /* Estilos eliminados ya que ahora usamos clases de Bootstrap */
        
        /* Estilos para la animación de pulso */
        .btn-chatbot-pulse {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            border-radius: 50px;
            z-index: -1;
            opacity: 0.8;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }
            70% {
                transform: scale(1.05);
                opacity: 0;
            }
            100% {
                transform: scale(1.1);
                opacity: 0;
            }
        }
        
        /* Estilos para el hover de los botones de métricas */
        .btn.rounded-pill[href*="metrics"] i.fa-arrow-right {
            transition: transform 0.3s ease;
        }
        
        .btn.rounded-pill[href*="metrics"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 20px rgba(0, 0, 0, 0.2) !important;
        }
        
        .btn.rounded-pill[href*="metrics"]:hover i.fa-arrow-right {
            transform: translateX(5px);
        }
        
        .btn.rounded-pill[href*="metrics"]:active {
            transform: translateY(1px);
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
    
    <!-- Header del Dashboard -->
    <div class="dashboard-header text-white position-relative overflow-hidden">
        <!-- Iconos flotantes decorativos -->
        <div class="floating-icon" style="top: 10%; right: 10%;"><i class="fas fa-pills"></i></div>
        <div class="floating-icon" style="bottom: 10%; left: 15%;"><i class="fas fa-heartbeat"></i></div>
        
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2">Panel de Administración</h1>
                <p class="mb-0 opacity-75">Bienvenido al sistema de gestión de DrodiPharma. Aquí podrás administrar todos los aspectos de tu farmacia.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="bg-white bg-opacity-10 p-3 rounded-pill d-inline-block">
                    <i class="fas fa-calendar-alt me-2"></i> {{ now()->format('d M, Y') }}
                </div>
            </div>
        </div>
        <!-- Botones de métricas -->
        <div class="d-flex justify-content-end gap-3 mb-4 mt-3">
            <a href="{{ route('blog.metrics') }}" class="btn rounded-pill text-white px-4 py-2 d-inline-flex align-items-center" style="background: linear-gradient(135deg, #6c5ce7, #a55eea); box-shadow: 0 4px 15px rgba(106, 92, 231, 0.3);">
                <i class="fas fa-chart-line me-2"></i>Métricas de Blogs
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <a href="{{ route('chatbot.metrics') }}" class="btn rounded-pill text-white px-4 py-2 d-inline-flex align-items-center position-relative" style="background: linear-gradient(135deg, #2575fc, #6a11cb); box-shadow: 0 4px 15px rgba(37, 117, 252, 0.3);">
                <i class="fas fa-robot me-2"></i>Métricas del Chatbot
                <i class="fas fa-arrow-right ms-2"></i>
                <span class="btn-chatbot-pulse"></span>
            </a>
            <a href="{{ route('autogenerador.logs') }}" class="btn rounded-pill text-white px-4 py-2 d-inline-flex align-items-center position-relative" style="background: linear-gradient(135deg, #ff9f43, #ff6b6b); box-shadow: 0 4px 15px rgba(255, 159, 67, 0.3);">
                <i class="fas fa-magic me-2"></i>Métricas de Productos
                <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
    
    <!-- Tarjetas de estadísticas mejoradas -->
    <h4 class="dashboard-section-title">Resumen General</h4>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #4a89dc, #37bc9b);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold">Productos</h5>
                            <h2 class="display-5 fw-bold mb-0">{{ $stats['productos'] }}</h2>
                            <p class="mb-0 mt-2 opacity-75"><i class="fas fa-box-open me-1"></i> Inventario total</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-capsules fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('dashboard.productos') }}" class="text-white">Ver detalles</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #37bc9b, #48cfad);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold">Blogs</h5>
                            <h2 class="display-5 fw-bold mb-0">{{ $stats['blogs'] }}</h2>
                            <p class="mb-0 mt-2 opacity-75"><i class="fas fa-file-medical-alt me-1"></i> Artículos publicados</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-book-medical fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('dashboard.blogs') }}" class="text-white">Ver detalles</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #ff6b6b, #ff8e53);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold">Ofertas</h5>
                            <h2 class="display-5 fw-bold mb-0">{{ $stats['ofertas'] ?? 0 }}</h2>
                            <p class="mb-0 mt-2 opacity-75"><i class="fas fa-tags me-1"></i> Promociones activas</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-percentage fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('dashboard.ofertas') }}" class="text-white">Ver detalles</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card stats-card h-100" style="background: linear-gradient(135deg, #5d9cec, #967adc);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title fw-bold">Trabajadores</h5>
                            <h2 class="display-5 fw-bold mb-0">{{ $stats['trabajadores'] }}</h2>
                            <p class="mb-0 mt-2 opacity-75"><i class="fas fa-user-md me-1"></i> Personal activo</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-stethoscope fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="{{ route('dashboard.trabajadores') }}" class="text-white">Ver detalles</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contenido reciente -->
    <h4 class="dashboard-section-title">Actividad Reciente</h4>
    <div class="row">
        <!-- Blogs recientes -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary"><i class="fas fa-book-medical me-2"></i>Blogs Recientes</h5>
                    <span class="badge bg-primary rounded-pill">{{ count($recentBlogs) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentBlogs as $blog)
                            <a href="{{ route('blogs.show', $blog) }}" class="list-group-item list-group-item-action border-0 py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($blog->imagen)
                                            <img src="{{ asset($blog->imagen) }}" class="rounded-circle" width="45" height="45" style="object-fit: cover;" alt="{{ $blog->titulo }}">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-file-medical text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-bold text-primary">{{ $blog->titulo }}</h6>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $blog->created_at->diffForHumans(['parts' => 2, 'join' => ' y ', 'locale' => 'es']) }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted">{{ Str::limit($blog->subtitulo, 80) }}</p>
                                        <small class="text-primary"><i class="fas fa-user-md me-1"></i>{{ $blog->trabajador->nombre_completo }}</small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white text-end border-top-0">
                    <a href="{{ route('dashboard.blogs') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        <i class="fas fa-clipboard-list me-1"></i>Ver todos los blogs
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Productos recientes -->
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-success"><i class="fas fa-capsules me-2"></i>Productos Recientes</h5>
                    <span class="badge bg-success rounded-pill">{{ count($recentProductos) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($recentProductos as $producto)
                            <a href="{{ route('productos.show', $producto) }}" class="list-group-item list-group-item-action border-0 py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($producto->imagen)
                                            <img src="{{ asset($producto->imagen) }}" class="rounded-circle" width="45" height="45" style="object-fit: cover;" alt="{{ $producto->titulo }}">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                <i class="fas fa-pills text-success"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-bold text-success">{{ $producto->titulo }}</h6>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $producto->created_at->diffForHumans(['parts' => 2, 'join' => ' y ', 'locale' => 'es']) }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted">{{ Str::limit($producto->descripcion, 80) }}</p>
                                        <small>
                                            <span class="badge bg-{{ $producto->categoria == 'Medicamentos' ? 'primary' : ($producto->categoria == 'Vitaminas' ? 'success' : ($producto->categoria == 'Cuidado Personal' ? 'info' : ($producto->categoria == 'Primeros Auxilios' ? 'danger' : 'warning'))) }} rounded-pill">
                                                <i class="fas fa-tag me-1"></i>{{ $producto->categoria }}
                                            </span>
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('dashboard.productos') }}" class="btn btn-success btn-sm">Ver todos los productos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Podemos agregar scripts específicos para el dashboard aquí
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard cargado correctamente');
    });
</script>
@endsection