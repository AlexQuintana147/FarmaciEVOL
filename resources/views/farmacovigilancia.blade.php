@extends('layouts.app')
@section('title', 'Farmacovigilancia')

@section('content')
<!-- Hero Section Mejorado -->
<div class="hero-section py-5 mb-5 position-relative" style="background: linear-gradient(120deg, #e8f4fd 0%, #f0f9ff 100%); overflow:hidden;">
    <!-- Iconos médicos decorativos -->
    <i class="fas fa-capsules position-absolute" style="left: 2%; top: 10%; font-size: 2.5rem; color: #cbeafe; opacity: 0.5;"></i>
    <i class="fas fa-heartbeat position-absolute" style="right: 5%; top: 30%; font-size: 2.7rem; color: #b6e0fe; opacity: 0.5;"></i>
    <i class="fas fa-prescription-bottle-alt position-absolute" style="left: 10%; bottom: 10%; font-size: 2.2rem; color: #d1eaff; opacity: 0.5;"></i>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3 text-primary">Farmacovigilancia</h1>
                <p class="lead mb-4">La farmacovigilancia es la ciencia y las actividades relacionadas con la detección, evaluación, comprensión y prevención de los efectos adversos de los medicamentos o cualquier otro problema relacionado con ellos.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Monitoreo continuo de la seguridad de los medicamentos</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Identificación temprana de reacciones adversas</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Evaluación de la relación beneficio-riesgo de los medicamentos</li>
                </ul>
                <a href="https://api.whatsapp.com/send/?phone=51967692437&text=Quiero+reportar+un+evento+adverso" target="_blank" class="btn btn-lg btn-primary shadow-sm px-4 py-2"><i class="fas fa-flag me-2"></i>Reportar Evento Adverso</a>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://scrconsultores.com.pe/wp-content/uploads/2022/01/FAMRACO1.jpg" alt="Farmacovigilancia" class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>
    </div>
</div>

<!-- ¿Qué es la Farmacovigilancia? Mejorado -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="bg-primary bg-opacity-10 rounded-4 p-4 shadow-sm h-100 d-flex justify-content-center">
                    <img src="https://www.novartis.com/acc-es/sites/novartis_candean/files/styles/banner_full_width_image_mobile_portrait/public/2025-02/holding-pill-bottles-v2.jpg.webp?itok=qVIkWFV2" alt="Monitoreo de Medicamentos" class="img-fluid rounded-3">
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="mb-3 text-primary"><i class="fas fa-exclamation-triangle me-2"></i>¿Qué es un evento adverso (EA)?</h2>
                <p class="text-muted mb-4">Es cualquier suceso que puede presentarse durante el uso de un producto farmacéutico. También puede referirse a una condición médica indeseada (enfermedad, síntoma, signo o resultado anormal de laboratorio), pero no tiene necesariamente una relación causal con dicho uso.</p>
                <div class="alert alert-warning bg-warning bg-opacity-25 border-0 rounded-3">
                    <i class="fas fa-info-circle me-2"></i>Si experimenta un evento adverso, repórtelo de inmediato para proteger su salud y la de otros pacientes.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Proceso de Reporte Mejorado -->
<section class="py-5 bg-light position-relative">
    <div class="container">
        <h2 class="text-center mb-5 text-primary">¿Cómo reportar un evento adverso?</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3">
                            <span class="badge bg-primary bg-opacity-75 rounded-circle mb-2" style="font-size:1.1rem;">1</span>
                            <i class="fas fa-pills fa-2x text-primary ms-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Detecta el evento</h5>
                        <p class="text-muted small">Identifica cualquier síntoma, reacción o situación inesperada tras el uso de un medicamento.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3">
                            <span class="badge bg-primary bg-opacity-75 rounded-circle mb-2" style="font-size:1.1rem;">2</span>
                            <i class="fas fa-clipboard-list fa-2x text-primary ms-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Registra la información</h5>
                        <p class="text-muted small">Anota los detalles: medicamento, síntomas, fecha y datos relevantes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="d-inline-block p-3 bg-primary bg-opacity-10 rounded-circle mb-3">
                            <span class="badge bg-primary bg-opacity-75 rounded-circle mb-2" style="font-size:1.1rem;">3</span>
                            <i class="fas fa-file-medical-alt fa-2x text-primary ms-2"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Reporta el evento</h5>
                        <p class="text-muted small">Comunícate con nuestro equipo usando el botón de reporte o por WhatsApp.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <a href="https://api.whatsapp.com/send/?phone=51967692437&text=Quiero+reportar+un+evento+adverso" target="_blank" class="btn btn-success btn-lg px-4 py-2 shadow"><i class="fab fa-whatsapp me-2"></i>Reportar por WhatsApp</a>
        </div>
    </div>
    <!-- Fondo decorativo -->
    <i class="fas fa-shield-virus position-absolute" style="right: 2%; bottom: 10%; font-size: 3rem; color: #b6e0fe; opacity: 0.4;"></i>
</section>

<!-- Importancia de la Farmacovigilancia -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-3 text-primary"><i class="fas fa-shield-alt me-2"></i>Importancia de la Farmacovigilancia</h2>
                <p class="text-muted mb-4">La farmacovigilancia es fundamental para garantizar la seguridad de los medicamentos a lo largo de todo su ciclo de vida. Aunque los medicamentos pasan por rigurosos ensayos clínicos antes de su comercialización, estos estudios tienen limitaciones:</p>
                <ul class="list-group list-group-flush mb-4">
                    <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-2"></i> Se realizan en poblaciones pequeñas y homogéneas</li>
                    <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-2"></i> Tienen una duración limitada</li>
                    <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-2"></i> No pueden detectar reacciones adversas poco frecuentes</li>
                    <li class="list-group-item bg-transparent"><i class="fas fa-check-circle text-success me-2"></i> No reflejan todas las condiciones de uso real</li>
                </ul>
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-3">
                    <i class="fas fa-info-circle me-2"></i>Cada reporte de evento adverso contribuye a mejorar el perfil de seguridad de los medicamentos y proteger la salud pública.
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-light rounded-4 p-4 shadow-sm">
                    <img src="https://img.freepik.com/foto-gratis/farmaceutico-tomando-medicina-estante-farmacia_107420-75206.jpg" alt="Importancia de la Farmacovigilancia" class="img-fluid rounded-3 shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tipos de Eventos Adversos -->
<section class="py-5 bg-light position-relative">
    <!-- Iconos decorativos -->
    <i class="fas fa-tablets position-absolute" style="left: 3%; top: 15%; font-size: 2.2rem; color: #cbeafe; opacity: 0.5;"></i>
    <i class="fas fa-notes-medical position-absolute" style="right: 5%; top: 25%; font-size: 2.5rem; color: #b6e0fe; opacity: 0.5;"></i>
    <div class="container">
        <h2 class="text-center mb-5 text-primary"><i class="fas fa-exclamation-circle me-2"></i>Tipos de Eventos Adversos</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <img src="https://img.freepik.com/foto-gratis/primer-plano-medico-escribiendo-receta_23-2148320558.jpg" alt="Reacciones Adversas" class="img-fluid rounded-3 mb-3" style="height: 180px; object-fit: cover;">
                            <h5 class="fw-bold">Reacciones Adversas a Medicamentos (RAM)</h5>
                        </div>
                        <p class="text-muted">Respuestas nocivas e involuntarias que ocurren a dosis normalmente utilizadas en el ser humano para la profilaxis, diagnóstico o tratamiento de enfermedades.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <img src="https://img.freepik.com/foto-gratis/farmaceutico-tomando-medicina-estante-farmacia_107420-75207.jpg" alt="Errores de Medicación" class="img-fluid rounded-3 mb-3" style="height: 180px; object-fit: cover;">
                            <h5 class="fw-bold">Errores de Medicación</h5>
                        </div>
                        <p class="text-muted">Incidentes prevenibles que pueden causar daño al paciente o dar lugar a una utilización inapropiada de los medicamentos cuando están bajo el control de profesionales sanitarios o del paciente.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <img src="https://img.freepik.com/foto-gratis/farmaceutico-verificando-medicamentos-farmacia_107420-75205.jpg" alt="Falta de Eficacia" class="img-fluid rounded-3 mb-3" style="height: 180px; object-fit: cover;">
                            <h5 class="fw-bold">Falta de Eficacia</h5>
                        </div>
                        <p class="text-muted">Ausencia, disminución o cambios en el efecto terapéutico que cabría esperar de un medicamento, según las condiciones adecuadas de uso.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Preguntas Frecuentes -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5 text-primary"><i class="fas fa-question-circle me-2"></i>Preguntas Frecuentes</h2>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <!-- Pregunta 1 -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fas fa-question-circle text-primary me-2"></i> ¿Quién puede reportar un evento adverso?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light bg-opacity-50">
                                <p>Cualquier persona puede reportar un evento adverso, incluyendo:</p>
                                <ul>
                                    <li>Pacientes o sus familiares</li>
                                    <li>Profesionales de la salud (médicos, enfermeras, farmacéuticos)</li>
                                    <li>Establecimientos de salud</li>
                                    <li>Laboratorios farmacéuticos</li>
                                </ul>
                                <p class="mb-0">No es necesario estar seguro de que un medicamento causó el evento para reportarlo.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pregunta 2 -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fas fa-question-circle text-primary me-2"></i> ¿Qué información debo incluir al reportar?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light bg-opacity-50">
                                <p>Para un reporte efectivo, incluya la siguiente información:</p>
                                <ul>
                                    <li><strong>Sobre el paciente:</strong> edad, sexo, peso (si es relevante)</li>
                                    <li><strong>Sobre el medicamento:</strong> nombre, dosis, vía de administración, fecha de inicio y fin</li>
                                    <li><strong>Sobre el evento adverso:</strong> descripción, fecha de inicio, duración, desenlace</li>
                                    <li><strong>Información adicional:</strong> enfermedades concomitantes, otros medicamentos, factores relevantes</li>
                                </ul>
                                <p class="mb-0">Incluso si no dispone de toda esta información, es importante reportar con los datos que tenga disponibles.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pregunta 3 -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="fas fa-question-circle text-primary me-2"></i> ¿Qué sucede después de reportar un evento adverso?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light bg-opacity-50">
                                <p>Después de recibir su reporte:</p>
                                <ol>
                                    <li>Nuestro equipo de farmacovigilancia evaluará la información proporcionada</li>
                                    <li>Se analizará la posible relación causal entre el medicamento y el evento adverso</li>
                                    <li>La información se registrará en nuestra base de datos</li>
                                    <li>En casos graves o inesperados, se notificará a las autoridades sanitarias</li>
                                    <li>Se implementarán medidas de seguimiento si es necesario</li>
                                </ol>
                                <p class="mb-0">Su reporte contribuye a la seguridad de los medicamentos y puede ayudar a proteger a otros pacientes.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <img src="https://img.freepik.com/foto-gratis/farmaceutico-cliente-hablando-medicamentos_107420-75163.jpg" alt="Consulta Farmacéutica" class="img-fluid rounded-4 shadow" style="max-width: 500px;">
        </div>
    </div>
</section>

@endsection