@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Talleres'])
<div class="container-fluid py-4">
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-header pb-2">
                <h5 class="mb-0">Datos de Talleres</h5>
            </div>
            <div class="card-body py-2">
                <form method="GET" action="{{ route('datos-talleres.index') }}">
                    <div class="row align-items-end gx-3 gy-3">
                        <!-- Selector de Taller -->
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-lg-1">
                            <label class="form-label text-uppercase font-weight-bold text-sm">Taller</label>
                            <select class="form-control" name="taller_id">
                                <option value="">Todos los talleres</option>
                                @foreach($talleres as $taller)
                                    <option value="{{ $taller->id_taller }}" {{ request('taller_id', $tallerId) == $taller->id_taller ? 'selected' : '' }}>
                                        {{ $taller->nombre_taller }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Mes -->
                        <div class="col-sm-6 col-md-3 col-lg-2 mb-lg-1">
                            <label class="form-label text-uppercase font-weight-bold text-sm">Mes</label>
                            <select class="form-control" name="mes">
                                @foreach(range(1,12) as $m)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $mes == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ ucfirst(\Carbon\Carbon::create()->month($m)->locale('es')->monthName) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Año -->
                        <div class="col-sm-6 col-md-3 col-lg-2 mb-lg-1">
                            <label class="form-label text-uppercase font-weight-bold text-sm">Año</label>
                            <select class="form-control" name="anio">
                                @foreach($anios as $a)
                                    <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 col-lg d-flex flex-wrap align-items-center gap-2 mt-3">
                            <!-- Botones izquierda -->
                            <div class="d-flex flex-wrap gap-2 me-auto">
                                <a href="{{ route('datos-talleres.export', ['taller_id' => request('taller_id'), 'mes' => request('mes'), 'anio' => request('anio')]) }}" 
                                   class="btn custom-excel-btn custom-btn mb-1">
                                   Exportar a Excel
                                </a>
                            </div>

                            <!-- Botón derecha -->
                            <a href="{{ route('talleres.index') }}" class="btn btn-secondary mb-1">Ir a talleres</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Métricas y gráficos principales -->
    <div class="row">
        <!-- Métrica: Asistentes del Mes -->
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card mb-4">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Asistencias del Mes</p>
                                <h5 class="font-weight-bolder">
                                    {{ $asistentesMes }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Gráfico de curva: Asistentes totales vs mes -->
            <div class="card mb-4">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">asistencias por día del mes</h6>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-curva" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
            <!-- Asistentes por carrera -->
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Asistencias por Carrera</h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center">
                        <thead>
                            <tr>
                                <th>UA</th>
                                <th>Carrera</th>
                                <th class="text-center">Asistentes</th>
                                <th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rankingCarreras as $carrera)
                                <tr>
                                    <td class="text-sm">{{ $carrera['ua'] }}</td>
                                    <td class="text-sm text-truncate" style="max-width: 180px;"
                                        title="{{ $carrera['carrera'] }}">
                                        {{ $carrera['carrera'] }}
                                    </td>
                                    <td class="text-center text-sm"><strong>{{ $carrera['cantidad'] }}</strong></td>
                                    <td class="text-center text-sm">{{ $carrera['porcentaje'] }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay datos disponibles.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Métrica: Asistencias esta semana + gráfico de género -->
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card mb-4">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Asistencias esta semana</p>
                                <h5 class="font-weight-bolder">
                                    {{ $asistenciasSemana }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Gráfico de barras: Asistentes por género -->
            <div class="card z-index-2 mb-4">
                <div class="card-header pb-0 pt-3">
                    <div class="row w-100">
                        <!-- Título y porcentajes: siempre arriba -->
                        <div class="col-12 col-lg-6 d-flex flex-column justify-content-center">
                            <h6 class="text-capitalize mb-0">asistencias por género</h6>
                            <p class="text-sm mb-0">
                                Femenino: <span class="font-weight-bold text-pink">{{ $porcentajeF }}%</span> /
                                Masculino: <span class="font-weight-bold text-primary">{{ $porcentajeM }}%</span>
                            </p>
                        </div>
                        <!-- Opciones de gráfico: a la derecha en lg, abajo en sm -->
                        <div class=" col-lg-6 d-flex justify-content-center align-items-center mt-3 mt-lg-0">
                            <div class="nav-wrapper position-relative">
                                <ul class="nav nav-pills flex-row gap-2 p-1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link px-2 py-1 active" data-bs-toggle="tab" href="#barChart" role="tab">Gráfico de Barra</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link px-2 py-1" data-bs-toggle="tab" href="#pieChart" role="tab">Gráfico de Torta</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="barChart">
                                <canvas id="chart-genero-bar" class="chart-canvas" height="140"></canvas>
                            </div>
                            <div class="tab-pane fade" id="pieChart">
                                <canvas id="chart-genero-pie" class="chart-canvas" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection

@push('js')
<script src="{{ url('/assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    //Ajax para actualizar el formulario al cambiar los select
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="{{ route('datos-talleres.index') }}"]');
        if (form) {
            form.querySelectorAll('select[name="taller_id"], select[name="mes"], select[name="anio"]').forEach(function(select) {
                select.addEventListener('change', function() {
                    form.submit();
                });
            });
        }
    });

    // Gráfico de barras por género
    const femenino = {{ $femenino }};
    const masculino = {{ $masculino }};

    const ctxBar = document.getElementById("chart-genero-bar").getContext("2d");
    new Chart(ctxBar, {
        type: "bar",
        data: {
            labels: ["Femenino", "Masculino"],
            datasets: [{
                label: "Cantidad de asistentes",
                data: [femenino, masculino],
                backgroundColor: ['#E83E8C', '	#1E90FF'],
                borderRadius: 5,
                barThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#ccc' },
                    grid: { display: true, drawBorder: false, borderDash: [5, 5] }
                },
                x: {
                    ticks: { color: '#ccc' },
                    grid: { display: false }
                }
            }
        }
    });

    const ctxPie = document.getElementById("chart-genero-pie").getContext("2d");
    new Chart(ctxPie, {
        type: "pie",
        data: {
            labels: ["Femenino", "Masculino"],
            datasets: [{
                data: [femenino, masculino],
                backgroundColor: ['#E83E8C', '	#1E90FF'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            aspectRatio: 2,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Gráfico de curva (línea) de asistentes por día
    const ctxCurva = document.getElementById("chart-curva").getContext("2d");
    new Chart(ctxCurva, {
        type: "line",
        data: {
            labels: {!! json_encode(array_map(fn($d) => \Carbon\Carbon::parse($d['fecha'])->format('d M'), $curvaDatos)) !!},
            datasets: [{
                label: "Asistentes por día",
                data: {!! json_encode(array_column($curvaDatos, 'cantidad')) !!},
                fill: false,
                borderColor: '#218838', 
                tension: 0.3,
                pointBackgroundColor: '#D12421',
                pointRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    // Ajusta el stepSize según el máximo de asistentes
                    ticks: {
                        color: '#ccc',
                        stepSize: Math.max(1, Math.ceil(Math.max(...{!! json_encode(array_column($curvaDatos, 'cantidad')) !!}) / 10))
                    },
                    grid: { display: true, drawBorder: false, borderDash: [5, 5] }
                },
                x: {
                    ticks: { color: '#ccc' },
                    grid: { display: false }
                }
            }
        }
    });
</script>
<style>
    .custom-excel-btn {
        background-color: rgb(33, 115, 70) !important;
        color: #fff !important;
        border: none;
    }
    .custom-excel-btn:hover {
        background-color: #237346 !important;
        color: #fff !important;
    }
    @media (max-width: 576px) {
    .nav-pills .nav-link {
        font-size: 0.85rem;
    }
    }

</style>
@endpush