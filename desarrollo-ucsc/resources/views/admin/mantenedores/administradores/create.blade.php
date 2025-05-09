@extends('layouts.admin')

@section('title', 'Crear Administrador')

@section('content')
    <h1 class="h3">Crear Administrador</h1>
    <form action="{{ route('administradores.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rut_admin" class="form-label">RUT</label>
            <input type="text" name="rut_admin" id="rut_admin" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nombre_admin" class="form-label">Nombre del Administrador</label>
            <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-control" required>
                <option value="">Selecciona un rol</option>
                <option value="Director">Director</option>
                <option value="Docente">Docente</option>
                <option value="Coordinador">Coordinador</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="correo_usuario" class="form-label">Correo</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" required>
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
        <button type="submit" class="btn btn-primary">Crear Administrador</button>
        <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection