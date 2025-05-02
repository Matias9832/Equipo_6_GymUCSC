@extends('layouts.admin')

@section('title', 'Editar Administrador')

@section('content')
    <h1 class="h3">Editar Administrador</h1>
    <form action="{{ route('administradores.update', $administrador->id_admin) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="rut_admin" class="form-label">RUT</label>
            <input type="text" name="rut_admin" id="rut_admin" class="form-control" value="{{ $administrador->rut_admin }}" readonly>
        </div>
        <div class="mb-3">
            <label for="nombre_admin" class="form-label">Nombre</label>
            <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" value="{{ $administrador->nombre_admin }}" required>
        </div>
        <div class="mb-3">
            <label for="correo_usuario" class="form-label">Correo</label>
            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label for="permisos" class="form-label">Permisos</label>
            <input type="text" name="permisos" id="permisos" class="form-control" value="--" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Administrador</button>
        <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection