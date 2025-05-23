@extends('layouts.admin')

@section('title', 'Crear Deporte')

@section('content')
    <h1 class="h3">Crear Deporte</h1>
    <form action="{{ route('deportes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_deporte" class="form-label">Nombre</label>
            <input type="text" name="nombre_deporte" id="nombre_deporte" class="form-control" placeholder="Nombre del deporte" required>
        </div>
        <div class="mb-3">
            <label for="jugadores_por_equipo" class="form-label">Jugadores por Equipo</label>
            <input type="number" name="jugadores_por_equipo" id="jugadores_por_equipo" class="form-control" placeholder="Número de jugadores por equipo">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Descripción del deporte"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Crear Deporte</button>
        <a href="{{ route('deportes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection