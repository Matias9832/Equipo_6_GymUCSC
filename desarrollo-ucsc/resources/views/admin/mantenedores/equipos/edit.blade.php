@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Equipo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Equipo'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">Editar Equipo: <strong>{{ $equipo->nombre_equipo }}</strong></h5>

            <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="capitan_id" class="form-label">Capitán del Equipo</label>
                    <select name="capitan_id" id="capitan_id" class="form-select" required>
                        <option value="">Selecciona un capitán</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}" {{ $equipo->capitan_id == $usuario->id_usuario ? 'selected' : '' }}>
                                {{ $usuario->rut }} - {{ $usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <div id="usuario-error" class="text-danger mt-2" style="display:none;"></div>
                </div>

                <div class="mb-4">
                    <h6>Integrantes disponibles <small class="text-muted">(Máx: {{ $deporte->jugadores_por_equipo }})</small></h6>
                    <div class="row">
                        @foreach($usuarios as $usuario)
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input 
                                        class="form-check-input"
                                        type="checkbox" 
                                        name="usuarios[]" 
                                        id="usuario_{{ $usuario->id_usuario }}" 
                                        value="{{ $usuario->id_usuario }}"
                                        {{ $equipo->usuarios->contains($usuario->id_usuario) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="usuario_{{ $usuario->id_usuario }}">
                                        {{ $usuario->rut }} ({{ $usuario->correo_usuario }})
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection