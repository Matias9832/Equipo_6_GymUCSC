@extends('layouts.guest')

@section('content')
@include('layouts.navbars.guest.navbar')
<main class="main-content mt-0">
    <div class="container py-4">
        <h2 class="mb-4">Miembros del Equipo</h2>
        <div class="card shadow rounded-4 p-4" style="background: #fff;">
            <h5 class="mb-4">Torneo: <strong>{{ $torneo->nombre_torneo }}</strong></h5>
            <h6 class="mb-4">Equipo: <strong>{{ $equipo->nombre_equipo }}</strong></h6>
            <p>Integrantes actuales: {{ $equipo->usuarios->count() }} / {{ $equipo->deporte->jugadores_por_equipo }}</p>

            <div class="mb-4">
                <h6>Integrantes del equipo</h6>
                <ul>
                    @foreach($equipo->usuarios as $usuario)
                        <li>
                            {{ $usuario->rut }} -
                            @if($usuario->alumno)
                                {{ $usuario->alumno->nombre_alumno }} {{ $usuario->alumno->apellido_paterno }} {{ $usuario->alumno->apellido_materno }}
                            @else
                                {{ $usuario->nombre }}
                            @endif
                            @if($equipo->capitan_id == $usuario->id_usuario)
                                <span class="badge bg-primary ms-2">Capitán</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="d-flex justify-content-end">
                <a href="{{ route('torneos.usuario.index') }}" class="btn btn-outline-secondary me-2">Volver</a>
            </div>
        </div>
    </div>
</main>
@include('layouts.footers.guest.footer')
@endsection