@extends('layouts.app')
@section('title', 'Sobre Nosotros')

@section('content')
<!-- Hero Section with Parallax Effect -->
<div class="hero-section py-5 mb-5 position-relative overflow-hidden">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4 text-primary">Sobre DrodiPharma</h1>
                <p class="lead mb-4 text-dark">Desde nuestra fundación, nos hemos comprometido a ofrecer un servicio confiable, rápido y eficiente, asegurando el suministro oportuno de los productos.</p>
                <p class="lead mb-4 text-dark">Nuestra misión es brindar a nuestros clientes una experiencia de compra superior, con atención personalizada, precios competitivos y asesoramiento integral en la gestión de sus farmacias y boticas.</p>
            </div>
            <div class="col-lg-6 text-center" data-aos="fade-left">
                <img src="{{ asset('images/bannerInicio.jpg') }}" alt="Equipo DrodiPharma" class="img-fluid shadow-lg" style="max-width: 80%;">
            </div>
        </div>
    </div>
</div>

<!-- Misión y Visión Section with Hover Effects -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up">
                <div class="card h-100 border-0 shadow-sm transition-hover" style="transition: transform 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3 rotate-on-hover" style="transition: transform 0.3s ease;">
                            <i class="fas fa-bullseye fa-2x text-primary"></i>
                        </div>
                        <h3 class="h4 mb-3 text-primary">Nuestra Misión</h3>
                        <p class="text-muted mb-0">Proporcionar servicios farmacéuticos de excelencia y productos de calidad, contribuyendo al bienestar y la salud de nuestra comunidad a través de una atención profesional y personalizada.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm transition-hover" style="transition: transform 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3 rotate-on-hover" style="transition: transform 0.3s ease;">
                            <i class="fas fa-eye fa-2x text-primary"></i>
                        </div>
                        <h3 class="h4 mb-3 text-primary">Nuestra Visión</h3>
                        <p class="text-muted mb-0">Nos proyectamos como la distribuidora de medicamentos de referencia en el norte y centro del Perú, destacándonos por la calidad de nuestros productos, la eficiencia de nuestro servicio y la confianza de nuestros clientes.</p>
                        <p class="text-muted mb-0">Buscamos innovar constantemente para adaptarnos a las necesidades del sector farmacéutico y ser un aliado estratégico en el crecimiento de nuestros clientes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Valores Section with Animation -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5 text-primary" data-aos="fade-up">Nuestros Valores</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 col-lg-3" data-aos="fade-up">
                <div class="text-center p-4 rounded-3 bg-white shadow-sm h-100 transition-hover" style="transition: transform 0.3s ease;">
                    <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3 rotate-on-hover">
                        <i class="fas fa-heart fa-2x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3 text-primary">Compromiso</h4>
                    <p class="text-muted mb-0">Entregamos productos de calidad con un servicio de primer nivel.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center p-4 rounded-3 bg-white shadow-sm h-100 transition-hover" style="transition: transform 0.3s ease;">
                    <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3 rotate-on-hover">
                        <i class="fas fa-check-double fa-2x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3 text-primary">Responsabilidad</h4>
                    <p class="text-muted mb-0">Cumplimos con las regulaciones sanitarias y garantizamos la trazabilidad de cada medicamento.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4 rounded-3 bg-white shadow-sm h-100 transition-hover" style="transition: transform 0.3s ease;">
                    <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3 rotate-on-hover">
                        <i class="fas fa-user-md fa-2x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3 text-primary">Ética y Transparencia</h4>
                    <p class="text-muted mb-0">Construimos relaciones basadas en la confianza y la honestidad.</p>
                </div>
            </div>
            <div class="col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center p-4 rounded-3 bg-white shadow-sm h-100 transition-hover" style="transition: transform 0.3s ease;">
                    <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3 rotate-on-hover">
                        <i class="fas fa-lightbulb fa-2x text-primary"></i>
                    </div>
                    <h4 class="h5 mb-3 text-primary">Innovación</h4>
                    <p class="text-muted mb-0">Nos adaptamos a los cambios del mercado con tecnología y estrategias modernas de distribución.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Compromiso Section with Gradient Background -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" data-aos="fade-up">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h3 class="h4 mb-4 text-primary text-center">Nuestro Compromiso con los Clientes</h3>
                        <p class="text-muted mb-0">En DRODIPHARMA, entendemos que el éxito de una botica o farmacia depende de un abastecimiento confiable y oportuno. Por ello, nos aseguramos de proporcionar un servicio ágil, con productos de calidad y un equipo comprometido en ayudarte a optimizar tu negocio. Nuestro objetivo es ser más que un proveedor, queremos ser tu socio estratégico en el crecimiento de tu farmacia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add custom styles for animations -->
<style>
.transition-hover {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.transition-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(74, 137, 220, 0.15);
}

.transition-hover::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #4a89dc, #5ca9fb);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.transition-hover:hover::after {
    transform: scaleX(1);
}

.rotate-on-hover {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.rotate-on-hover:hover {
    transform: rotate(360deg);
    background: linear-gradient(135deg, rgba(74, 137, 220, 0.2), rgba(92, 169, 251, 0.2));
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-section {
    position: relative;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('{{ asset('images/pharmacy-pattern.svg') }}') repeat;
    opacity: 0.05;
    z-index: 1;
}
</style>

@endsection