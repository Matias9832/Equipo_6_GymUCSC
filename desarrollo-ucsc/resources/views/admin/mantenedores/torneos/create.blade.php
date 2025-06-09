@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Torneo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Torneo'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('torneos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
                    <input type="text" name="nombre_torneo" id="nombre_torneo" class="form-control" required>
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
                <div class="mb-3">
                    <label for="tipo_competencia" class="form-label">Tipo de Competencia</label>
                    <select name="tipo_competencia" id="tipo_competencia" class="form-select" required>
                        <option value="">Seleccione un tipo de competencia</option>
                        <option value="liga">Liga</option>
                        <option value="copa">Copa</option>
                        <option value="encuentro">Encuentro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="max_equipos" class="form-label">Máximo de Equipos</label>
                    <input type="number" name="max_equipos" id="max_equipos" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Torneo</button>
                <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection