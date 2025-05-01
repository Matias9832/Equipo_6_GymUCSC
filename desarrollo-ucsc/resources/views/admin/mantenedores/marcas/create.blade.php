@extends('layouts.admin')

@section('title', 'Crear Marca')

@section('content')
    <h1 class="h3">Crear Marca</h1>
    <form action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nombre_marca" class="form-label">Nombre de la Marca</label>
            <input type="text" name="nombre_marca" id="nombre_marca" class="form-control" placeholder="Ej: GymUCSC" required>
        </div>
        <div class="mb-3">
            <label for="logo_marca" class="form-label">Logo</label>
            <input type="file" name="logo_marca" id="logo_marca" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mision_marca" class="form-label">Misión</label>
            <textarea name="mision_marca" id="mision_marca" class="form-control" placeholder="Misión de la marca" required></textarea>
        </div>
        <div class="mb-3">
            <label for="vision_marca" class="form-label">Visión</label>
            <textarea name="vision_marca" id="vision_marca" class="form-control" placeholder="Visión de la marca" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Crear Marca</button>
        <a href="{{ route('marcas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
