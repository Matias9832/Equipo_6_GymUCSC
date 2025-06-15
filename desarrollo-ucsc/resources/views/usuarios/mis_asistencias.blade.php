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
            @if($asistencias->isEmpty())
                <div class="alert alert-secondary text-center py-3 fs-5 mb-0">
                    No tienes asistencias registradas para este taller.
                </div>
            @else
                @foreach($asistencias as $registro)
                    @php
                        $fecha = \Carbon\Carbon::parse($registro->fecha_asistencia);
                        $meses = [
                            1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                            5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                            9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre',
                        ];
                        $mesNombre = $meses[$fecha->month];
                    @endphp

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Asistencia:
                        <span class="badge bg-primary rounded-pill">
                            {{ $fecha->day }} de {{ $mesNombre }} de {{ $fecha->year }}
                        </span>
                    </li>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
