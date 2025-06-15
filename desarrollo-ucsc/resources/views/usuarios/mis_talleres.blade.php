@extends('layouts.guest')

@section('content')
@include('layouts.navbars.guest.navbar')

<style>
    /* Estilo para las pelotitas en los horarios */
    .horarios-lista {
        list-style-type: disc;
        padding-left: 1.25rem; /* para que quede espacio para el punto */
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Mis Talleres</h2>

    @if($talleres->isEmpty())
        <div class="alert alert-secondary">No tienes talleres registrados con asistencia.</div>
    @else
        <div class="row">
            @foreach($talleres as $taller)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 mb-4 h-100">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold text-dark mb-2">
                                {{ $taller->nombre_taller }}
                            </h5>

                            <p class="text-muted mb-3">
                                {{ $taller->descripcion_taller }}
                            </p>

                            @if($taller->horarios->count())
                                <div class="mb-3">
                                    <div class="fw-semibold text-muted mb-1">
                                        <i class="fas fa-clock me-2 text-dark"></i>Horarios del Taller:
                                    </div>
                                    <ul class="horarios-lista mb-0 ms-3 mps-3">
                                        @foreach($taller->horarios as $horario)
                                            <li class="small text-dark">
                                                {{ ucfirst($horario->dia_taller) }}:
                                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} a
                                                {{ \Carbon\Carbon::parse($horario->hora_termino)->format('H:i') }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="text-muted small">Sin horarios definidos.</p>
                            @endif

                            @if($taller->pivot && $taller->pivot->fecha_asistencia)
                                <div class="text-sm text-muted mt-2">
                                    <i class="fas fa-calendar-alt me-2 text-dark"></i>
                                    Última asistencia:
                                    <strong>{{ \Carbon\Carbon::parse($taller->pivot->fecha_asistencia)->format('d-m-Y') }}</strong>
                                </div>
                            @endif

                            <div class="mt-auto pt-3">
                                <a href="{{ route('usuario.asistencias', $taller->id_taller) }}" class="btn btn-primary btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i> Ver asistencias
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
