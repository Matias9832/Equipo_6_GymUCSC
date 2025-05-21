<!-- RECORDAR QUE PARA HACER UN UPDATE SE DEBE IMPORTAR UN EXCEL CON LAS TABLAS ORDENADAS CORRECTAMENTE -->
@extends('layouts.app')

@section('title', 'Editar Tipos de Espacio')

@section('content')
    <h1 class="h3">Editar Espacio</h1>
        
    <form action="{{ route('tipos_espacio.update', $tipo) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_tipo" class="form-label">Nombre</label>
            <input type="text" name="nombre_tipo" id="nombre_tipo" class="form-control" value="{{ $tipo->nombre_tipo }}" required>
        </div>
        

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('tipos_espacio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

@endsection