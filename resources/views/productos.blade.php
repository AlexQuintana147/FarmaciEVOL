@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<!-- Hero Section con fondo médico -->
<div class="hero-section mb-5" style="background: linear-gradient(135deg, #e8f5fe 0%, #f0f9ff 100%);">
    <!-- Elementos decorativos médicos flotantes con animación -->
    <div class="floating-icon" style="top: 15%; left: 10%; animation: float 6s ease-in-out infinite;"><i class="fas fa-pills text-primary"></i></div>
    <div class="floating-icon" style="top: 25%; right: 15%; animation: float 8s ease-in-out infinite;"><i class="fas fa-capsules text-success"></i></div>
    <div class="floating-icon" style="bottom: 20%; left: 20%; animation: float 7s ease-in-out infinite;"><i class="fas fa-prescription text-info"></i></div>
    <div class="floating-icon" style="bottom: 30%; right: 10%; animation: float 9s ease-in-out infinite;"><i class="fas fa-tablets text-warning"></i></div>
    
    <div class="container py-5">
        @if($ultimoProducto)
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="bg-white p-4 rounded-lg shadow-sm border-start border-5 border-primary">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="fas fa-shopping-basket text-primary fa-2x"></i>
                            </div>
                            <h1 class="display-5 fw-bold text-primary mb-0">Nuestros Productos</h1>
                        </div>
                        <div class="divider mb-4" style="width: 70px; height: 3px; background-color: var(--medical-green);"></div>
                        <p class="lead">Descubre nuestra amplia gama de productos farmacéuticos de la más alta calidad para el cuidado de tu salud y bienestar.</p>
                        <div class="mt-4">
                            <a href="#productos-container" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                <i class="fas fa-search me-2"></i>Explorar productos
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    @php
                        $imagenUltimoProducto = $ultimoProducto && $ultimoProducto->imagen ? asset($ultimoProducto->imagen) : asset('images/NoImage.png');
                        $tituloUltimoProducto = $ultimoProducto ? $ultimoProducto->titulo : 'Productos Farmacéuticos';
                        $categoriaUltimoProducto = $ultimoProducto ? $ultimoProducto->categoria : '';
                        
                        $categoryIcon = 'fas fa-pills';
                        if($categoriaUltimoProducto == 'Cuidado Personal') {
                            $categoryIcon = 'fas fa-pump-soap';
                        } elseif($categoriaUltimoProducto == 'Vitaminas') {
                            $categoryIcon = 'fas fa-apple-alt';
                        } elseif($categoriaUltimoProducto == 'Bebés') {
                            $categoryIcon = 'fas fa-baby';
                        }
                    @endphp
                    <div class="position-relative rounded-lg shadow overflow-hidden" style="transform: rotate(2deg);">
                        <!-- Etiqueta de nuevo producto -->
                        <div class="position-absolute top-0 start-0 bg-danger text-white py-1 px-3 m-3 rounded-pill z-index-1 shadow-sm">
                            <i class="fas fa-bolt me-1"></i> Nuevo
                        </div>
                        
                        <!-- Imagen del producto -->
                        <img src="{{ $imagenUltimoProducto }}" class="img-fluid" alt="{{ $tituloUltimoProducto }}" style="width: 100%; height: 400px; object-fit: cover;">
                        
                        <!-- Información del producto -->
                        <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-white bg-opacity-90 border-top border-primary border-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1 fw-bold text-primary">{{ $tituloUltimoProducto }}</h5>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary rounded-pill px-3 py-2 me-2">
                                            <i class="{{ $categoryIcon }} me-1"></i> {{ $categoriaUltimoProducto }}
                                        </span>
                                    </div>
                                </div>
                                <a href="#productoModal{{ $ultimoProducto->id }}" data-bs-toggle="modal" class="btn btn-sm btn-outline-primary rounded-circle">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="bg-white p-4 rounded-lg shadow-sm border-start border-5 border-primary">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="fas fa-shopping-basket text-primary fa-2x"></i>
                            </div>
                            <h1 class="display-5 fw-bold text-primary mb-0">Nuestros Productos</h1>
                        </div>
                        <div class="divider mx-auto mb-4" style="width: 70px; height: 3px; background-color: var(--medical-green);"></div>
                        
                        <!-- Mensaje cuando no hay productos -->
                        <div class="bg-light rounded-3 p-5 shadow-sm">
                            <div class="mb-4">
                                <i class="fas fa-pills text-primary" style="font-size: 3rem; opacity: 0.7;"></i>
                            </div>
                            <h4 class="text-muted mb-3">No hay productos de momento</h4>
                            <p class="text-muted">Estamos trabajando en nuevos productos farmacéuticos para ti.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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

<div class="container py-3">

    <!-- Sección de filtros con estilo médico -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <h5 class="text-center mb-3"><i class="fas fa-filter me-2 text-primary"></i>Filtrar por categoría</h5>
                <div class="d-flex justify-content-center flex-wrap gap-2">
                    <button class="btn filter-btn active" data-filter="all">
                        <i class="fas fa-th-large me-1"></i> Todos
                    </button>
                    <button class="btn filter-btn" data-filter="Medicamentos">
                        <i class="fas fa-pills me-1"></i> Medicamentos
                    </button>
                    <button class="btn filter-btn" data-filter="Cuidado Personal">
                        <i class="fas fa-pump-soap me-1"></i> Cuidado Personal
                    </button>
                    <button class="btn filter-btn" data-filter="Vitaminas">
                        <i class="fas fa-apple-alt me-1"></i> Vitaminas
                    </button>
                    <button class="btn filter-btn" data-filter="Bebés">
                        <i class="fas fa-baby me-1"></i> Bebés
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="productos-container">
        @forelse($productos as $producto)
            @php
                $categoryIcon = 'fas fa-pills';
                if($producto->categoria == 'Cuidado Personal') {
                    $categoryIcon = 'fas fa-pump-soap';
                } elseif($producto->categoria == 'Vitaminas') {
                    $categoryIcon = 'fas fa-apple-alt';
                } elseif($producto->categoria == 'Bebés') {
                    $categoryIcon = 'fas fa-baby';
                }
                $imagePath = $producto->imagen ? asset($producto->imagen) : asset('images/NoImage.png');
                $modalImagePath = $producto->imagen ? asset($producto->imagen) : asset('images/NoImage.png');
            @endphp
            <div class="col-md-4 mb-4 producto-item" data-categoria="{{ $producto->categoria }}">
                <div class="card h-100 shadow-sm border-0 product-card position-relative">
                    <div class="category-badge">
                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                            <i class="{{ $categoryIcon }} me-1"></i> {{ $producto->categoria }}
                        </span>
                    </div>
                    <div class="card-img-container">
                        <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $producto->titulo }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $producto->titulo }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($producto->descripcion, 100) }}</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 pb-3 d-flex flex-column gap-2">
                        <button type="button" class="btn btn-primary w-100 rounded-pill" data-bs-toggle="modal" data-bs-target="#productoModal{{ $producto->id }}">
                            <i class="fas fa-eye me-2"></i>Ver Detalles
                        </button>
                        <a href="https://wa.me/51967692437?text=Hola,%20quiero%20consultar%20por%20el%20producto:%20{{ urlencode($producto->titulo) }}" target="_blank" class="btn btn-outline-success w-100 rounded-pill">
                            <i class="fab fa-whatsapp me-2"></i>Consultar por Whatsapp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modal para detalles del producto con estilo médico -->
            <div class="modal fade" id="productoModal{{ $producto->id }}" tabindex="-1" aria-labelledby="productoModalLabel{{ $producto->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title d-flex align-items-center gap-2" id="productoModalLabel{{ $producto->id }}">
                                <i class="{{ $categoryIcon }} me-2"></i>{{ $producto->titulo }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white fs-3" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <div class="modal-img-container text-center p-4 rounded">
                                        <img src="{{ $modalImagePath }}" class="img-fluid rounded" alt="{{ $producto->titulo }}" style="width: 100%; height: auto; max-height: 400px; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="fw-bold text-primary mb-3">{{ $producto->titulo }}</h4>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="badge bg-primary px-3 py-2 rounded-pill">
                                            <i class="{{ $categoryIcon }} me-1"></i> {{ $producto->categoria }}
                                        </span>
                                    </div>
                                    <div class="divider mb-3" style="width: 50px; height: 3px; background-color: var(--medical-green);"></div>
                                    <h6 class="fw-bold mb-2">Descripción:</h6>
                                    <p class="mb-4">{{ $producto->descripcion }}</p>
                                    <div class="bg-light p-3 rounded mb-3">
                                        <h6 class="fw-bold mb-2"><i class="fas fa-info-circle me-2 text-primary"></i>Información adicional</h6>
                                        <p class="small mb-0">Consulte a su médico o farmacéutico antes de usar este producto. Mantenga todos los medicamentos fuera del alcance de los niños.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cerrar
                            </button>
                            <a href="https://wa.me/51967692437?text=Hola,%20quiero%20consultar%20por%20el%20producto:%20{{ urlencode($producto->titulo) }}" target="_blank" class="btn btn-success rounded-pill px-4">
                                <i class="fab fa-whatsapp me-2"></i>Consultar por Whatsapp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="bg-light rounded-3 p-5 shadow-sm">
                    <div class="mb-4">
                        <i class="fas fa-pills text-primary" style="font-size: 3rem; opacity: 0.7;"></i>
                    </div>
                    <h4 class="text-muted mb-3">No hay productos de momento</h4>
                    <p class="text-muted">Estamos trabajando en nuevos productos para ti.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Sección de información adicional -->
    <div class="row mt-5 mb-4">
        <div class="col-12">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div class="p-3">
                            <i class="fas fa-truck text-primary mb-3" style="font-size: 2.5rem;"></i>
                            <h5 class="fw-bold">Entrega a Domicilio</h5>
                            <p class="text-muted mb-0">Llevamos tus medicamentos directamente a tu hogar.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3">
                            <i class="fas fa-certificate text-primary mb-3" style="font-size: 2.5rem;"></i>
                            <h5 class="fw-bold">Productos Certificados</h5>
                            <p class="text-muted mb-0">Garantizamos la calidad y autenticidad de todos nuestros productos.</p>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3">
                            <i class="fas fa-headset text-primary mb-3" style="font-size: 2.5rem;"></i>
                            <h5 class="fw-bold">Atención Personalizada</h5>
                            <p class="text-muted mb-0">Nuestro equipo está disponible para resolver tus dudas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productoItems = document.querySelectorAll('.producto-item');
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filter = this.getAttribute('data-filter');
                productoItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-categoria') === filter) {
                        item.style.display = 'block';
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transition = 'opacity 0.5s ease';
                        }, 50);
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

@section('extra_css')
<style>
    /* Filtros UX Mejorados */
    .filter-btn {
        transition: all 0.3s ease;
        border-radius: 20px;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        border: 2px solid var(--medical-blue);
        background: white;
        color: var(--medical-blue);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .filter-btn.active, .filter-btn:focus {
        background: var(--medical-blue);
        color: #fff;
        border-color: var(--medical-blue);
        box-shadow: 0 4px 12px rgba(32,201,151,0.12);
    }
    .filter-btn:hover {
        transform: translateY(-2px) scale(1.04);
        background: var(--medical-blue);
        color: #fff;
    }
    /* Tarjetas de producto */
    .product-card {
        transition: box-shadow 0.3s, transform 0.3s;
        border-radius: 0.7rem;
        overflow: hidden;
        background: #fff;
    }
    .product-card:hover {
        box-shadow: 0 10px 24px rgba(32,201,151,0.13), 0 2px 8px rgba(0,0,0,0.07);
        transform: translateY(-8px) scale(1.03);
    }
    .category-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
        font-size: 0.95rem;
        pointer-events: none;
    }
    .card-img-container {
        position: relative;
        padding-top: 75%;
        overflow: hidden;
        background: #e8f4fd;
    }
    .card-img-container img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%; object-fit: contain;
        transition: transform 0.5s ease;
    }
    .card-img-container:hover img {
        transform: scale(1.07);
    }
    /* Modal UX */
    .modal-header {
        border-top-left-radius: 0.7rem;
        border-top-right-radius: 0.7rem;
    }
    .modal-content {
        border-radius: 0.7rem;
    }
    .modal-footer {
        border-bottom-left-radius: 0.7rem;
        border-bottom-right-radius: 0.7rem;
    }
    .btn-close {
        font-size: 1.3rem;
        opacity: 0.9;
    }
    /* Accesibilidad */
    .btn:focus, .filter-btn:focus {
        outline: 2px solid var(--medical-green);
        outline-offset: 2px;
        box-shadow: 0 0 0 3px rgba(32,201,151,0.18);
    }
    /* Loader animado para productos vacíos */
    .empty-loader {
        width: 3rem; height: 3rem; border: 5px solid #e8f4fd; border-top: 5px solid var(--medical-blue); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem auto;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@endsection