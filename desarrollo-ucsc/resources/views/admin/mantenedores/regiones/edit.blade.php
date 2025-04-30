@extends('layouts.admin')

@section('title', 'Editar Región')

@section('content')
    <h1 class="h3">Editar Región</h1>
    <form action="{{ route('regiones.update', $region->id_region) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="id_pais" class="form-label">País</label>
            <select name="id_pais" id="id_pais" class="form-control" required>
                @foreach($paises as $pais)
                    <option value="{{ $pais->id_pais }}" {{ $pais->id_pais == $region->id_pais ? 'selected' : '' }}>
                        {{ $pais->nombre_pais }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nombre_region" class="form-label">Nombre</label>
            <input type="text" name="nombre_region" id="nombre_region" class="form-control" value="{{ $region->nombre_region }}" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('regiones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection