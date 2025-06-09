@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Mis Torneos</h2>
            <div class="card shadow rounded-4 p-4" style="background: #fff;">
                @if($torneos->isEmpty())
                    <div class="alert alert-info">No estás participando en ningún torneo.</div>
                @else
                    @foreach($torneos as $torneo)
                        <div class="mb-4">
                            <h5 style="color:#D12421;">
                                {{ $torneo->nombre_torneo }}
                                <span class="text-muted" style="font-size:1rem;">
                                    &mdash; Deporte: {{ $torneo->deporte->nombre_deporte }}
                                </span>
                            </h5>
                            <ul>
                                <li>
                                    <strong>Tipo de Competencia:</strong> {{ ucfirst($torneo->tipo_competencia) }}
                                </li>
                                {{-- <li>
                                    <strong>Máximo de Equipos:</strong> {{ $torneo->max_equipos }}
                                </li> --}}
                            </ul>
                            @php
                                $usuario = Auth::user();
                                // Buscar el equipo del usuario en este torneo
                                $equipo = $usuario->equipos()
                                    ->whereHas('torneos', function ($query) use ($torneo) {
                                        $query->where('torneos.id', $torneo->id);
                                    })->first();
                            @endphp
                            @if($equipo)
                                <a href="{{ route('torneos.agregar.miembros', $torneo->id) }}" class="btn btn-primary btn-sm" style="background:#D12421; border:none;">
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