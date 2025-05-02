@extends('layouts.admin')

@section('title', 'Crear Espacios')

@section('content')
    <h1 class="h3">Crear Espacios</h1>
    <form action="{{ route('espacios.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_espacio" class="form-label">Nombre</label>
            <input type="text" name="nombre_espacio" id="nombre_espacio" class="form-control" placeholder="Nombre del espacio" required>
        </div>
        <div class="mb-3">
            <label for="tipo_espacio" class="form-label">Tipo de espacio</label>
            <select name="tipo_espacio" id="tipo_espacio" class="form-select" required>
                <option value="">Seleccione un tipo</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre_tipo }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="mb-3">
            <label for="id_suc" class="form-label">Sucursal</label>
            <input type="text" name="id_suc" id="id_suc" class="form-control" placeholder="ID sucursal" required>
        </div>
        <!--select name="tipo" required>
            <option value="cancha">Cancha</option>
            <option value="piscina">Piscina</option>
            <option value="tenis">Tenis</option>
        </select><br-->
    
        
        <!--select name="sucursal_id" required>
            @ foreach($sucursales as $sucursal)
                <option value="{ { $sucursal->id }}">{ { $sucursal->nombre }}</option>
            @ endforeach
        </select><br-->
        
        <!--borrar esta linea cuando se agreguen las sucursales y descomentar lo de arriba-->
       
        <button type="submit" class="btn btn-primary">Crear Espacio</button>
        <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection