@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Salas'])
    <div class="container-fluid py-4">
        <div class="col-xl-12 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-end">
                        <form method="GET" action="{{ route('datos-salas.index') }}" class="row g-3 align-items-end"
                            style="flex: 1;">
                            <div class="col-md-3">
                                <label class="form-label text-uppercase font-weight-bold text-sm">Sala</label>
                                <select class="form-control" name="sala_id" onchange="this.form.submit()">
                                    <option value="">Todas</option>
                                    @foreach($salas as $sala)
                                        <option value="{{ $sala->id_sala }}" {{ request('sala_id') == $sala->id_sala ? 'selected' : '' }}>{{ $sala->nombre_sala }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label text-uppercase font-weight-bold text-sm">Desde</label>
                                <input type="text" name="desde" class="form-control" id="desde"
                                    value="{{ request('desde', now()->startOfMonth()->format('Y-m-d')) }}"
                                    onchange="this.form.submit()">
                            </div>

                            <div class="col-md-2">
                                <label class="form-label text-uppercase font-weight-bold text-sm">Hasta</label>
                                <input type="text" name="hasta" class="form-control" id="hasta"
                                    value="{{ request('hasta', now()->endOfMonth()->format('Y-m-d')) }}"
                                    onchange="this.form.submit()">
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('datos-salas.exportar', [
                                    'sala_id' => request('sala_id'),
                                    'desde' => request('desde'),
                                    'hasta' => request('hasta')
                                ]) }}" class="btn custom-excel-btn btn-sm d-flex align-items-center justify-content-center"
                                    title="Exportar a Excel"
                                    style="margin-bottom: 0px !important; height: 40px !important;">
                                    <i class="fas fa-file-excel me-1"></i> Exportar
                                </a>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('salas.index') }}"
                                    class="btn btn-secondary mb-1 d-flex align-items-center justify-content-center"
                                    style="margin-bottom: 0px !important; height: 40px !important;">Ir a Salas
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información de Ingresos -->
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ingresos</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $ingresosMes }}
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ingresos Hoy</p>
                                    <h5 class="font-weight-bolder">
                                        {{ $ingresosDia }}
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

        <!-- Información Grafica -->
        <div class="row mt-4">
            <!-- Informacion por carrera y porcentual -->
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Ingresos por Carrera</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th>UA</th>
                                    <th>Carrera</th>
                                    <th class="text-center">Ingresos</th>
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
            <!-- Información por Genero -->
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Ingresos por género</h6>
                        <p class="text-sm mb-0">
                            Femenino: <span class="font-weight-bold text-pink">{{ $porcentajeF }}%</span> /
                            Masculino: <span class="font-weight-bold text-primary">{{ $porcentajeM }}%</span>
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-genero" class="chart-canvas" height="300"></canvas>
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
        const ctxGenero = document.getElementById("chart-genero").getContext("2d");

        new Chart(ctxGenero, {
            type: "bar",
            data: {
                labels: ["Femenino", "Masculino"],
                datasets: [{
                    label: "Cantidad de ingresos",
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
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#ccc'
                        },
                        grid: {
                            display: true,
                            drawBorder: false,
                            borderDash: [5, 5],
                        }
                    },
                    x: {
                        ticks: {
                            color: '#ccc'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        flatpickr("#desde", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d-m-Y",
            locale: "es",
            disableMobile: true,
            minDate: new Date(new Date().getFullYear(), 0, 1),
            maxDate: new Date(new Date().getFullYear(), 11, 31),
            defaultDate: "{{ request('desde', now()->startOfMonth()->format('Y-m-d')) }}"
        });

        flatpickr("#hasta", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d-m-Y",
            locale: "es",
            disableMobile: true,
            minDate: new Date(new Date().getFullYear(), 0, 1),
            maxDate: new Date(new Date().getFullYear(), 11, 31),
            defaultDate: "{{ request('hasta', now()->endOfMonth()->format('Y-m-d')) }}"
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

        @media (max-width: 768px) {
            .flatpickr-calendar {
                left: 60% !important;
                transform: translateX(-50%) !important;
            }
        }
    </style>
@endpush