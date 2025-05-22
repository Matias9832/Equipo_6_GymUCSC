@extends('layouts.app')

@section('title', 'Crear Sucursal')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Sucursal'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4 p-4">
                <h2 class="h4 mb-4">Crear Sucursal</h2>

                <form action="{{ route('sucursales.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_ciudad" class="form-label">Ciudad</label>
                        <select name="id_ciudad" id="id_ciudad" class="form-select" required>
                            <option value="" selected disabled>Seleccione una ciudad</option>
                            @foreach($ciudades as $ciudad)
                                <option value="{{ $ciudad->id_ciudad }}">{{ $ciudad->nombre_ciudad }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_marca" class="form-label">Marca</label>
                        <select name="id_marca" id="id_marca" class="form-select" required>
                            <option value="" selected disabled>Seleccione una marca</option>
                            @foreach($marcas as $marca)
                                <option value="{{ $marca->id_marca }}">{{ $marca->nombre_marca }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_suc" class="form-label">Nombre</label>
                        <input type="text" name="nombre_suc" id="nombre_suc" class="form-control" placeholder="Nombre de la sucursal" required>
                    </div>

                    <div class="mb-4">
                        <label for="direccion_suc" class="form-label">Dirección</label>
                        <input type="text" name="direccion_suc" id="direccion_suc" class="form-control" placeholder="Dirección de la sucursal" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
