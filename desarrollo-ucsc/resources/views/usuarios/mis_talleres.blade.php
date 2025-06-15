@extends('layouts.guest')

@section('content')
@include('layouts.navbars.guest.navbar')

<div class="container mt-4">
    <h2>Mis Talleres</h2>

    @if($talleres->isEmpty())
        <p>No tienes talleres registrados con asistencia.</p>
    @else
        <div class="row">
            @foreach($talleres as $taller)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow border-0 mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $taller->nombre_taller }}</h5>
                            <p class="card-text text-sm text-muted">
                                {{ Str::limit($taller->descripcion_taller, 100) }}
                            </p>

                            @if($taller->horarios->count())
                                <p class="text-muted mb-1">Horarios:</p>
                                <ul class="list-unstyled small mb-2">
                                    @foreach($taller->horarios as $horario)
                                        <li>
                                            <strong>{{ ucfirst($horario->dia_taller) }}</strong>:
                                            {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} a
                                            {{ \Carbon\Carbon::parse($horario->hora_termino)->format('H:i') }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted small">Sin horarios definidos.</p>
                            @endif

                            @if($taller->pivot && $taller->pivot->fecha_asistencia)
                                <p class="mb-2 text-sm">
                                    <span class="text-muted">Última asistencia:</span><br>
                                    <strong>{{ \Carbon\Carbon::parse($taller->pivot->fecha_asistencia)->format('d-m-Y') }}</strong>
                                </p>
                            @endif

                            <a href="{{ route('asistencia.ver', $taller->id_taller) }}" class="btn btn-sm btn-primary">
                                Ver asistencias
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
