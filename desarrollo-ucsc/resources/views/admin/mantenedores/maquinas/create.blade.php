@extends('layouts.app')

@section('title', 'Crear Máquina')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Máquina'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('maquinas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre_maq" class="form-label">Nombre</label>
                    <input type="text" name="nombre_maq" id="nombre_maq" class="form-control" placeholder="Nombre de la máquina" required>
                </div>
                <div class="mb-3">
                    <label for="estado_maq" class="form-label">Estado</label>
                    <select name="estado_maq" id="estado_maq" class="form-select" required>
                        <option value="1">Disponible</option>
                        <option value="0">En mantenimiento</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Crear Máquina</button>
                <a href="{{ route('maquinas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
