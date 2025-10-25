@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<style>

    /* Estilos generales mejorados */
    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
    }
    
    .offers-container {
        background: linear-gradient(135deg, #f0f8ff, #ffffff);
        border-radius: 15px;
        padding: 40px 0;
        position: relative;
        overflow: hidden;
    }

    .offer-card {
        border: none;
        transition: all 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    .offer-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .offer-card .card-img-top {
        height: 200px;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .offer-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    /* Estilos para el nuevo carrusel de ofertas */
    .ofertas-carousel {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
    }

    .ofertas-track {
        display: flex;
        animation: scrollOfertas 30s linear infinite;
    }

    .oferta-item {
        flex: 0 0 300px;
        padding: 0 15px;
        perspective: 1000px;
    }

    .oferta-imagen-container {
        height: 200px;
        overflow: hidden;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .oferta-imagen {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s;
    }

    .offer-card:hover .oferta-imagen {
        transform: scale(1.05);
    }

    @keyframes scrollOfertas {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(calc(-300px * @php echo count($ofertasDelMes) @endphp)); /* Ancho de una serie completa */
        }
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        background-color: rgba(13, 110, 253, 0.7);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .carousel:hover .carousel-control-prev,
    .carousel:hover .carousel-control-next {
        opacity: 1;
    }

    .carousel-indicators {
        bottom: -50px;
    }

    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #0d6efd;
        opacity: 0.5;
    }

    .carousel-indicators button.active {
        opacity: 1;
    }

    .floating-elements .floating-icon {
        position: absolute;
        font-size: 3rem;
        color: rgba(13, 110, 253, 0.1);
        animation: float 6s ease-in-out infinite;
    }
    /* Estilos para la sección hero */
    .hero-section {
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .hero-content {
        border-left: 5px solid #0d6efd;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .hero-content:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    
    /* Iconos flotantes animados */
    .medical-icons-overlay {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
    }
    
    .floating-icon {
        position: absolute;
        font-size: 2rem;
        color: rgba(255,255,255,0.5);
        animation: float 6s ease-in-out infinite;
        z-index: 1;
    }
    
    .floating-icon:nth-child(2) {
        animation-delay: 1s;
    }
    
    .floating-icon:nth-child(3) {
        animation-delay: 2s;
    }
    
    .floating-icon:nth-child(4) {
        animation-delay: 3s;
    }
    
    @keyframes float {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(5deg); }
        100% { transform: translateY(0) rotate(0deg); }
    }
    
    /* Estilos para la sección de consulta */
    .consultation-section {
        position: relative;
        box-shadow: inset 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .icon-animate {
        animation: pulse 4s ease-in-out infinite;
    }
    
    .icon-animate:nth-child(2) {
        animation-delay: 1s;
    }
    
    .icon-animate:nth-child(3) {
        animation-delay: 2s;
    }
    
    .icon-animate:nth-child(4) {
        animation-delay: 3s;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.2; }
        50% { transform: scale(1.1); opacity: 0.3; }
        100% { transform: scale(1); opacity: 0.2; }
    }
    
    /* Estilos para botón de WhatsApp */
    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 1.2rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-whatsapp:hover {
        background-color: #128C7E;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
    }
    
    /* Estilos para las tarjetas */
    .hover-card {
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        border-top: 5px solid transparent;
    }
    
    .hover-card:hover {
        transform: translateY(-15px);
        border-top: 5px solid #0d6efd;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1)!important;
    }
    
    .icon-wrapper {
        width: 90px;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: all 0.3s ease;
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.2) 100%);
    }
    
    .hover-card:hover .icon-wrapper {
        transform: rotateY(180deg);
    }
    
    /* Estilos para el patrón de onda */
    .wave-pattern {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        line-height: 0;
        pointer-events: none;
    }
    
    .wave-svg {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 200px;
    }
    
    /* Estilos para la sección de blog */
    .blog-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        position: relative;
        overflow: hidden;
    }
    
    .blog-section::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.05);
        z-index: 0;
    }
    
    .blog-section::after {
        content: '';
        position: absolute;
        bottom: -70px;
        left: -70px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: rgba(13, 110, 253, 0.05);
        z-index: 0;
    }
    
    .blog-img {
        transition: all 0.5s ease;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .blog-img:hover {
        transform: scale(1.03);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    </style>


<div class="hero-section position-relative" style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('images/bannerInicio.jpg') }}') no-repeat center center; background-size: cover; min-height: 600px;">
    <!-- Animated Medical Icons Overlay -->
    <div class="medical-icons-overlay">
        <div class="floating-icon" style="top: 15%; left: 10%;"><i class="fas fa-heartbeat"></i></div>
        <div class="floating-icon" style="top: 25%; right: 15%;"><i class="fas fa-pills"></i></div>
        <div class="floating-icon" style="bottom: 20%; left: 20%;"><i class="fas fa-stethoscope"></i></div>
        <div class="floating-icon" style="bottom: 30%; right: 10%;"><i class="fas fa-capsules"></i></div>
    </div>
    
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center" style="min-height: 600px;">
            <div class="col-md-7">
                <div class="hero-content p-5 rounded-lg" style="background: rgba(255, 255, 255, 0.9);">
                    <h1 class="display-4 fw-bold text-primary mb-3">Bienvenido a DrodiPharma</h1>
                    <p class="lead text-dark mb-4">Tu farmacia de confianza con los mejores productos para tu salud y bienestar. Ofrecemos atención personalizada y productos de calidad.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ url('/productos') }}" class="btn btn-primary btn-lg shadow-sm"><i class="fas fa-shopping-basket me-2"></i>Ver Productos</a>
                        <a href="#servicios" class="btn btn-outline-primary btn-lg"><i class="fas fa-info-circle me-2"></i>Nuestros Servicios</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="consultation-section position-relative overflow-hidden py-5" style="background: linear-gradient(135deg, #e8f5fe 0%, #f0f9ff 100%);">
    <div class="wave-pattern">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none" class="wave-svg">
            <path fill="rgba(13, 110, 253, 0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
        
        <!-- Animated Medical Icons -->
        <div class="animated-icons">
            <i class="fas fa-pills icon-animate" style="position: absolute; font-size: 2.5rem; left: 10%; top: 20%; color: rgba(13, 110, 253, 0.2);"></i>
            <i class="fas fa-prescription-bottle-alt icon-animate" style="position: absolute; font-size: 2rem; right: 15%; top: 30%; color: rgba(13, 110, 253, 0.2);"></i>
            <i class="fas fa-capsules icon-animate" style="position: absolute; font-size: 2.2rem; left: 25%; bottom: 25%; color: rgba(13, 110, 253, 0.2);"></i>
            <i class="fas fa-first-aid icon-animate" style="position: absolute; font-size: 2.3rem; right: 25%; bottom: 40%; color: rgba(13, 110, 253, 0.2);"></i>
        </div>
    </div>
    
    <div class="container my-4 py-4" id="servicios">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 mb-5">
                <div class="section-heading mb-4">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Atención Personalizada</span>
                    <h2 class="fw-bold text-primary">CONSULTE SOBRE NUESTROS PRODUCTOS Y PRECIOS</h2>
                    <div class="divider mx-auto my-3" style="width: 70px; height: 3px; background-color: #0d6efd;"></div>
                    <p class="text-muted">Estamos disponibles para resolver todas sus dudas y brindarle la mejor asesoría farmacéutica</p>
                </div>
                <a href="https://api.whatsapp.com/send/?phone=51967692437&text=¡Hola! Me interesa conocer más sobre sus productos farmacéuticos.%0A%0AMe gustaría recibir información sobre:%0APrecios,%0ADisponibilidad%0AY Ofertas especiales%0A%0A¡Gracias por su atención!" target="_blank" class="btn btn-whatsapp btn-lg shadow-lg">
                    <i class="fab fa-whatsapp me-2"></i>Consultar por WhatsApp
                </a>
                <a href="https://heyzine.com/flip-book/fd9fcc5d58.html" target="_blank" class="btn btn-whatsapp btn-lg shadow-lg" style="background-color: #FFD700; color: #000;">
                    <i class="fas fa-book me-2"></i>¡REVISA NUESTRO CATÁLOGO ONLINE!
                </a>
            </div>
        </div>
    </div>
</div>

<div class="features-section py-5 my-5">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Nuestras Ventajas</span>
                <h2 class="display-4 fw-bold text-primary mb-3">¿Por qué elegirnos?</h2>
                <div class="divider mx-auto my-3" style="width: 70px; height: 3px; background-color: #0d6efd;"></div>
                <p class="lead fs-4 text-muted">Ofrecemos productos de calidad y un servicio excepcional</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg hover-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-wrapper mb-4 rounded-circle p-3 d-inline-block">
                            <i class="fas fa-clock text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="card-title h3 mb-3 text-primary">Horario de Atención</h4>
                        <p class="card-text fs-5 mb-2">Lunes a Sábado: 8am - 8 pm</p>
                        <p class="fs-5">Domingo: 8am - 12 pm</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg hover-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-wrapper mb-4 rounded-circle p-3 d-inline-block">
                            <i class="fas fa-user-md text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="card-title h3 mb-3 text-primary">Consultoría para evitar sanciones</h4>
                        <p class="card-text fs-5">Te actualizamos, asesoramos y enviamos material Online y escrito sobre todas las Normas y reglamentaciones de la DIGEMID.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-lg hover-card">
                    <div class="card-body text-center p-5">
                        <div class="icon-wrapper mb-4 rounded-circle p-3 d-inline-block">
                            <i class="fas fa-chart-line text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="card-title h3 mb-3 text-primary">Te ayudamos a Vender</h4>
                        <p class="card-text fs-5">Te proveemos de Cursos Virtuales, Ebooks, Guías, sobre Marketing, Ventas, Estudios de Mercado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de Entrega Rápida y Ofertas del Mes -->
<div class="fast-delivery-section py-5" style="background: linear-gradient(135deg, #f0f8ff 0%, #e6f2ff 100%);">
    <div class="container py-4">
        <div class="row align-items-center justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <div class="fast-delivery-content p-4 rounded-lg shadow-lg hover-lift">
                    <span class="badge bg-danger text-white px-3 py-2 rounded-pill mb-3 animate-pulse">¡ENTREGA RÁPIDA!</span>
                    <h2 class="fw-bold text-primary mb-3">En DRODIPHARMA, sabemos que tu tiempo es ORO...</h2>
                    <div class="divider mx-auto mb-4" style="width: 70px; height: 3px; background: linear-gradient(90deg, #dc3545, #ff6b81);"></div>
                    <p class="lead mb-4 fw-bold text-danger" style="font-size: 1.5rem;">Por eso tu pedido llega HOY MISMO</p>
                    <div class="delivery-icon mb-3">
                        <i class="fas fa-shipping-fast text-primary" style="font-size: 3rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Ofertas del Mes Actual -->
        @if(isset($ofertasDelMes) && count($ofertasDelMes) > 0)
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-4">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">OFERTAS ESPECIALES</span>
                <h2 class="fw-bold text-primary mb-3">Ofertas del Mes</h2>
                <div class="divider mx-auto mb-4" style="width: 70px; height: 3px; background: linear-gradient(90deg, #0d6efd, #0099ff);"></div>
            </div>
            
            <div class="col-12">
                <div class="ofertas-carousel">
                    <div class="ofertas-track">
                        @foreach($ofertasDelMes as $oferta)
                            <div class="oferta-item">
                                <div class="offer-card">
                                    <div class="card border-0 shadow-lg h-100">
                                        <div class="oferta-imagen-container">
                                            <img src="{{ asset($oferta->imagen) }}" class="oferta-imagen" alt="{{ $oferta->titulo }}">
                                        </div>
                                        <div class="card-body p-3 d-flex flex-column">
                                            <h5 class="card-title fw-bold text-primary mb-2">{{ $oferta->titulo }}</h5>
                                            <p class="card-text text-muted mb-2"><i class="fas fa-calendar-alt me-2"></i>{{ $oferta->created_at->format('d/m/Y') }}</p>
                                            <div class="mt-auto">
                                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill">¡OFERTA ESPECIAL!</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- Duplicamos las ofertas para crear un efecto de carrusel infinito -->
                        @foreach($ofertasDelMes as $oferta)
                            <div class="oferta-item">
                                <div class="offer-card">
                                    <div class="card border-0 shadow-lg h-100">
                                        <div class="oferta-imagen-container">
                                            <img src="{{ asset($oferta->imagen) }}" class="oferta-imagen" alt="{{ $oferta->titulo }}">
                                        </div>
                                        <div class="card-body p-3 d-flex flex-column">
                                            <h5 class="card-title fw-bold text-primary mb-2">{{ $oferta->titulo }}</h5>
                                            <p class="card-text text-muted mb-2"><i class="fas fa-calendar-alt me-2"></i>{{ $oferta->created_at->format('d/m/Y') }}</p>
                                            <div class="mt-auto">
                                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill">¡OFERTA ESPECIAL!</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="colaboradores-section py-5">
    <div class="container py-4">
        <div class="row text-center mb-5">
            <div class="col-12">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Nuestro Equipo</span>
                <h2 class="fw-bold text-primary mb-3">Colaboradores</h2>
                <div class="divider mx-auto mb-4" style="width: 70px; height: 3px; background-color: #0d6efd;"></div>
            </div>
        </div>
        <div class="colaboradores-carousel">
            <div class="colaboradores-track">
                @for($i = 1; $i <= 16; $i++)
                    <div class="colaborador-item">
                        <img src="{{ asset('imagesColaboradores/' . $i . '.png') }}" alt="Colaborador {{ $i }}" class="colaborador-img">
                    </div>
                @endfor
                @for($i = 1; $i <= 16; $i++)
                    <div class="colaborador-item">
                        <img src="{{ asset('imagesColaboradores/' . $i . '.png') }}" alt="Colaborador {{ $i }}" class="colaborador-img">
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<style>
    .colaboradores-section {
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .colaboradores-carousel {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
    }

    .colaboradores-track {
        display: flex;
        animation: scroll 40s linear infinite;
        width: calc(200px * 32); /* 16 imágenes * 2 para el loop */
    }

    .colaborador-item {
        flex: 0 0 200px;
        padding: 0 15px;
        perspective: 1000px;
    }

    .colaborador-img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        animation: rotate 5s linear infinite;
    }

    @keyframes scroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(calc(-200px * 16)); /* Ancho de una serie completa */
        }
    }   

</style>


<div class="blog-section py-5">
    <div class="container py-4">
        @if(count($blogs) > 0)
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Actualidad</span>
                    <h2 class="fw-bold text-primary mb-3">Últimas Novedades</h2>
                    <div class="divider mb-4" style="width: 70px; height: 3px; background-color: #0d6efd;"></div>
                    <p class="lead mb-4">Mantente informado sobre nuestros nuevos productos y artículos de salud en nuestro blog. Consejos de expertos para cuidar tu bienestar.</p>
                    <a href="{{ url('/blog') }}" class="btn btn-primary btn-lg shadow-sm"><i class="fas fa-book-medical me-2"></i>Visitar Blog</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset($blogs[0]['imagen']) }}" class="img-fluid rounded blog-img" alt="{{ $blogs[0]['titulo'] }}">
                </div>
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3">Actualidad</span>
                    <h2 class="fw-bold text-primary mb-3">Últimas Novedades</h2>
                    <div class="divider mx-auto mb-4" style="width: 70px; height: 3px; background-color: #0d6efd;"></div>
                    
                    <!-- Mensaje cuando no hay blogs -->
                    <div class="bg-light rounded-3 p-5 shadow-sm">
                        <div class="mb-4">
                            <i class="fas fa-book-medical text-primary" style="font-size: 3rem; opacity: 0.7;"></i>
                        </div>
                        <h4 class="text-muted mb-3">De momento no tenemos blogs que mostrarte</h4>
                        <p class="text-muted mb-4">Estamos trabajando en nuevos contenidos de salud y bienestar para ti.</p>
                        <a href="{{ url('/blog') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                            <i class="fas fa-book-medical me-2"></i>Visitar Blog
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="indecopi-section py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <!-- SVG de fondo decorativo -->
    <svg class="position-absolute" style="top: 0; left: 0; width: 100%; height: 100%; z-index: 0; opacity: 0.1;" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path fill="#0d6efd" d="M0,0 L100,0 L100,100 L0,100 Z" />
        <circle cx="20" cy="20" r="5" fill="#0d6efd" class="animate-float" />
        <path d="M50,30 L60,40 L40,40 Z" fill="#0d6efd" class="animate-float" />
        <rect x="70" y="60" width="10" height="10" fill="#0d6efd" class="animate-float" />
        <path d="M80,20 C85,15 90,20 85,25 C80,30 75,25 80,20 Z" fill="#0d6efd" class="animate-float" />
    </svg>
    
    <div class="container py-4 position-relative" style="z-index: 1;">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-7 mb-4 mb-md-0">
                <div class="indecopi-content p-4 rounded-lg shadow-lg hover-lift" style="background: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('{{ asset('images/indecopi.jpg') }}') no-repeat center center; background-size: cover; position: relative;">
                    <span class="badge bg-primary text-white px-3 py-2 rounded-pill mb-3 animate-badge">INDECOPI</span>
                    <h2 class="fw-bold text-primary mb-3">INDECOPI VIRTUAL</h2>
                    <div class="divider mx-auto mb-4" style="width: 70px; height: 3px; background: linear-gradient(90deg, #0d6efd, #0099ff);"></div>
                    <p class="lead mb-4 text-dark">Protege tus derechos y fomenta Justicia</p>
                    <p class="lead mb-4 fw-bold text-primary">Indecopi apoya a las Empresas</p>
                    <a href="https://reclamovirtual.pe/ingresar" target="_blank" class="btn btn-primary btn-lg px-4 py-2 shadow-sm hover-scale">
                        <i class="fas fa-shield-alt me-2"></i>Acceder a INDECOPI
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .indecopi-section {
            position: relative;
            overflow: hidden;
        }
        
        .indecopi-content {
            transition: all 0.3s ease;
            border-left: 5px solid #0d6efd;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
        }
        
        .hover-scale:hover {
            transform: scale(1.05);
        }
        
        .animate-badge {
            animation: pulse 2s infinite;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
            100% { transform: translateY(0) rotate(0deg); }
        }
    </style>
</div>

<!-- Agregar enlace a Font Awesome en la sección head -->
@section('extra_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@endsection
@endsection