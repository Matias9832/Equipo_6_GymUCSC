@extends('layouts.admin')

@section('title', 'Lista de Alumnos')

@section('content')
    <h1 class="h3">Lista de Alumnos</h1>
    <a href="{{ route('alumnos.create') }}" class="btn btn-primary mb-3">Crear Alumno</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->rut_alumno }}</td>
                    <td>{{ $alumno->nombre_alumno }}</td>
                    <td>{{ $alumno->carrera }}</td>
                    <td>{{ $alumno->estado_alumno }}</td>
                    <td>
                        <a href="{{ route('alumnos.edit', $alumno->rut_alumno) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('alumnos.destroy', $alumno->rut_alumno) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection