@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Nuevo Permiso')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Agregar Permiso'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Nuevo Permiso</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('plan.permisos.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nombre_permiso" class="form-label">Nombre del Permiso</label>
                                <input type="text" name="nombre_permiso" id="nombre_permiso" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="subpermisos" class="form-label">Subgrupo de Permiso</label>
                                <select name="subpermisos" id="subpermisos" class="form-control">
                                    <option value="">-- Seleccionar un subgrupo existente --</option>
                                    @foreach($subpermisos as $sub)
                                        <option value="{{ $sub }}">{{ $sub }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nuevo_subpermisos" class="form-label">... o ingresar uno nuevo</label>
                                <input type="text" name="nuevo_subpermisos" id="nuevo_subpermisos" class="form-control" placeholder="Ej: Mantenedor Docentes">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('plan.permisos.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Permiso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
