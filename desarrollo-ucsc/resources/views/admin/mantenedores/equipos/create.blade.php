@extends('layouts.app')

@section('title', 'Crear Equipo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Equipo'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('equipos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre_equipo" class="form-label">Nombre del Equipo</label>
                    <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_deporte" class="form-label">Deporte</label>
                    <select name="id_deporte" id="id_deporte" class="form-select" required>
                        <option value="">Seleccione un deporte</option>
                        @foreach($deportes as $deporte)
                            <option value="{{ $deporte->id_deporte }}">{{ $deporte->nombre_deporte }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Crear Equipo</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
