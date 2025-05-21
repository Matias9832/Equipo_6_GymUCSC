@extends('layouts.app')

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
            <label for="nombre_admin" class="form-label">Nombre</label>
            <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" placeholder="Nombre del usuario" required>
        </div>
        <div class="mb-3">
            <label for="correo_usuario" class="form-label">Correo</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" placeholder="Correo del usuario" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol de usuario </label>
            <select name="rol" id="rol" class="form-control" required>
                <option value="">Selecciona un rol</option>
                <option value="Docente">Docente</option>
                <option value="Coordinador">Coordinador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection