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
            <input type="text" name="nombre_espacio" id="nombre_espacio" class="form-control" value="{{ $espacio->nombre }}" required>
        </div>
        <div class="mb-3">
            <label for="tipo_espacio" class="form-label">Tipo de espacio</label>
            <input type="text" name="tipo_espacio" id="tipo_espacio" class="form-control" value="{{ $espacio->tipo_espacio }}" required>
        </div>
    
        <div class="mb-3">
            <label for="id_suc" class="form-label">Sucursal</label>
            <input type="text" name="id_suc" id="id_suc" class="form-control" value="{{ $espacio->sucursal }}" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

@endsection