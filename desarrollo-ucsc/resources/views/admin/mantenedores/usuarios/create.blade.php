@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('content')
    <h1 class="h3">Crear Usuario</h1>
    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rut" class="form-label">RUT</label>
            <input type="text" name="rut" id="rut" class="form-control" placeholder="RUT del usuario" required>
        </div>
        <div class="mb-3">
            <label for="correo_usuario" class="form-label">Correo</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" placeholder="Correo del usuario" required>
        </div>
        <div class="mb-3">
            <label for="contrasenia_usuario" class="form-label">Contraseña</label>
            <input type="password" name="contrasenia_usuario" id="contrasenia_usuario" class="form-control" placeholder="Contraseña" required>
        </div>
        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="normal">Normal</option>
                <option value="seleccionado">Seleccionado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection