@extends('layouts.admin')

@section('title', 'Editar Equipo')

@section('content')
    <h1 class="h3">Editar Equipo: {{ $equipo->nombre_equipo }}</h1>
    <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <h5>Integrantes disponibles (Máx: {{ $deporte->jugadores_por_equipo }})</h5>
            <div class="form-check">
                @foreach($usuarios as $usuario)
                    <div class="mb-2">
                        <input 
                            type="checkbox" 
                            name="usuarios[]" 
                            id="usuario_{{ $usuario->id_usuario }}" 
                            value="{{ $usuario->id_usuario }}" 
                            class="form-check-input"
                            {{ $equipo->usuarios->contains($usuario->id_usuario) ? 'checked' : '' }}
                        >
                        <label for="usuario_{{ $usuario->id_usuario }}" class="form-check-label">
                            {{ $usuario->rut }} ({{ $usuario->correo_usuario }})
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection