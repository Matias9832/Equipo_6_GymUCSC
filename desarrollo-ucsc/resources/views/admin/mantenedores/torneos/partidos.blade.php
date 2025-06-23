@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Torneos'])
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h4>Partidos de {{ $torneo->nombre_torneo }}</h4>

            <div class="mb-3 d-flex align-items-center flex-wrap">
                <form method="GET" class="me-2">
                    <input type="hidden" name="ronda" value="{{ $rondaAnterior }}">
                    <button type="submit" class="btn btn-outline-secondary btn-sm" {{ $rondaAnterior === null ? 'disabled' : '' }} style="margin-bottom: 0rem !important;">
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
                    <button type="submit" class="btn btn-outline-secondary btn-sm" {{ $rondaSiguiente === null ? 'disabled' : '' }} style="margin-bottom: 0rem !important;">>
                        Siguiente &raquo;
                    </button>
                </form>
            </div>

            {{-- Botón para finalizar fecha --}}
            @if(isset($partidosPorRonda[$rondaSeleccionada]) && !$finalizada)
                @php
                    $todosConResultado = $partidosPorRonda[$rondaSeleccionada]->every(function($p) {
                        return is_numeric($p->resultado_local) && is_numeric($p->resultado_visitante);
                    });
                @endphp
                <form method="POST" action="{{ route('torneos.finalizar-fecha', $torneo->id) }}" class="mb-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="ronda" value="{{ $rondaSeleccionada }}">
                    <button type="submit" class="btn btn-danger" {{ !$todosConResultado ? 'disabled' : '' }}>Finalizar Fecha</button>
                </form>
            @endif

            @if(isset($partidosPorRonda[$rondaSeleccionada]))
                <h5>
                    Fecha {{ $rondaSeleccionada }}
                    <span class="badge bg-secondary ms-2">{{ $etapa }}</span>
                </h5>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="ps-2">Local</th>
                                <th class="ps-2">Visitante</th>
                                <th class="ps-2">Resultado Local</th>
                                <th class="ps-2">Resultado Visitante</th>
                                <th class="ps-2">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partidosPorRonda[$rondaSeleccionada] as $partido)
                                <tr>
                                    <td>{{ $partido->local ? $partido->local->nombre_equipo : 'Sin equipo' }}</td>
                                    <td>{{ $partido->visitante ? $partido->visitante->nombre_equipo : 'Sin equipo' }}</td>
                                    <td>
                                        <form action="{{ route('partidos.update', $partido->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="resultado_local" value="{{ $partido->resultado_local }}" class="form-control me-2" style="width: 80px;" 
                                                {{ $finalizada ? 'readonly' : '' }}>
                                    </td>
                                    <td>
                                            <input type="text" name="resultado_visitante" value="{{ $partido->resultado_visitante }}" class="form-control me-2" style="width: 80px;" 
                                                {{ $finalizada ? 'readonly' : '' }}>
                                    </td>
                                    <td>
                                            @if(!$finalizada)
                                                <button type="submit" class="btn btn-success btn-sm" style="margin-bottom: 0rem !important">Guardar</button>
                                                <a href="{{ route('torneos.index') }}" class="btn btn-outline-secondary mt-3 btn-sm">Volver</a>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning text-white">No hay partidos para esta fecha.</div>
                <div class="d-flex align-items-center justify-content-between gap-3 mt-4">
                    {{-- Botón para reiniciar torneo --}}
                    <form action="{{ route('torneos.reiniciar', $torneo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas reiniciar el torneo? Se borrarán todos los partidos.')" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-warning d-flex align-items-center mb-0">
                            <i class="fas fa-redo me-2"></i> Reiniciar Torneo
                        </button>
                    </form>
                    {{-- Botón para volver a la lista de torneos --}}
                    <a href="{{ route('torneos.index') }}" class="btn btn-outline-secondary d-flex align-items-center px-4 mb-0">
                        Volver
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@include('layouts.footers.auth.footer')
@endsection