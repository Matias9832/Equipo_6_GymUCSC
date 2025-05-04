<!-- RECORDAR QUE PARA HACER UN UPDATE SE DEBE IMPORTAR UN EXCEL CON LAS TABLAS ORDENADAS CORRECTAMENTE -->
@extends('layouts.admin')

@section('title', 'Editar Espacio')

@section('content')
    <h1 class="h3">Editar Espacio</h1>

    <form action="{{ route('espacios.update', $espacio) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_espacio" class="form-label">Nombre</label>
            <input type="text" name="nombre_espacio" id="nombre_espacio" class="form-control"
                value="{{ $espacio->nombre_espacio }}" required>
        </div>
        <div class="mb-3">
            <label for="tipo_espacio" class="form-label">Tipo de espacio</label>
             <select name="tipo_espacio" id="tipo_espacio" class="form-select" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ $tipo->id == $espacio->tipo_espacio ? 'selected' : '' }}>
                        {{ $tipo->nombre_tipo }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="mb-3">
            <label for="id_suc" class="form-label">Sucursal</label>
            <select name="id_suc" id="id_suc" class="form-select" required>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id_suc }}" {{ $sucursal->id_suc == $espacio->id_suc ? 'selected' : '' }}>
                        {{ $sucursal->nombre_suc }}
                    </option>
                @endforeach
            </select>
        </div>


        <input type="hidden" name="id_suc" value="{{ session('sucursal_activa') }}">

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

@endsection