<!-- RECORDAR QUE PARA HACER UN UPDATE SE DEBE IMPORTAR UN EXCEL CON LAS TABLAS ORDENADAS CORRECTAMENTE -->
@extends('layouts.admin')

@section('title', 'Editar Tipos de Sanción')

@section('content')
    <h1 class="h3">Editar Tipo de Sanción</h1>
        
    <form action="{{ route('tipos_sancion.update', $tipo) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_tipo_sancion" class="form-label">Nombre</label>
            <input type="text" name="nombre_tipo_sancion" id="nombre_tipo_sancion" class="form-control" value="{{ $tipo->nombre_tipo_sancion }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion_tipo_sancion">Descripción</label>
            <textarea name="descripcion_tipo_sancion" class="form-control" required>{{ old('descripcion_tipo_sancion', $tipo->descripcion_tipo_sancion) }}</textarea>
        </div>

        

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('tipos_sancion.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

@endsection