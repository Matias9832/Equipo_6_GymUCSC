@extends('layouts.admin')

@section('title', 'Crear Tipo de Sanción')

@section('content')
    <h1 class="h3">Crear Tipo de Sanción</h1>
    <form action="{{ route('tipos_sancion.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_tipo_sancion" class="form-label">Nombre Sanción</label>
            <input type="text" name="nombre_tipo_sancion" id="nombre_tipo_sancion" class="form-control" placeholder="Nombre de la Sanción" required>
        </div>
        <div class="mb-3">
            <label for="descripcion_tipo_sancion">Descripción</label>
            <textarea name="descripcion_tipo_sancion" class="form-control" required>{{ old('descripcion_tipo_sancion') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Crear Tipo de Sanción</button>
        <a href="{{ route('tipos_sancion.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection