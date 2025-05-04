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
            <label for="correo_usuario" class="form-label">Correo</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contrasenia_usuario" class="form-label">Contraseña</label>
            <input type="password" name="contrasenia_usuario" id="contrasenia_usuario" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <select name="id_rol" id="id_rol" class="form-control" required>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id_rol }}">{{ $rol->nombre_rol }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Administrador</button>
        <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection