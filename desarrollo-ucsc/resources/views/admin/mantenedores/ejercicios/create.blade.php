@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Ejercicio'])
    <div class="container-fluid py-4">
        <div class="card shadow rounded-4 p-4">
            {{-- Bloque de errores de validación --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('ejercicios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre') }}">
                </div>
                <div class="mb-3">
                    <label for="grupo_muscular" class="form-label">Grupo Muscular</label>
                    <select name="grupo_muscular" id="grupo_muscular" class="form-control" required>
                        <option value="">Selecciona un grupo muscular</option>
                        <option value="pecho" {{ old('grupo_muscular') == 'pecho' ? 'selected' : '' }}>Pecho</option>
                        <option value="espalda" {{ old('grupo_muscular') == 'espalda' ? 'selected' : '' }}>Espalda</option>
                        <option value="hombros" {{ old('grupo_muscular') == 'hombros' ? 'selected' : '' }}>Hombros</option>
                        <option value="bíceps" {{ old('grupo_muscular') == 'bíceps' ? 'selected' : '' }}>Bíceps</option>
                        <option value="tríceps" {{ old('grupo_muscular') == 'tríceps' ? 'selected' : '' }}>Tríceps</option>
                        <option value="abdominales" {{ old('grupo_muscular') == 'abdominales' ? 'selected' : '' }}>Abdominales</option>
                        <option value="cuádriceps" {{ old('grupo_muscular') == 'cuádriceps' ? 'selected' : '' }}>Cuádriceps</option>
                        <option value="isquiotibiales" {{ old('grupo_muscular') == 'isquiotibiales' ? 'selected' : '' }}>Isquiotibiales</option>
                        <option value="glúteos" {{ old('grupo_muscular') == 'glúteos' ? 'selected' : '' }}>Glúteos</option>
                        <option value="pantorrillas" {{ old('grupo_muscular') == 'pantorrillas' ? 'selected' : '' }}>Pantorrillas</option>
                        <option value="antebrazos" {{ old('grupo_muscular') == 'antebrazos' ? 'selected' : '' }}>Antebrazos</option>
                        <option value="trapecio" {{ old('grupo_muscular') == 'trapecio' ? 'selected' : '' }}>Trapecio</option>
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