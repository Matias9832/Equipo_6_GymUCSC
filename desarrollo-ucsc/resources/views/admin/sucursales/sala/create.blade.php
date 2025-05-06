@extends('layouts.admin')

@section('title', 'Crear Sala')

@section('content')
    <h1>Crear Sala</h1>

    <form action="{{ route('salas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre_sala" class="form-label">Nombre de la Sala</label>
            <input type="text" name="nombre_sala" id="nombre_sala" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="aforo_sala" class="form-label">Aforo</label>
            <input type="number" name="aforo_sala" id="aforo_sala" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Horario (Apertura - Cierre)</label>
            <div class="d-flex gap-2">
                <input type="time" name="horario_apertura" class="form-control" required>
                <span class="align-self-center">-</span>
                <input type="time" name="horario_cierre" class="form-control" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('salas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
