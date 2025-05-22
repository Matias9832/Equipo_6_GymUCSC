@extends('layouts.app')

@section('title', 'Editar Administrador')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Administrador'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('administradores.update', $administrador->id_admin) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre_admin" class="form-label">Nombre</label>
                    <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" value="{{ $administrador->nombre_admin }}" required>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select name="rol" id="rol" class="form-control" required>
                        <option value="Director" {{ $usuario->hasRole('Director') ? 'selected' : '' }}>Director</option>
                        <option value="Docente" {{ $usuario->hasRole('Docente') ? 'selected' : '' }}>Docente</option>
                        <option value="Coordinador" {{ $usuario->hasRole('Coordinador') ? 'selected' : '' }}>Coordinador</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Correo</label>
                    <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario ?? '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="sucursal_id" class="form-label">Sucursal</label>
                    <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                        <option value="">Selecciona una sucursal</option>
                        @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id_suc }}"
                                {{ (isset($sucursalSeleccionada) && $sucursalSeleccionada->id_suc == $sucursal->id_suc) ? 'selected' : '' }}>
                                {{ $sucursal->nombre_suc }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
