@extends('layouts.app')

@section('title', 'Crear Ciudad')

@section('content')
    <h1 class="h3">Crear Ciudad</h1>
    <form action="{{ route('ciudades.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_region" class="form-label">Región</label>
            <select name="id_region" id="id_region" class="form-control" required>
                <option value="">Seleccione una región</option>
                @foreach($regiones as $region)
                    <option value="{{ $region->id_region }}">{{ $region->nombre_region }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nombre_ciudad" class="form-label">Nombre</label>
            <input type="text" name="nombre_ciudad" id="nombre_ciudad" class="form-control" placeholder="Nombre de la ciudad" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Ciudad</button>
        <a href="{{ route('ciudades.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection