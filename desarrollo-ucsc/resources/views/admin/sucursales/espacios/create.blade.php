@extends('layouts.app')

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

        <input type="hidden" name="id_suc" value="{{ session('sucursal_activa') }}">

        <button type="submit" class="btn btn-primary">Crear Espacio</button>
        <a href="{{ route('espacios.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
