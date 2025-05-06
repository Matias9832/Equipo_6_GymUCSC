@extends('layouts.admin')

@section('title', 'Editar Torneo')

@section('content')
    <h1 class="h3">Editar Torneo: {{ $torneo->nombre_torneo }}</h1>
    <form action="{{ route('torneos.update', $torneo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
            <input type="text" name="nombre_torneo" id="nombre_torneo" class="form-control" value="{{ $torneo->nombre_torneo }}" required>
        </div>

        <div class="mb-3">
            <label for="id_sucursal" class="form-label">Sucursal</label>
            <select name="id_sucursal" id="id_sucursal" class="form-control" required>
                <option value="">Seleccione una sucursal</option>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id_suc }}" {{ $torneo->id_sucursal == $sucursal->id_suc ? 'selected' : '' }}>
                        {{ $sucursal->nombre_suc }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <h5>Equipos disponibles para el deporte: {{ $torneo->deporte->nombre_deporte }}</h5>
            <div class="form-check">
                @foreach($equipos as $equipo)
                    <div class="mb-2">
                        <input 
                            type="checkbox" 
                            name="equipos[]" 
                            id="equipo_{{ $equipo->id }}" 
                            value="{{ $equipo->id }}" 
                            class="form-check-input"
                            {{ $torneo->equipos->contains($equipo->id) ? 'checked' : '' }}
                        >
                        <label for="equipo_{{ $equipo->id }}" class="form-check-label">
                            {{ $equipo->nombre_equipo }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection