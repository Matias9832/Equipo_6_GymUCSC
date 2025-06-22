@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Salas'])
    <div class="container-fluid py-4">
        <div class="col-xl-12 mb-4">
            <div class="card">
                <div class="card-header pb-2">
                    <h5 class="mb-0">Datos de Ingresos a Salas</h5>
                </div>
                <div class="card-body py-2">
                    <form method="GET" action="{{ route('datos-salas.index') }}">
                        <div class="row align-items-end gx-3 gy-3">
                            <!-- Selector de Sala -->
                            <div class="col-sm-12 col-md-4 col-lg-3 mb-lg-1">
                                <label class="form-label text-uppercase font-weight-bold text-sm">Sala</label>
                                <select class="form-control" name="sala_id" onchange="this.form.submit()">
                                    <option value="">Todas</option>
                                    @foreach($salas as $sala)
                                        <option value="{{ $sala->id_sala }}" {{ request('sala_id') == $sala->id_sala ? 'selected' : '' }}>
                                            {{ $sala->nombre_sala }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Desde -->
                            <div class="col-sm-6 col-md-3 col-lg-2 mb-lg-1">
                                <label class="form-label text-uppercase font-weight-bold text-sm">Desde</label>
                                <input type="text" name="desde" class="form-control" id="desde"
                                    value="{{ request('desde', now()->startOfMonth()->format('Y-m-d')) }}"
                                    onchange="this.form.submit()">
                            </div>
                            <!-- Hasta -->
                            <div class="col-sm-6 col-md-3 col-lg-2 mb-lg-1">
                                <label class="form-label text-uppercase font-weight-bold text-sm">Hasta</label>
                                <input type="text" name="hasta" class="form-control" id="hasta"
                                    value="{{ request('hasta', now()->endOfMonth()->format('Y-m-d')) }}"
                                    onchange="this.form.submit()">
                            </div>
                            <!-- Botones -->
                            <div class="col-12 col-lg d-flex flex-wrap align-items-center gap-2 mt-3">
                                <!-- Botón Exportar -->
                                <div class="d-flex flex-wrap gap-2 me-auto">
                                    <a href="{{ route('datos-salas.exportar', [
                                        'sala_id' => request('sala_id'),
                                        'desde' => request('desde'),
                                        'hasta' => request('hasta')
                                    ]) }}" 
                                    class="btn custom-excel-btn custom-btn mb-1" title="Exportar">
                                        <i class="fas fa-file-excel me-1"></i> Exportar a excel
                                    </a>
                                </div>
                                <!-- Botón Ir a Salas -->
                                <a href="{{ route('salas.index') }}" class="btn btn-primary mb-1">Ir a Salas</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       <!-- Métricas y gráficos principales -->                                 
        <div class="row">
            <!-- Métrica: Información de Ingresos por mes -->
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card mb-4">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Ingresos del Mes</p>
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
                <!-- Gráfico de curva: Ingresos por día del mes -->
                <div class="card mb-4">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">Ingresos por día del mes</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-curva-salas" class="chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            
                <!-- Informacion por carrera y porcentual -->
                    <div class="card mb-4">
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
            <!-- Información de Ingresos Hoy -->
            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
                <div class="card mb-4">
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
                                     <i class="ni ni-calendar-grid-58 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Información por Genero -->
                
                    <div class="card z-index-2 mb-4">
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

        //Configuración de Flatpickr para los selectores de fecha
        let desdePicker, hastaPicker;
        document.addEventListener('DOMContentLoaded', function () {
            desdePicker = flatpickr("#desde", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                locale: "es",
                disableMobile: true,
                minDate: new Date(new Date().getFullYear(), 0, 1),
                maxDate: new Date(new Date().getFullYear(), 11, 31),
                defaultDate: "{{ request('desde', now()->startOfMonth()->format('Y-m-d')) }}",
                onChange: function(selectedDates, dateStr) {
                    if (hastaPicker) {
                        // Suma un día a la fecha seleccionada en "Desde"
                        let minHasta = new Date(selectedDates[0]);
                        minHasta.setDate(minHasta.getDate() + 1);
                        hastaPicker.set('minDate', minHasta);
                    }
                }
            });

            hastaPicker = flatpickr("#hasta", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d-m-Y",
                locale: "es",
                disableMobile: true,
                minDate: new Date(new Date().getFullYear(), 0, 1),
                maxDate: new Date(new Date().getFullYear(), 11, 31),
                defaultDate: "{{ request('hasta', now()->endOfMonth()->format('Y-m-d')) }}"
            });

            // Inicializa la restricción al cargar la página
            let desdeValue = document.getElementById('desde').value;
            if (desdeValue) {
                let minHasta = new Date(desdeValue);
                minHasta.setDate(minHasta.getDate() + 1);
                hastaPicker.set('minDate', minHasta);
            }
        });

        // Gráfico de curva: Ingresos por día del mes
        const ctxCurvaSalas = document.getElementById("chart-curva-salas").getContext("2d");
        new Chart(ctxCurvaSalas, {
            type: "line",
            data: {
                labels: {!! json_encode(array_map(fn($d) => \Carbon\Carbon::parse($d['fecha'])->format('d M'), $curvaDatos)) !!},
                datasets: [{
                    label: "Ingresos por día",
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
        #chart-genero-bar {
        height: 355px !important;
        max-height: 380px !important;
        }
        #chart-curva-salas {
            height: 250px !important;
            max-height: 300px !important;
        }
    </style>
@endpush