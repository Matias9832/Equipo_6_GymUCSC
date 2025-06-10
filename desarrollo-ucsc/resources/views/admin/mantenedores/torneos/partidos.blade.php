@extends('layouts.app')

@section('title', 'Partidos del Torneo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Partidos del Torneo'])
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h4>Partidos de {{ $torneo->nombre_torneo }}</h4>
            @php
                $partidosPorRonda = $partidos->groupBy('ronda');
                $fechas = $partidosPorRonda->keys()->sort()->values();
                $totalFechas = $fechas->count();
                // Determinar la ronda actual (la menor ronda con partidos sin resultado)
                $rondaActual = null;
                foreach ($partidosPorRonda as $ronda => $partidosDeRonda) {
                    $incompletos = $partidosDeRonda->filter(function($p) {
                        return $p->resultado_local === null || $p->resultado_visitante === null;
                    });
                    if ($incompletos->count() > 0) {
                        $rondaActual = $ronda;
                        break;
                    }
                }
                // Obtener ronda seleccionada por GET, si no, mostrar la ronda actual o la primera
                $rondaSeleccionada = request('ronda');
                if (!$rondaSeleccionada) {
                    $rondaSeleccionada = $rondaActual ?? ($fechas->first() ?? 1);
                }
                $rondaSeleccionada = intval($rondaSeleccionada);
                // Para navegación
                $indiceActual = $fechas->search($rondaSeleccionada);
                $rondaAnterior = $indiceActual > 0 ? $fechas[$indiceActual - 1] : null;
                $rondaSiguiente = $indiceActual !== false && $indiceActual < $fechas->count() - 1 ? $fechas[$indiceActual + 1] : null;
                // ¿Está finalizada la fecha?
                $finalizada = isset($partidosPorRonda[$rondaSeleccionada]) && $partidosPorRonda[$rondaSeleccionada]->first()->finalizada;

                // Determinar etapa
                $etapa = '';
                if ($torneo->fase_grupos) {
                    $totalFechasGrupos = $torneo->equipos_por_grupo - 1;
                    if ($rondaSeleccionada <= $totalFechasGrupos) {
                        $etapa = 'Fase de Grupos';
                    } else {
                        $etapa = 'Eliminatoria';
                    }
                } else {
                    $etapa = 'Liga';
                }
            @endphp

            {{-- Navegación de fechas tipo paginador --}}
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

            {{-- Botón para finalizar fecha --}}
            @if(isset($partidosPorRonda[$rondaSeleccionada]) && !$finalizada)
                @php
                    $todosConResultado = $partidosPorRonda[$rondaSeleccionada]->every(function($p) {
                        return $p->resultado_local !== null && $p->resultado_visitante !== null;
                    });
                @endphp
                <form method="POST" action="{{ route('torneos.finalizar-fecha', $torneo->id) }}" class="mb-3">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="ronda" value="{{ $rondaSeleccionada }}">
                    <button type="submit" class="btn btn-danger" {{ !$todosConResultado ? 'disabled' : '' }}>Finalizar Fecha</button>
                </form>
            @endif

            {{-- Botón para reiniciar torneo --}}
            <form action="{{ route('torneos.reiniciar', $torneo->id) }}" method="POST" class="mb-3" onsubmit="return confirm('¿Estás seguro de que deseas reiniciar el torneo? Se borrarán todos los partidos.')">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-redo"></i> Reiniciar Torneo
                </button>
            </form>

            {{-- Tabla de partidos de la fecha seleccionada --}}
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
                                <th>Acción</th>
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
                                                <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning">No hay partidos para esta fecha.</div>
            @endif
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
@endsection