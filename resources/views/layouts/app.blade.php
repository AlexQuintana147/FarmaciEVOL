<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DrodiPharma') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #5cb85c;
            --accent-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --medical-blue: #4a89dc;
            --medical-green: #37bc9b;
            --medical-light-blue: #e8f4fd;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafc;
        }
        /* Header Styles */
        .navbar {
            box-shadow: 0 2px 15px rgba(0,0,0,.08);
            transition: all 0.3s ease;
            background-color: white !important;
            padding: 0.8rem 1rem;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--medical-blue);
            font-size: 1.6rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        .navbar-brand i {
            color: var(--medical-green);
            margin-right: 8px;
            font-size: 1.8rem;
        }
        .navbar-brand:hover {
            color: var(--primary-color);
            transform: translateY(-2px);
        }
        .nav-link {
            font-weight: 500;
            padding: 0.7rem 1.2rem;
            transition: all 0.3s ease;
            position: relative;
            color: var(--dark-color);
        }
        .nav-link:hover {
            color: var(--medical-blue);
        }
        .nav-link.active {
            color: var(--medical-blue);
            font-weight: 600;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background-color: var(--medical-blue);
            border-radius: 5px;
        }
        .hero-section {
            background-color: var(--medical-light-blue);
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }
        /* Floating medical elements */
        .floating-icon {
            position: absolute;
            opacity: 0.15;
            font-size: 2.5rem;
            color: var(--medical-blue);
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #2b3c5a 0%, #374f77 100%);
            color: #f8f9fa;
            padding: 4rem 0 2rem;
            position: relative;
            overflow: hidden;
        }
        .footer h5 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        .footer h5::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--medical-green);
            border-radius: 3px;
        }
        .footer a {
            color: #f8f9fa;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .footer a:hover {
            color: var(--medical-green);
            transform: translateX(5px);
        }
        .footer address p {
            margin-bottom: 0.5rem;
            font-style: normal;
        }
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .social-links a:hover {
            background-color: var(--medical-green);
            color: #ffffff;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .footer-links li {
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }
        .footer-links li:hover {
            transform: translateX(5px);
        }
        .footer-links a i {
            font-size: 0.75rem;
            color: var(--medical-green);
        }
        .footer-contact li {
            display: flex;
            align-items: start;
            margin-bottom: 1rem;
        }
        .footer-contact li i {
            margin-top: 0.25rem;
            margin-right: 10px;
            color: var(--medical-green);
            font-size: 1.1rem;
        }
        .footer hr {
            opacity: 0.1;
            margin: 2rem 0;
        }
        /* Estilos de paginación */
        .pagination {
            margin: 0;
            gap: 5px;
        }
        .page-link {
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
            color: #0d6efd;
            background-color: #fff;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }
        .page-link:hover {
            background-color: #e9ecef;
            border-color: #0d6efd;
            color: #0a58ca;
        }
        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }
        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
        /* Chatbot Bubble Styles */
        #chatbot-bubble {
            position: fixed;
            bottom: 32px;
            right: 32px;
            z-index: 9999;
            background: linear-gradient(135deg, #4f8cff 0%, #38e7b8 100%);
            border-radius: 50px 50px 16px 50px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.18);
            color: #fff;
            padding: 18px 28px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: box-shadow 0.2s;
        }
        #chatbot-bubble:hover {
            box-shadow: 0 12px 32px rgba(0,0,0,0.23);
        }
        #chatbot-bubble .chatbot-icon {
            width: 32px;
            height: 32px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }
        #chatbot-bubble .chatbot-icon svg {
            width: 20px;
            height: 20px;
            color: #4f8cff;
        }
        @media (max-width: 600px) {
            #chatbot-bubble {
                bottom: 16px;
                right: 16px;
                padding: 14px 20px;
                font-size: 1rem;
            }
            #chatbot-chatbox {
                width: 98vw !important;
                right: 1vw !important;
                bottom: 70px !important;
                max-height: 80vh !important;
                min-height: 220px !important;
            }
        }
        /* Chatbot Chatbox Styles */
        #chatbot-chatbox {
            display: none;
            position: fixed;
            bottom: 90px;
            right: 40px;
            width: 380px;
            max-width: 98vw;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            z-index: 10000;
            flex-direction: column;
            overflow: hidden;
            max-height: 650px;
            min-height: 380px;
            opacity: 0;
            transform: translateY(30px);
            pointer-events: none;
            transition: opacity 0.28s cubic-bezier(.4,0,.2,1), transform 0.28s cubic-bezier(.4,0,.2,1);
        }
        #chatbot-chatbox.open {
            display: flex;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }
        #chatbot-chatbox.closing {
            opacity: 0;
            transform: translateY(30px);
            pointer-events: none;
            transition: opacity 0.22s cubic-bezier(.4,0,.2,1), transform 0.22s cubic-bezier(.4,0,.2,1);
        }
        #chatbot-chatbox-header {
            background: linear-gradient(135deg, #4f8cff 0%, #38e7b8 100%);
            color: #fff;
            padding: 14px 20px;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        #chatbot-chatbox-close {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.3rem;
            cursor: pointer;
        }
        #chatbot-chatbox-body {
            padding: 16px;
            background: #f6f8fa;
            flex: 1 1 auto;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .typing-indicator {
            display: none;
            padding: 8px 15px;
            background: #e9f7fb;
            border-radius: 16px 16px 16px 4px;
            margin-bottom: 10px;
            width: fit-content;
            align-self: flex-start;
            order: 999;
        }
        .typing-indicator.active {
            display: flex;
            align-items: center;
        }
        .typing-indicator span {
            height: 8px;
            width: 8px;
            background: #4f8cff;
            border-radius: 50%;
            margin: 0 2px;
            display: inline-block;
            animation: bounce 1.4s infinite ease-in-out;
        }
        .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
        .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-8px); }
        }
        .chatbot-message {
            display: flex;
            margin-bottom: 2px;
        }
        .chatbot-message.user {
            justify-content: flex-end;
        }
        .chatbot-message.bot {
            justify-content: flex-start;
        }
        .chatbot-bubble-text {
            background: #4f8cff;
            color: #fff;
            border-radius: 16px 16px 4px 16px;
            padding: 8px 15px;
            max-width: 75%;
            font-size: 1rem;
            word-break: break-word;
        }
        .chatbot-message.bot .chatbot-bubble-text {
            background: #e9f7fb;
            color: #222;
            border-radius: 16px 16px 16px 4px;
        }
        #chatbot-chatbox-footer {
            display: flex;
            padding: 10px 16px;
            border-top: 1px solid #e0e0e0;
            background: #fff;
        }
        #chatbot-input {
            flex: 1 1 auto;
            border: none;
            outline: none;
            padding: 8px 12px;
            border-radius: 12px;
            background: #f0f3f7;
            font-size: 1rem;
            margin-right: 8px;
        }
        #chatbot-send-btn {
            background: linear-gradient(135deg, #4f8cff 0%, #38e7b8 100%);
            border: none;
            color: #fff;
            border-radius: 12px;
            padding: 8px 18px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        #chatbot-send-btn:active {
            background: #4f8cff;
        }
    </style>

    <!-- Font Awesome y Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @yield('extra_css')
    @stack('scripts')
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="DrodiPharma Logo" style="height: 42px; width: auto;">
                    <span class="ms-2 fw-bold" style="font-size: 1.5rem; color: var(--medical-blue);">DrodiPharma</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-home me-1"></i> Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('productos*') ? 'active' : '' }}" href="{{ url('/productos') }}">
                                <i class="fas fa-pills me-1"></i> Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ url('/blog') }}">
                                <i class="fas fa-book-medical me-1"></i> Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('nosotros*')? 'active' : '' }}" href="{{ url('/nosotros') }}">
                                <i class="fas fa-users me-1"></i> Sobre Nosotros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('farmacovigilancia*')? 'active' : '' }}" href="{{ url('/farmacovigilancia') }}">
                                <i class="fas fa-pills me-1"></i> Farmacovigilancia
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        @if (Auth::guard('trabajador')->check())
                            <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">
                                <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer mt-5">
        <!-- Elementos decorativos médicos flotantes -->
        <div class="floating-icon" style="top: 15%; left: 10%;"><i class="fas fa-capsules"></i></div>
        <div class="floating-icon" style="top: 25%; right: 15%;"><i class="fas fa-prescription-bottle-alt"></i></div>
        <div class="floating-icon" style="bottom: 20%; left: 20%;"><i class="fas fa-heartbeat"></i></div>
        <div class="floating-icon" style="bottom: 30%; right: 10%;"><i class="fas fa-first-aid"></i></div>
        
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="DrodiPharma Logo" style="height: 36px; width: auto;">
                        DrodiPharma
                    </h5>
                    <p class="mb-4">Comprometidos con tu salud y bienestar desde 2023. Ofrecemos productos farmacéuticos de la más alta calidad con atención personalizada.</p>
                    <div class="social-links">
                        <a href="https://www.facebook.com/drodipharm/" class="me-3" target="_blank" rel="noopener noreferrer" style="color: inherit;"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.instagram.com/drodipharma/" class="me-3" target="_blank" rel="noopener noreferrer" style="color: inherit;"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url('/') }}" style="color: inherit;"><i class="fas fa-chevron-right me-2"></i>Inicio</a></li>
                        <li><a href="{{ url('/productos') }}" style="color: inherit;"><i class="fas fa-chevron-right me-2"></i>Productos</a></li>
                        <li><a href="{{ url('/blog') }}" style="color: inherit;"><i class="fas fa-chevron-right me-2"></i>Blog de Salud</a></li>
                        <li><a href="{{ url('/nosotros') }}" style="color: inherit;"><i class="fas fa-chevron-right me-2"></i>Nosotros</a></li>
                        <li><a href="{{ url('/farmacovigilancia') }}" style="color: inherit;"><i class="fas fa-chevron-right me-2"></i>Farmacovigilancia</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5>Información de Contacto</h5>
                    <ul class="list-unstyled footer-contact">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <div>
                                <a href="https://maps.google.com/?q=Cal.+San+Pablo+Nro.+339,+San+Andres+Et.+3,+Trujillo,+Peru" target="_blank" class="text-white text-decoration-none" style="border-bottom: 1px dotted rgba(255,255,255,0.5);">
                                    Cal. San Pablo Nro. 339, San Andres Et. 3, Trujillo
                                </a>
                            </div>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            <div>
                                <a href="mailto:contacto@drodipharma.com.pe" class="text-white">contacto@drodipharma.com.pe</a>
                            </div>
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            <div>
                                <a href="tel:+51967692437" class="text-white">+51 967 692 437</a>
                            </div>
                        </li>
                        <li class="mb-3"> 
                            <i class="fas fa-clock me-2"></i>
                            <div>Lun - Sáb: 8:00 AM - 8:00 PM</div>
                        </li>
                        <li class="mb-3"> 
                            <i class="fas fa-clock me-2"></i>
                            <div>Dom: 8:00 AM - 12:00 PM</div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="mt-4 mb-3 border-light">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; {{ date('Y') }} DrodiPharma. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white-50 me-3">Términos y Condiciones</a>
                    <a href="#" class="text-white-50">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chatbot Button -->
    <div id="chatbot-bubble" onclick="document.getElementById('chatbot-chatbox').classList.add('open')">
        <i class="fa-solid fa-comment-dots"></i>
        <span>¿Necesitas ayuda?</span>
    </div>

    <!-- Chatbot Chatbox -->
    <div id="chatbot-chatbox">
        <div id="chatbot-chatbox-header">
            <span>Asistente Virtual</span>
            <button id="chatbot-chatbox-close" title="Cerrar">&times;</button>
        </div>
        <div id="chatbot-chatbox-body">
            <div class="chatbot-message bot">
                <div class="chatbot-bubble-text">¡Hola! Soy el asistente virtual de DrodiPharma. ¿En qué puedo ayudarte?</div>
            </div>
        </div>
        <div id="chatbot-chatbox-footer">
            <input type="text" id="chatbot-input" placeholder="Escribe tu mensaje..." autocomplete="off" />
            <button id="chatbot-send-btn">Enviar</button>
        </div>
    </div>

    

    <style>
        .metrics-dashboard {
            background-color: #f8f9fa;
        }
        .metrics-title {
            color: #2c3e50;
            font-weight: 600;
        }
        .metric-card {
            transition: transform 0.2s;
        }
        .metric-card:hover {
            transform: translateY(-5px);
        }
        .metric-value {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
        }
        .metric-label {
            font-size: 0.9rem;
        }
        .metric-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        .table th {
            font-weight: 600;
            font-size: 0.9rem;
        }
        .table td {
            font-size: 0.9rem;
        }

        .chatbot-bubble-text {
            white-space: pre-wrap; /* Mantiene los saltos de línea */
        }

        .chatbot-bubble-text strong {
            font-weight: bold;
            color: #2c3e50;
        }

        .emoji {
            font-size: 1.2em;
            margin: 0 2px;
        }

        .chatbot-bubble-text br {
            display: block;
            content: "";
            margin-top: 5px;
        }
    </style>
    <!-- Scripts del chatbot -->
    <script src="{{ asset('js/chatbot.js') }}"></script>
    
    <script src="//unpkg.com/alpinejs" defer></script>
        @if (session()->has('success') || session()->has('error') || session()->has('warning'))
        <div
            x-data="{ show: true, type: '{{ session()->has('success') ? 'success' : (session()->has('error') ? 'error' : 'warning') }}', message: '{{ session('success') ?? session('error') ?? session('warning') }}' }"
            x-show="show"
            x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-full"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-full"
            class="fixed bottom-4 right-4 z-50 p-4 rounded-lg shadow-xl text-white max-w-sm"
            :class="{
                'bg-green-500': type === 'success',
                'bg-red-500': type === 'error',
                'bg-yellow-500': type === 'warning',
            }"
            role="alert"
        >
            <div class="flex justify-between items-center">
                <p x-text="message" class="mr-4"></p>
                <button @click="show = false" class="text-white hover:text-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
        @endif
        
    @vite('resources/js/app.js')
</body>
</html>