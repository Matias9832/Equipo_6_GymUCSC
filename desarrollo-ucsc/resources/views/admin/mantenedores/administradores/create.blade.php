@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Administradores'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Registrar nuevo administrador</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('administradores.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="rut_admin" class="form-label">RUT</label>
                            <input type="text" name="rut_admin" id="rut_admin" class="form-control" placeholder="RUT del usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="nombre_admin" class="form-label">Nombre</label>
                            <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" placeholder="Nombre del administrador" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select name="rol" id="rol" class="form-control" required>
                                <option value="">Selecciona un rol</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol }}">{{ $rol }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="correo_usuario" class="form-label">Correo</label>
                            <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" placeholder="Correo del usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_cargo" class="form-label">Descripción del Cargo</label>
                            <input type="text" name="descripcion_cargo" id="descripcion_cargo" class="form-control" placeholder="Ej: Coordinador de talleres " required>
                        </div>
                        <div class="mb-3">
                            <label for="sucursal_id" class="form-label">Sucursal</label>
                            <select name="sucursal_id" id="sucursal_id" class="form-control" required>
                                <option value="">Selecciona una sucursal</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id_suc }}">{{ $sucursal->nombre_suc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('administradores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>        
</div>
@endsection
