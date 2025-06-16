@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Docentes'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Editar información del docente</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('docentes.update', $administrador->id_admin) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre_admin" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_admin" name="nombre_admin"
                                   value="{{ old('nombre_admin', $administrador->nombre_admin) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo_usuario" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo_usuario" name="correo_usuario"
                                   value="{{ old('correo_usuario', $usuario->correo_usuario) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_cargo" class="form-label">Descripción del Cargo</label>
                            <input type="text" name="descripcion_cargo" id="descripcion_cargo" class="form-control"
                                   value="{{ old('descripcion_cargo', $administrador->descripcion_cargo) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol (Relacionado a los permisos) </label>
                            <select name="rol" class="form-control" required>
                                <option value="Docente" {{ $usuario->hasRole('Docente') ? 'selected' : '' }}>Docente</option>
                                <option value="Coordinador" {{ $usuario->hasRole('Coordinador') ? 'selected' : '' }}>Coordinador</option>
                                <option value="Visor QR" {{ $usuario->hasRole('Visor QR') ? 'selected' : '' }}>Visor QR</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footers.auth.footer')
@endsection
