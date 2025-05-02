@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
    <h1 class="h3">Editar Usuario</h1>
    <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="rut" class="form-label">RUT</label>
            <input type="text" name="rut" id="rut" class="form-control" value="{{ $usuario->rut }}" required>
        </div>
        <div class="mb-3">
            <label for="correo_usuario" class="form-label">Correo</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario }}" required>
        </div>
        <div class="mb-3">
            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
            <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                <option value="admin" {{ $usuario->tipo_usuario == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="normal" {{ $usuario->tipo_usuario == 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="seleccionado" {{ $usuario->tipo_usuario == 'seleccionado' ? 'selected' : '' }}>Seleccionado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="contrasenia_usuario" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="contrasenia_usuario" id="contrasenia_usuario" class="form-control" placeholder="Dejar en blanco para no cambiar">
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection