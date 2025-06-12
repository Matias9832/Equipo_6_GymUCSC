@extends('layouts.guest')

@section('title', 'Partidos del Torneo')

@section('content')
@include('layouts.navbars.guest.navbar')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h4>Partidos de {{ $torneo->nombre_torneo }}</h4>
            <div class="mb-3 d-flex align-items-center flex-wrap">
                <form method="GET" class="me-2">
                    <input type="hidden" name="ronda" value="{{ $rondaAnterior }}">
                    <button type="submit" class="btn btn-outline-secondary btn-sm" {{ $rondaAnterior === null ? 'disabled' : '' }}>
                        &laquo; Anterior
                    </button>
                </form>
                <div class="d-flex flex-wrap align-items-center me-2">
                    <span class="me-2 fw-bold">Navegación de Fechas:</span>
                    @foreach($fechas as $f)
                        <form method="GET" class="d-inline">
                            <input type="hidden" name="ronda" value="{{ $f }}">
                            <button type="submit" class="btn btn-sm {{ $f == $rondaSeleccionada ? 'btn-primary' : 'btn-outline-primary' }} mx-1 mb-1">
                                {{ $f }}
                            </button>
                        </form>
                    @endforeach
                </div>
                <form method="GET" class="ms-2">
                    <input type="hidden" name="ronda" value="{{ $rondaSiguiente }}">
                    <button type="submit" class="btn btn-outline-secondary btn-sm" {{ $rondaSiguiente === null ? 'disabled' : '' }}>
                        Siguiente &raquo;
                    </button>
                </form>
            </div>
            @if(isset($partidosPorRonda[$rondaSeleccionada]))
                <h5>
                    Fecha {{ $rondaSeleccionada }}
                    <span class="badge bg-secondary ms-2">{{ $etapa }}</span>
                </h5>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Local</th>
                                <th>Visitante</th>
                                <th>Resultado Local</th>
                                <th>Resultado Visitante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partidosPorRonda[$rondaSeleccionada] as $partido)
                                <tr>
                                    <td>{{ $partido->local ? $partido->local->nombre_equipo : 'Sin equipo' }}</td>
                                    <td>{{ $partido->visitante ? $partido->visitante->nombre_equipo : 'Sin equipo' }}</td>
                                    <td>{{ $partido->resultado_local }}</td>
                                    <td>{{ $partido->resultado_visitante }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">No hay partidos para esta fecha.</div>
            @endif
            <a href="{{ route('torneos.usuario.index') }}" class="btn btn-secondary mt-3 float-end">Volver</a>
        </div>
    </div>
</div>
@endsection