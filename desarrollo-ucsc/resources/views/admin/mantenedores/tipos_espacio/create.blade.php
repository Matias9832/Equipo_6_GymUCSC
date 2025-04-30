@extends('layouts.admin')

@section('title', 'Crear Tipo deEspacios')

@section('content')
    <h1 class="h3">Crear Tipos de Espacios</h1>
    <form action="{{ route('tipos_espacio.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_tipo" class="form-label">Nombre</label>
            <input type="text" name="nombre_tipo" id="nombre_tipo" class="form-control" placeholder="Nombre del espacio" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Crear Tipo de Espacio</button>
        <a href="{{ route('tipos_espacio.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection