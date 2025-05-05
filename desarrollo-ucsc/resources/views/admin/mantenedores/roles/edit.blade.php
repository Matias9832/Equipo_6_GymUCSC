@extends('layouts.admin')

@section('title', 'Editar Rol')

@section('content')
    <h1 class="h3">Editar Rol</h1>
    <form action="{{ route('roles.update', $rol) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_rol" class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre_rol" id="nombre_rol" class="form-control" value="{{ $rol->nombre_rol }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection