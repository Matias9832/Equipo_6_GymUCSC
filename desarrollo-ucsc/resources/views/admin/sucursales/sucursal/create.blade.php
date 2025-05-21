@extends('layouts.app')

@section('title', 'Crear Sucursal')

@section('content')
    <h1 class="h3">Crear Sucursal</h1>

    <form action="{{ route('sucursales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_ciudad" class="form-label">Ciudad</label>
            <select name="id_ciudad" id="id_ciudad" class="form-control" required>
                <option value="">Seleccione una ciudad</option>
                @foreach($ciudades as $ciudad)
                    <option value="{{ $ciudad->id_ciudad }}">{{ $ciudad->nombre_ciudad }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_marca" class="form-label">Marca</label>
            <select name="id_marca" id="id_marca" class="form-control" required>
                <option value="">Seleccione una marca</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id_marca }}">{{ $marca->nombre_marca }}</option>
                @endforeach
            </select>
        </div>

        
        <div class="mb-3">
            <label for="nombre_suc" class="form-label">Nombre</label>
            <input type="text" name="nombre_suc" id="nombre_suc" class="form-control" required
                placeholder="Nombre de la sucursal">
        </div>

        <div class="mb-3">
            <label for="direccion_suc" class="form-label">Dirección</label>
            <input type="text" name="direccion_suc" id="direccion_suc" class="form-control" required
                placeholder="Dirección de la sucursal">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection