@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Usuario')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar Usuario'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Editar Tipo de Usuario</h2>
                    </div>

                    <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            @php
                                    $alumno = $usuario->alumno;
                                    $nombreCompleto = $alumno ? "{$alumno->nombre_alumno} {$alumno->apellido_paterno} {$alumno->apellido_materno}" : 'Nombre no disponible';
                            @endphp
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" value="{{ $nombreCompleto}}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">RUT</label>
                            <input type="text" class="form-control" value="{{ $usuario->rut }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input type="email" class="form-control" value="{{ $usuario->correo_usuario }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                            <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                                <option value="estudiante" {{ $usuario->tipo_usuario == 'estudiante' ? 'selected' : '' }}>
                                    Estudiante</option>
                                <option value="seleccionado" {{ $usuario->tipo_usuario == 'seleccionado' ? 'selected' : '' }}>
                                    Seleccionado</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
