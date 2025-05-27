@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Ejercicio'])
    <div class="container-fluid py-4">
        <div class="card shadow rounded-4 p-4">
            <form action="{{ route('ejercicios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="grupo_muscular" class="form-label">Grupo Muscular</label>
                    <select name="grupo_muscular" id="grupo_muscular" class="form-control" required>
                        <option value="">Selecciona un grupo muscular</option>
                        <option value="pecho">Pecho</option>
                        <option value="espalda">Espalda</option>
                        <option value="hombros">Hombros</option>
                        <option value="bíceps">Bíceps</option>
                        <option value="tríceps">Tríceps</option>
                        <option value="abdominales">Abdominales</option>
                        <option value="cuádriceps">Cuádriceps</option>
                        <option value="isquiotibiales">Isquiotibiales</option>
                        <option value="glúteos">Glúteos</option>
                        <option value="pantorrillas">Pantorrillas</option>
                        <option value="antebrazos">Antebrazos</option>
                        <option value="trapecio">Trapecio</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen (GIF)</label>
                    <input type="file" name="imagen" id="imagen" class="form-control" accept="image/gif">
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('ejercicios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Ejercicio</button>
                </div>
            </form>
        </div>
    </div>
@endsection