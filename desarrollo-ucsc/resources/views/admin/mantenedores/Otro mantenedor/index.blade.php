@extends('layouts.admin')

@section('title', 'Lista de Alumnos')

@section('content')
    <!-- Formulario para cargar el archivo Excel -->
    <form action="{{ route('alumnos.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <label for="file" class="form-label">Seleccionar archivo Excel</label>
                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary mt-4">Importar Alumnos</button>
            </div>
        </div>
    </form>

    <h1 class="h3">Lista de Alumnos</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Apellidos</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Estado</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->rut_alumno }}</td>
                    <td>{{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</td>
                    <td>{{ $alumno->nombre_alumno }}</td>
                    <td>{{ $alumno->carrera }}</td>
                    <td>{{ $alumno->estado_alumno }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection