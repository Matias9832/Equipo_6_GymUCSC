@extends('layouts.app')

@section('title', 'Editar Máquina')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Máquina'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('maquinas.update', $maquina->id_maq) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre_maq" class="form-label">Nombre</label>
                    <input type="text" name="nombre_maq" id="nombre_maq" class="form-control" value="{{ $maquina->nombre_maq }}" required>
                </div>
                <div class="mb-3">
                    <label for="estado_maq" class="form-label">Estado</label>
                    <select name="estado_maq" id="estado_maq" class="form-select" required>
                        <option value="1" {{ $maquina->estado_maq ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ !$maquina->estado_maq ? 'selected' : '' }}>En mantenimiento</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="{{ route('maquinas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
