@extends('layouts.app')

@push('styles')
<style>
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    .table-container {
        max-height: 600px;
        overflow-y: auto;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between mb-4">
                <div>
                    <div class="d-flex align-items-center">
                        <h2 class="mb-1 fw-bold text-dark">Métricas de Calidad de Blogs</h2>
                        <a href="{{ route('blog.metrics', ['export' => 1]) }}" class="btn btn-success btn-sm ms-3">
                            <i class="fas fa-file-excel me-1"></i> Exportar a Excel
                        </a>
                    </div>
                    <p class="text-muted mb-0">Análisis y seguimiento del rendimiento de contenido</p>
                </div>
                <div class="page-title-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light px-3 py-2 rounded-pill mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Inicio</a></li>
                            <li class="breadcrumb-item active text-primary fw-medium">Métricas de Blogs</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de resumen -->
    <div class="row g-3 mb-4">
        <div class="col-xxl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium small">Total de Mediciones</p>
                            <h2 class="mb-0 fw-bold text-primary display-6">{{ $metrics['total_mediciones'] }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-chart-bar text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-primary" style="height: 3px;"></div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium small">Promedio</p>
                            <h2 class="mb-0 fw-bold text-success display-6">{{ $metrics['promedio_valoracion'] }}<small class="text-muted fs-6">/100</small></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-star text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 3px;"></div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium small">Mejor</p>
                            <h2 class="mb-0 fw-bold text-success display-6">{{ $metrics['mejor_valoracion'] }}<small class="text-muted fs-6">/100</small></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-trophy text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-success" style="height: 3px;"></div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-2 fw-medium small">Peor</p>
                            <h2 class="mb-0 fw-bold text-danger display-6">{{ $metrics['peor_valoracion'] }}<small class="text-muted fs-6">/100</small></h2>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100 bg-danger" style="height: 3px;"></div>
            </div>
        </div>
    </div>

    <!-- Sección de gráfico y tabla en fila -->
    <div class="row g-4">
        <!-- Gráfico de distribución -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-chart-bar text-info"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 fw-bold text-dark">Distribución de Valoraciones</h5>
                            <p class="text-muted mb-0 small">Gráfico de distribución de valoraciones</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 chart-container">
                    <canvas id="valoracionesChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Tabla de mediciones recientes -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="fas fa-list text-info"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0 fw-bold text-dark">Mediciones Recientes</h5>
                            <p class="text-muted mb-0 small">Últimas evaluaciones realizadas</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 table-container">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-muted fw-semibold py-3 px-4">ID</th>
                                    <th class="border-0 text-muted fw-semibold py-3">Título</th>
                                    <th class="border-0 text-muted fw-semibold py-3 text-center">Valoración</th>
                                    <th class="border-0 text-muted fw-semibold py-3">Recomendación</th>
                                    <th class="border-0 text-muted fw-semibold py-3">Trabajador</th>
                                    <th class="border-0 text-muted fw-semibold py-3">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($metrics['mediciones_recientes'] as $medicion)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        <span class="fw-semibold text-primary">#{{ $medicion->id }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-medium text-dark">{{ Str::limit($medicion->titulo, 40) }}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-{{ 
                                            $medicion->valoracion >= 70 ? 'success' : 
                                            ($medicion->valoracion >= 40 ? 'warning' : 'danger') 
                                        }} px-3 py-2 rounded-pill fw-medium">
                                            {{ $medicion->valoracion }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted">{{ Str::limit($medicion->recomendacion, 50) }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-medium">{{ $medicion->trabajador->nombre_completo ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted small">{{ $medicion->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                            <p class="mb-0">No hay mediciones registradas</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos para el gráfico de distribución
        const ctx = document.getElementById('valoracionesChart').getContext('2d');
        
        // Crear el gráfico de distribución
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['0-19', '20-39', '40-59', '60-79', '80-100'],
                datasets: [{
                    label: 'Número de Blogs',
                    data: [
                        {{ $metrics['distribucion_valoraciones'][0] ?? 0 }},
                        {{ $metrics['distribucion_valoraciones'][1] ?? 0 }},
                        {{ $metrics['distribucion_valoraciones'][2] ?? 0 }},
                        {{ $metrics['distribucion_valoraciones'][3] ?? 0 }},
                        {{ $metrics['distribucion_valoraciones'][4] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(253, 126, 20, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(13, 202, 240, 0.8)',
                        'rgba(25, 135, 84, 0.8)'
                    ],
                    borderColor: [
                        'rgba(220, 53, 69, 1)',
                        'rgba(253, 126, 20, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(13, 202, 240, 1)',
                        'rgba(25, 135, 84, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#dee2e6',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c757d',
                            font: {
                                weight: '500'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 1,
                            color: '#6c757d',
                            font: {
                                weight: '500'
                            }
                        }
                    }
                },
                elements: {
                    bar: {
                        borderWidth: 2
                    }
                }
            }
        });
    });

    // Ajustar el tamaño del gráfico cuando se redimensione la ventana
    window.addEventListener('resize', function() {
        if (window.myChart) {
            window.myChart.resize();
        }
    });
</script>
@endpush
@endsection