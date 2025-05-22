@extends('layouts.app')

@section('title', 'Editar Marca')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Marca'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('marcas.update', $marca->id_marca) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre_marca" class="form-label">Nombre de la Marca</label>
                    <input type="text" name="nombre_marca" id="nombre_marca" class="form-control" value="{{ $marca->nombre_marca }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Logo actual</label><br>
                    <img src="{{ asset('storage/' . $marca->logo_marca) }}" alt="Logo" width="80" class="mb-2 rounded">
                    <input type="file" name="logo_marca" id="logo_marca" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="mision_marca" class="form-label">Misión</label>
                    <textarea name="mision_marca" id="mision_marca" class="form-control" required rows="3">{{ $marca->mision_marca }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="vision_marca" class="form-label">Visión</label>
                    <textarea name="vision_marca" id="vision_marca" class="form-control" required rows="3">{{ $marca->vision_marca }}</textarea>
                </div>
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
