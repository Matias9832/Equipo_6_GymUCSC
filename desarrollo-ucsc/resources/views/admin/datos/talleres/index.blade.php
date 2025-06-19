@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Talleres'])
<div class="container-fluid py-4">
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('datos-talleres.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label text-uppercase font-weight-bold text-sm">Taller</label>
                        <select class="form-control" name="taller_id">
                            <option value="">Todos</option>
                            @foreach($talleres as $taller)
                                <option value="{{ $taller->id_taller }}" {{ request('taller_id', $tallerId) == $taller->id_taller ? 'selected' : '' }}>
                                    {{ $taller->nombre_taller }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-uppercase font-weight-bold text-sm">Mes</label>
                        <select class="form-control" name="mes">
                            @foreach(range(1,12) as $m)
                                <option value="{{ sprintf('%02d', $m) }}" {{ $mes == sprintf('%02d', $m) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->locale('es')->monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-uppercase font-weight-bold text-sm">Año</label>
                        <select class="form-control" name="anio">
                            @foreach($anios as $a)
                                <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Aplicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Métricas -->
    <div class="row">
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Asistentes del Mes</p>
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
        </div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
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
                                <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Gráfica -->
    <div class="row mt-4">
        <!-- Asistentes por carrera -->
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Asistentes por Carrera</h6>
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
        <!-- Gráficos -->
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Asistentes por género</h6>
                    <p class="text-sm mb-0">
                        Femenino: <span class="font-weight-bold text-pink">{{ $porcentajeF }}%</span> /
                        Masculino: <span class="font-weight-bold text-primary">{{ $porcentajeM }}%</span>
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart mb-4">
                        <canvas id="chart-genero" class="chart-canvas" height="150"></canvas>
                    </div>
                    <div class="chart">
                        <canvas id="chart-curva" class="chart-canvas" height="150"></canvas>
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
    // Gráfico de barras por género
    const ctxGenero = document.getElementById("chart-genero").getContext("2d");
    new Chart(ctxGenero, {
        type: "bar",
        data: {
            labels: ["Femenino", "Masculino"],
            datasets: [{
                label: "Cantidad de asistentes",
                data: [{{ $femenino }}, {{ $masculino }}],
                backgroundColor: [
                    '#f5365c', // pink
                    '#5e72e4'  // blue
                ],
                borderRadius: 5,
                barThickness: 50,
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
                borderColor: '#5e72e4',
                tension: 0.3,
                pointBackgroundColor: '#f5365c',
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
</script>
@endpush