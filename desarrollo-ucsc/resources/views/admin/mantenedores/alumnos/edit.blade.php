<!-- RECORDAR QUE PARA HACER UN UPDATE SE DEBE IMPORTAR UN EXCEL CON LAS TABLAS ORDENADAS CORRECTAMENTE -->
@extends('layouts.admin')

@section('title', 'Editar Alumno')

@section('content')
    <h1 class="h3">Editar Alumno</h1>
    <form action="{{ route('alumnos.update', $alumno->rut_alumno) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="rut_alumno" class="form-label">RUT</label>
            <input type="text" name="rut_alumno" id="rut_alumno" class="form-control" value="{{ $alumno->rut_alumno }}" readonly>
        </div>
        <div class="mb-3">
            <label for="nombre_alumno" class="form-label">Nombre</label>
            <input type="text" name="nombre_alumno" id="nombre_alumno" class="form-control" value="{{ $alumno->nombre_alumno }}" required>
        </div>
        <div class="mb-3">
            <label for="carrera" class="form-label">Carrera</label>
            <input type="text" name="carrera" id="carrera" class="form-control" value="{{ $alumno->carrera }}" required>
        </div>
        <div class="mb-3">
            <label for="estado_alumno" class="form-label">Estado</label>
            <input type="text" name="estado_alumno" id="estado_alumno" class="form-control" value="{{ $alumno->estado_alumno }}" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection