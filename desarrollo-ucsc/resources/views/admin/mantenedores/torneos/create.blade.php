@extends('layouts.app')

@section('title', 'Crear Torneo')

@section('content')
    <h1 class="h3">Crear Torneo</h1>
    <form action="{{ route('torneos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
            <input type="text" name="nombre_torneo" id="nombre_torneo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="id_sucursal" class="form-label">Sucursal</label>
            <select name="id_sucursal" id="id_sucursal" class="form-control" required>
                <option value="">Seleccione una sucursal</option>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id_suc }}">{{ $sucursal->nombre_suc }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_deporte" class="form-label">Deporte</label>
            <select name="id_deporte" id="id_deporte" class="form-control" required>
                <option value="">Seleccione un deporte</option>
                @foreach($deportes as $deporte)
                    <option value="{{ $deporte->id_deporte }}">{{ $deporte->nombre_deporte }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="max_equipos" class="form-label">Máximo de Equipos</label>
            <input type="number" name="max_equipos" id="max_equipos" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Torneo</button>
        <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection