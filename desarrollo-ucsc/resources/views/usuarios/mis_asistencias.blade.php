@extends('layouts.guest')

@section('content')
@include('layouts.navbars.guest.navbar')

<div class="container mt-4">
    <div class="card shadow-sm border rounded">
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
                <ul class="list-group list-group-flush">
                    @foreach($asistencias as $usuario)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                            <span class="text-secondary fst-italic">Fecha de asistencia</span>
                            <span class="badge bg-primary rounded-pill fs-6">
                                {{ \Carbon\Carbon::parse($usuario->pivot->fecha_asistencia)->format('d-m-Y') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
