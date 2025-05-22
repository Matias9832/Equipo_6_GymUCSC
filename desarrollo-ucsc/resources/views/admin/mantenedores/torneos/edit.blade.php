@extends('layouts.app')

@section('title', 'Editar Torneo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Torneo'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('torneos.update', $torneo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
                            <input type="text" name="nombre_torneo" id="nombre_torneo" class="form-control" value="{{ $torneo->nombre_torneo }}" required>
                        </div>

                        <div class="mb-3">
                            <h6 class="mb-2">Equipos disponibles para el deporte: <strong>{{ $torneo->deporte->nombre_deporte }}</strong></h6>
                            @foreach($equipos as $equipo)
                                <div class="form-check mb-2">
                                    <input 
                                        type="checkbox" 
                                        name="equipos[]" 
                                        id="equipo_{{ $equipo->id }}" 
                                        value="{{ $equipo->id }}" 
                                        class="form-check-input"
                                        {{ $torneo->equipos->contains($equipo->id) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="equipo_{{ $equipo->id }}">
                                        {{ $equipo->nombre_equipo }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
