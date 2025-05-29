@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Usuario')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Usuario'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow rounded-4 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h4 mb-0">Crear Usuario</h2>
                    </div>

                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rut" class="form-label">RUT</label>
                            <input type="text" name="rut" id="rut" class="form-control" placeholder="RUT del usuario"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="nombre_admin" class="form-label">Nombre</label>
                            <input type="text" name="nombre_admin" id="nombre_admin" class="form-control"
                                placeholder="Nombre del usuario" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo_usuario" class="form-label">Correo</label>
                            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control"
                                placeholder="Correo del usuario" required>
                        </div>

                        <div class="mb-4">
                            <label for="rol" class="form-label">Rol de usuario</label>
                            <select name="rol" id="rol" class="form-control" required>
                                <option value="">Selecciona un rol</option>
                                <option value="Docente">Docente</option>
                                <option value="Coordinador">Coordinador</option>
                                <option value="Visor QR">Visor QR</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection