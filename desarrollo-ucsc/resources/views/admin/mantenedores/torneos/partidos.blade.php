@extends('layouts.app')

@section('title', 'Partidos del Torneo')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Partidos del Torneo'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <h4>Partidos de {{ $torneo->nombre_torneo }}</h4>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Local</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Visitante</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Goles Local</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Goles Visitante</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partidos as $partido)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $partido->local ? $partido->local->nombre_equipo : 'Sin equipo' }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $partido->visitante ? $partido->visitante->nombre_equipo : 'Sin equipo' }}</p>
                                    </td>
                                    <td>
                                        <form action="{{ route('partidos.update', $partido->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="goles_local" value="{{ $partido->goles_local }}" class="form-control me-2" min="0" style="width: 80px;">
                                    </td>
                                    <td>
                                            <input type="number" name="goles_visitante" value="{{ $partido->goles_visitante }}" class="form-control me-2" min="0" style="width: 80px;">
                                    </td>
                                    <td>
                                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay partidos generados para este torneo.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
@endsection