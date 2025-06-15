@extends('layouts.guest')

@section('content')
@include('layouts.navbars.guest.navbar')

<div class="container mt-4">
    <div class="card shadow-sm border">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold text-dark">
                <i class="fas fa-list-check me-2"></i>Mis Asistencias - {{ $taller->nombre_taller }}
            </h3>
            <a href="{{ route('usuario.talleres') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Volver a Mis Talleres
            </a>
        </div>

        <div class="card-body">
            @php
                use Illuminate\Support\Carbon;

                $meses = [
                    '01' => 'enero', '02' => 'febrero', '03' => 'marzo', '04' => 'abril',
                    '05' => 'mayo', '06' => 'junio', '07' => 'julio', '08' => 'agosto',
                    '09' => 'septiembre', '10' => 'octubre', '11' => 'noviembre', '12' => 'diciembre',
                ];
            @endphp

            @if($asistencias->isEmpty())
                <div class="alert alert-secondary">No tienes asistencias registradas para este taller.</div>
            @else
                @foreach($asistencias as $mesAnio => $fechas)
                    @php
                        [$anio, $mes] = explode('-', $mesAnio);
                        $nombreMes = ucfirst($meses[$mes]);
                    @endphp

                    <div class="mb-4">
                        <h4 class="text-dark fw-bold ms-3 pb-2">{{ $nombreMes }} de {{ $anio }}</h4>

                        <ul class="list-group">
                            @foreach($fechas as $registro)
                                @php
                                    $fecha = Carbon::parse($registro->fecha_asistencia);
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="text-dark">
                                        <i class="fas fa-check-circle me-2 text-success"></i>
                                        Asistencia registrada
                                    </span>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ $fecha->format('d') }} de {{ $meses[$fecha->format('m')] }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
