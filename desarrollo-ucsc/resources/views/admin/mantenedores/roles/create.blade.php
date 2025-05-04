@extends('layouts.admin')

@section('title', 'Crear Rol')

@section('content')
    <h1 class="h3">Crear Rol</h1>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_rol" class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre_rol" id="nombre_rol" class="form-control" placeholder="Ingrese el nombre del rol" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection