@extends('layouts.admin')

@section('title', 'Crear Máquina')

@section('content')
    <h1 class="h3">Crear Máquina</h1>
    <form action="{{ route('maquinas.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_maq" class="form-label">Nombre</label>
            <input type="text" name="nombre_maq" id="nombre_maq" class="form-control" placeholder="Nombre de la máquina" required>
        </div>
        <div class="mb-3">
            <label for="estado_maq" class="form-label">Estado</label>
            <select name="estado_maq" id="estado_maq" class="form-control" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Crear Máquina</button>
        <a href="{{ route('maquinas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection