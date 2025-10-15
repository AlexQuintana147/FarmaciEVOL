@extends('layouts.app')

@section('title', 'Blog')

@section('content')
<!-- Hero Section con fondo médico -->
<div class="hero-section mb-5" style="background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);">
    <!-- Elementos decorativos médicos flotantes con animación -->
    <div class="floating-icon" style="top: 15%; left: 10%; animation: float 6s ease-in-out infinite;"><i class="fas fa-book-medical text-primary"></i></div>
    <div class="floating-icon" style="top: 25%; right: 15%; animation: float 8s ease-in-out infinite;"><i class="fas fa-heartbeat text-danger"></i></div>
    <div class="floating-icon" style="bottom: 20%; left: 20%; animation: float 7s ease-in-out infinite;"><i class="fas fa-notes-medical text-success"></i></div>
    <div class="floating-icon" style="bottom: 30%; right: 10%; animation: float 9s ease-in-out infinite;"><i class="fas fa-stethoscope text-info"></i></div>
    
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="bg-white p-4 rounded-lg shadow-sm border-start border-5 border-primary">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-newspaper text-primary fa-2x"></i>
                        </div>
                        <h1 class="display-5 fw-bold text-primary mb-0">Blog de Salud</h1>
                    </div>
                    <div class="divider mb-4" style="width: 70px; height: 3px; background-color: var(--medical-green);"></div>
                    <p class="lead">Artículos y consejos de salud escritos por nuestros profesionales farmacéuticos para ayudarte a cuidar tu bienestar.</p>
                    <div class="mt-4">
                        <a href="#blogs-container" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                            <i class="fas fa-search me-2"></i>Explorar artículos
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                @php
                    $imagenUltimoBlog = $ultimoBlog && $ultimoBlog->imagen ? asset($ultimoBlog->imagen) : asset('images/NoImage.png');
                    $tituloUltimoBlog = $ultimoBlog ? $ultimoBlog->titulo : 'Blog de Salud';
                    $subtituloUltimoBlog = $ultimoBlog ? $ultimoBlog->subtitulo : '';
                @endphp
                <div class="position-relative rounded-lg shadow overflow-hidden" style="transform: rotate(-2deg);">
                    <!-- Etiqueta de nuevo artículo -->
                    <div class="position-absolute top-0 start-0 bg-primary text-white py-1 px-3 m-3 rounded-pill z-index-1 shadow-sm">
                        <i class="fas fa-star me-1"></i> Destacado
                    </div>
                    
                    <!-- Imagen del blog -->
                    <img src="{{ $imagenUltimoBlog }}" class="img-fluid" alt="{{ $tituloUltimoBlog }}" style="width: 100%; height: 400px; object-fit: cover;">
                    
                    <!-- Información del blog -->
                    @if($ultimoBlog)
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-white bg-opacity-90 border-top border-primary border-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1 fw-bold text-primary">{{ $tituloUltimoBlog }}</h5>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary rounded-pill px-3 py-2 me-2">
                                            <i class="fas fa-user-md me-1"></i> {{ $ultimoBlog->trabajador->nombre_completo }}
                                        </span>
                                    </div>
                                </div>
                                <a href="#blogModal{{ $ultimoBlog->id }}" data-bs-toggle="modal" class="btn btn-sm btn-outline-primary rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos para la animación flotante -->
<style>
    @keyframes float {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
    .floating-icon {
        position: absolute;
        font-size: 2rem;
        opacity: 0.5;
        z-index: 1;
    }
</style>

<div id="blogs-container" class="container py-3">
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-white p-3 rounded-lg shadow-sm mb-4">
                <h5 class="text-center mb-3"><i class="fas fa-newspaper me-2 text-primary"></i>Artículos Recientes</h5>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse($blogs as $blog)
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 blog-card">
                    <style>
                        /* Mejora visual de cards de blog */
                        .blog-card {
                            transition: all 0.3s cubic-bezier(.4,2,.3,1.1);
                            border-radius: 0.8rem;
                            overflow: hidden;
                            box-shadow: 0 4px 16px rgba(74,137,220,0.10);
                            border: 1px solid #e8f4fd;
                        }
                        .blog-card:hover {
                            transform: translateY(-8px) scale(1.025);
                            box-shadow: 0 12px 28px rgba(32,201,151,0.13) !important;
                            border-color: var(--medical-blue);
                        }
                        .blog-img-container {
                            position: relative;
                            overflow: hidden;
                            height: 220px;
                            background: #e8f4fd;
                        }
                        .blog-img-container img {
                            transition: transform 0.5s cubic-bezier(.4,2,.3,1.1);
                            object-fit: cover;
                            height: 100%;
                            width: 100%;
                        }
                        .blog-img-container:hover img {
                            transform: scale(1.08);
                            filter: brightness(0.96) saturate(1.1);
                        }
                        .blog-date {
                            position: absolute;
                            top: 12px;
                            left: 12px;
                            background-color: var(--medical-blue);
                            color: #fff;
                            padding: 4px 12px;
                            border-radius: 20px;
                            font-size: 0.85rem;
                            box-shadow: 0 2px 8px rgba(32,201,151,0.07);
                        }
                        .blog-author {
                            display: flex;
                            align-items: center;
                        }
                        .blog-author-avatar {
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            background-color: var(--medical-light-blue);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin-right: 10px;
                            color: var(--medical-blue);
                            font-size: 1.2rem;
                            box-shadow: 0 2px 6px rgba(74,137,220,0.08);
                        }
                        .card-title {
                            font-size: 1.18rem;
                            color: var(--medical-blue);
                            font-weight: 700;
                        }
                        .card-subtitle {
                            font-size: 1rem;
                            color: #6c757d;
                        }
                        .divider {
                            width: 40px;
                            height: 3px;
                            background-color: var(--medical-green);
                            border-radius: 2px;
                            margin: 0.5rem 0 1rem 0;
                        }
                        .btn-primary, .btn-outline-primary {
                            font-weight: 600;
                            letter-spacing: 0.5px;
                            border-radius: 2rem;
                        }
                        .btn-outline-primary:hover, .btn-primary:hover {
                            transform: translateY(-2px) scale(1.04);
                            box-shadow: 0 4px 12px rgba(74,137,220,0.13);
                        }
                        /* Mejor modal */
                        .modal-content {
                            border-radius: 1.1rem;
                        }
                        .modal-header {
                            border-top-left-radius: 1.1rem;
                            border-top-right-radius: 1.1rem;
                        }
                        .modal-body img {
                            max-height: 320px;
                            object-fit: cover;
                            margin-bottom: 1.2rem;
                        }
                        .blog-content {
                            line-height: 1.8;
                            font-size: 1.07rem;
                            color: #444;
                        }
                        /* Mejora suscripción y categorías */
                        .category-card {
                            transition: all 0.3s ease;
                            border-radius: 0.5rem;
                        }
                        .category-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 10px 20px rgba(0,0,0,0.11) !important;
                        }
                        .category-icon {
                            width: 60px;
                            height: 60px;
                            border-radius: 50%;
                            background-color: var(--medical-light-blue);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            margin: 0 auto 1rem auto;
                            font-size: 1.5rem;
                        }
                        .bg-primary, .btn-primary {
                            background-color: var(--medical-blue) !important;
                            border-color: var(--medical-blue) !important;
                        }
                        .text-primary {
                            color: var(--medical-blue) !important;
                        }
                    </style>
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="blog-img-container">
                                @if($blog->created_at)
                                <div class="blog-date">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $blog->created_at->format('d/m/Y') }}
                                </div>
                                @endif
                                @if($blog->imagen)
                                    <img src="{{ asset($blog->imagen) }}" class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="{{ $blog->titulo }}">
                                @else
                                    <img src="https://placehold.co/300x400/e8f4fd/4a89dc?text=Blog" class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="{{ $blog->titulo }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">{{ $blog->titulo }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $blog->subtitulo }}</h6>
                                <div class="divider my-2" style="width: 40px; height: 3px; background-color: var(--medical-green);"></div>
                                <p class="card-text">{{ Str::limit($blog->contenido, 120) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div class="blog-author">
                                        <div class="blog-author-avatar">
                                            <i class="fas fa-user-md"></i>
                                        </div>
                                        <small class="text-muted">
                                            {{ $blog->trabajador->nombre_completo }} {{ $blog->trabajador->apellidos }}
                                        </small>
                                    </div>
                                    <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#blogModal{{ $blog->id }}">
                                        <i class="fas fa-book-open me-1"></i> Leer más
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="blogModal{{ $blog->id }}" tabindex="-1" aria-labelledby="blogModalLabel{{ $blog->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="blogModalLabel{{ $blog->id }}"><i class="fas fa-book-medical me-2"></i>{{ $blog->titulo }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="mb-4">
                                <h6 class="text-primary fw-bold">{{ $blog->subtitulo }}</h6>
                                <div class="divider my-3" style="width: 50px; height: 3px; background-color: var(--medical-green);"></div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="blog-author-avatar me-2">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <p class="small text-muted mb-0">
                                        Por: <span class="fw-bold">{{ $blog->trabajador->nombre_completo }} {{ $blog->trabajador->apellidos }}</span> | 
                                        <i class="far fa-calendar-alt ms-2 me-1"></i> {{ $blog->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                            @if($blog->imagen)
                                <div class="text-center bg-light p-3 rounded mb-4">
                                    <img src="{{ asset($blog->imagen) }}" class="img-fluid rounded" alt="{{ $blog->titulo }}" style="max-height: 400px;">
                                </div>
                            @endif
                            <div class="bg-white p-4 rounded">
                                <div class="blog-content">
                                    {!! nl2br(e($blog->contenido)) !!}
                                </div>
                                
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="fw-bold"><i class="fas fa-lightbulb text-warning me-2"></i>Consejo de salud</h6>
                                    <p class="small mb-0">Recuerde siempre consultar con un profesional de la salud antes de iniciar cualquier tratamiento o cambio en su régimen médico.</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cerrar
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-share-alt me-2"></i>Compartir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-lg shadow-sm">
                    <i class="fas fa-newspaper text-muted mb-3" style="font-size: 4rem;"></i>
                    <h3 class="text-primary">No hay artículos disponibles</h3>
                    <p class="lead">Estamos trabajando en nuevos contenidos para mantenerte informado.</p>
                    <p>Vuelve pronto para leer nuestros artículos de salud.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Sección de suscripción al boletín -->
    <div class="row mt-5 mb-4">
        <div class="col-12">
            <div class="bg-primary text-white p-4 rounded-lg shadow-sm">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <h4 class="fw-bold"><i class="fas fa-envelope-open-text me-2"></i>Suscríbete a nuestro boletín</h4>
                        <p class="mb-0">Recibe los últimos artículos y consejos de salud directamente en tu correo.</p>
                    </div>
                    <div class="col-lg-5">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Tu correo electrónico" aria-label="Tu correo electrónico">
                            <button class="btn btn-light text-primary fw-bold" type="button">Suscribirse</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sección de categorías de salud -->
    <div class="row mt-5">
        <div class="col-12 mb-4">
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <h5 class="text-center"><i class="fas fa-th-list me-2 text-primary"></i>Categorías de Salud</h5>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm category-card">
                <div class="card-body text-center p-4">
                    <div class="category-icon mb-3">
                        <i class="fas fa-heart text-danger"></i>
                    </div>
                    <h5 class="card-title">Salud Cardiovascular</h5>
                    <p class="card-text small text-muted">Consejos para mantener un corazón saludable.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm category-card">
                <div class="card-body text-center p-4">
                    <div class="category-icon mb-3">
                        <i class="fas fa-brain text-primary"></i>
                    </div>
                    <h5 class="card-title">Salud Mental</h5>
                    <p class="card-text small text-muted">Bienestar emocional y psicológico.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm category-card">
                <div class="card-body text-center p-4">
                    <div class="category-icon mb-3">
                        <i class="fas fa-apple-alt text-success"></i>
                    </div>
                    <h5 class="card-title">Nutrición</h5>
                    <p class="card-text small text-muted">Alimentación saludable y equilibrada.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card h-100 border-0 shadow-sm category-card">
                <div class="card-body text-center p-4">
                    <div class="category-icon mb-3">
                        <i class="fas fa-running text-warning"></i>
                    </div>
                    <h5 class="card-title">Ejercicio</h5>
                    <p class="card-text small text-muted">Actividad física para una vida saludable.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection