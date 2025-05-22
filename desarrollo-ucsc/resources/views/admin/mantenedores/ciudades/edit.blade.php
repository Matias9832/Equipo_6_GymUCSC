@extends('layouts.app')

@section('title', 'Editar Ciudad')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Ciudad'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('ciudades.update', $ciudad->id_ciudad) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="id_region" class="form-label">Región</label>
                    <select name="id_region" id="id_region" class="form-control" required>
                        @foreach($regiones as $region)
                            <option value="{{ $region->id_region }}" {{ $region->id_region == $ciudad->id_region ? 'selected' : '' }}>
                                {{ $region->nombre_region }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="nombre_ciudad" class="form-label">Nombre</label>
                    <input type="text" name="nombre_ciudad" id="nombre_ciudad" class="form-control" value="{{ $ciudad->nombre_ciudad }}" required>
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="{{ route('ciudades.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
