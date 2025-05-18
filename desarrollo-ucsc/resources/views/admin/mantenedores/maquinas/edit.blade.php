@extends('layouts.app')

@section('title', 'Editar Máquina')

@section('content')
    <h1 class="h3">Editar Máquina</h1>
    <form action="{{ route('maquinas.update', $maquina->id_maq) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre_maq" class="form-label">Nombre</label>
            <input type="text" name="nombre_maq" id="nombre_maq" class="form-control" value="{{ $maquina->nombre_maq }}" required>
        </div>
        <div class="mb-3">
            <label for="estado_maq" class="form-label">Estado</label>
            <select name="estado_maq" id="estado_maq" class="form-control" required>
                <option value="1" {{ $maquina->estado_maq ? 'selected' : '' }}>Disponible</option>
                <option value="0" {{ !$maquina->estado_maq ? 'selected' : '' }}>En mantenimineto</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('maquinas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection