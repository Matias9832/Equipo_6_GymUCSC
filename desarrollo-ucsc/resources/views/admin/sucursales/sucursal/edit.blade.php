@extends('layouts.app')

@section('title', 'Editar Sucursal')

@section('content')
    <h1 class="h3">Editar Sucursal</h1>
    <form action="{{ route('sucursales.update', $sucursal->id_suc) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_ciudad" class="form-label">Ciudad</label>
            <select name="id_ciudad" id="id_ciudad" class="form-control" required>
                <option value="">Seleccione una ciudad</option>
                @foreach($ciudades as $ciudad)
                    <option value="{{ $ciudad->id_ciudad }}" 
                            @if($ciudad->id_ciudad == $sucursal->id_ciudad) selected @endif>
                        {{ $ciudad->nombre_ciudad }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_marca" class="form-label">Marca</label>
            <select name="id_marca" id="id_marca" class="form-control" required>
                <option value="">Seleccione una marca</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id_marca }}" 
                            @if($marca->id_marca == $sucursal->id_marca) selected @endif>
                        {{ $marca->nombre_marca }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nombre_suc" class="form-label">Nombre</label>
            <input type="text" name="nombre_suc" id="nombre_suc" class="form-control" placeholder="Nombre de la sucursal" value="{{ old('nombre_suc', $sucursal->nombre_suc) }}" required>
        </div>

        <div class="mb-3">
            <label for="direccion_suc" class="form-label">Dirección</label>
            <input type="text" name="direccion_suc" id="direccion_suc" class="form-control" placeholder="Dirección de la sucursal" value="{{ old('direccion_suc', $sucursal->direccion_suc) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Sucursal</button>
        <a href="{{ route('sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
