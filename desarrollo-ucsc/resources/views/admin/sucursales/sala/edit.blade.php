@extends('layouts.admin')

@section('title', 'Editar Sala')

@section('content')
    <h1>Editar Sala</h1>

    <form action="{{ route('salas.update', $sala) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre_sala" class="form-label">Nombre de la Sala</label>
            <input type="text" name="nombre_sala" id="nombre_sala" class="form-control" value="{{ $sala->nombre_sala }}" required>
        </div>

        <div class="mb-3">
            <label for="aforo_sala" class="form-label">Aforo</label>
            <input type="number" name="aforo_sala" id="aforo_sala" class="form-control" value="{{ $sala->aforo_sala }}" required>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('salas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
