@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Torneos</h2>
            <div class="card shadow rounded-4 p-4" style="background: #fff;">
                @if($torneos->isEmpty())
                    <div class="alert alert-info">No hay torneos disponibles.</div>
                @else
                    @foreach($torneos as $torneo)
                        <div class="mb-4">
                            <h5 class="text-primary">
                                {{ $torneo->nombre_torneo }}
                                <span class="text-muted" style="font-size:1rem;">
                                    &mdash; Deporte: {{ $torneo->deporte->nombre_deporte }}
                                </span>
                            </h5>
                            <ul>
                                <li>
                                    <strong>Tipo de Competencia:</strong> {{ ucfirst($torneo->tipo_competencia) }}
                                </li>
                            </ul>
                            @php
                                $usuario = Auth::user();
                                // Buscar si el usuario pertenece a un equipo de este torneo
                                $equipo = $usuario->equipos()
                                    ->whereHas('torneos', function ($query) use ($torneo) {
                                        $query->where('torneos.id', $torneo->id);
                                    })->first();
                            @endphp

                            {{-- Botones de navegación según tipo de torneo --}}
                            <div class="mb-2">
                                @if($torneo->tipo_competencia === 'liga')
                                    <a href="{{ route('usuario.torneos.tabla', $torneo->id) }}" class="btn btn-outline-primary btn-sm">Ver Tabla de Posiciones</a>
                                    <a href="{{ route('usuario.torneos.partidos', $torneo->id) }}" class="btn btn-outline-secondary btn-sm">Ver Fechas y Partidos</a>
                                @elseif($torneo->tipo_competencia === 'copa')
                                    @if($torneo->fase_grupos)
                                        <a href="{{ route('usuario.torneos.fase-grupos', $torneo->id) }}" class="btn btn-outline-primary btn-sm">Ver Fase de Grupos</a>
                                    @endif
                                    <a href="{{ route('usuario.torneos.copa', $torneo->id) }}" class="btn btn-outline-success btn-sm">Ver Llaves</a>
                                    <a href="{{ route('usuario.torneos.partidos', $torneo->id) }}" class="btn btn-outline-secondary btn-sm">Ver Partidos</a>
                                @endif
                            </div>
                            {{-- Solo los usuarios que pertenecen a un equipo pueden ver miembros --}}
                            @if($equipo)
                                <a href="{{ route('torneos.ver.miembros', $torneo->id) }}" class="btn btn-primary btn-sm">
                                    Ver miembros
                                </a>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection