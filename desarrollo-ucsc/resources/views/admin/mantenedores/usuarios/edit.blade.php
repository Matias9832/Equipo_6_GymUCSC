@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Usuario')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar Usuario'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Editar Usuario</h2>
                    </div>

                    <form action="{{ route('usuarios.update', $usuario->id_usuario) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre_admin" class="form-label">Nombre</label>
                            <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" value="{{ $administrador->nombre_admin }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="rut" class="form-label">RUT</label>
                            <input type="text" name="rut" id="rut" class="form-control" value="{{ $usuario->rut }}"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="correo_usuario" class="form-label">Correo</label>
                            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control"
                                value="{{ $usuario->correo_usuario }}" required>
                            <input type="hidden" name="correo_antiguo" id="correo_antiguo" class="form-control"
                                value="{{ $usuario->correo_usuario }}">
                        </div>

                        @if($usuario->tipo_usuario === 'admin')
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="Docente" {{ $usuario->hasRole('Docente') ? 'selected' : '' }}>Docente
                                    </option>
                                    <option value="Coordinador" {{ $usuario->hasRole('Coordinador') ? 'selected' : '' }}>
                                        Coordinador</option>
                                    <option value="Visor QR" {{ $usuario->hasRole('Visor QR') ? 'selected' : '' }}>Visor QR</option>
                                </select>
                            </div>
                        @else
                            <div class="mb-3">
                                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                                <select name="tipo_usuario" id="tipo_usuario" class="form-control" required>
                                    <option value="estudiante" {{ $usuario->tipo_usuario == 'estudiante' ? 'selected' : '' }}>
                                        Estudiante</option>
                                    <option value="seleccionado" {{ $usuario->tipo_usuario == 'seleccionado' ? 'selected' : '' }}>
                                        Seleccionado</option>
                                </select>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection