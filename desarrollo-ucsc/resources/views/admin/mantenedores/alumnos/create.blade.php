@extends('layouts.admin')

@section('title', 'Crear Alumno')

@section('content')
    <h1 class="h3">Crear Alumno</h1>
    <form action="{{ route('alumnos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rut_alumno" class="form-label">RUT</label>
            <input type="text" name="rut_alumno" id="rut_alumno" class="form-control" placeholder="RUT del alumno" required>
        </div>
        <div class="mb-3">
            <label for="nombre_alumno" class="form-label">Nombre</label>
            <input type="text" name="nombre_alumno" id="nombre_alumno" class="form-control" placeholder="Nombre del alumno" required>
        </div>
        <div class="mb-3">
            <label for="carrera" class="form-label">Carrera</label>
            <input type="text" name="carrera" id="carrera" class="form-control" placeholder="Carrera del alumno" required>
        </div>
        <div class="mb-3">
            <label for="estado_alumno" class="form-label">Estado</label>
            <input type="text" name="estado_alumno" id="estado_alumno" class="form-control" placeholder="Estado del alumno" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Alumno</button>
        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection