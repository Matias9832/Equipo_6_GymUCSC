@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Sucursal')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar Sucursal'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow rounded-4 p-4">
                    <h2 class="h4 mb-4">Editar Sucursal</h2>

                    <form action="{{ route('sucursales.update', $sucursal->id_suc) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_ciudad" class="form-label">Ciudad</label>
                            <select name="id_ciudad" id="id_ciudad" class="form-select" required>
                                <option value="" disabled>Seleccione una ciudad</option>
                                @foreach($ciudades as $ciudad)
                                    <option value="{{ $ciudad->id_ciudad }}" @if($ciudad->id_ciudad == $sucursal->id_ciudad)
                                    selected @endif>
                                        {{ $ciudad->nombre_ciudad }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="id_marca" value="{{ $marca->id_marca }}">

                        <div class="mb-3">
                            <label for="nombre_suc" class="form-label">Nombre</label>
                            <input type="text" name="nombre_suc" id="nombre_suc" class="form-control"
                                value="{{ old('nombre_suc', $sucursal->nombre_suc) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="direccion_suc" class="form-label">Dirección</label>
                            <input type="text" name="direccion_suc" id="direccion_suc" class="form-control"
                                value="{{ old('direccion_suc', $sucursal->direccion_suc) }}" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('sucursales.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection