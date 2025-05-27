@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar Ejercicio'])
    <div class="container-fluid py-4">
        <div class="card shadow rounded-4 p-4">
            <form action="{{ route('ejercicios.update', $ejercicio->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $ejercicio->nombre }}" required>
                </div>
                <div class="mb-3">
                    <label for="grupo_muscular" class="form-label">Grupo Muscular</label>
                    <select name="grupo_muscular" id="grupo_muscular" class="form-control" required>
                        <option value="pecho" {{ $ejercicio->grupo_muscular == 'pecho' ? 'selected' : '' }}>Pecho</option>
                        <option value="espalda" {{ $ejercicio->grupo_muscular == 'espalda' ? 'selected' : '' }}>Espalda</option>
                        <option value="hombros" {{ $ejercicio->grupo_muscular == 'hombros' ? 'selected' : '' }}>Hombros</option>
                        <option value="bíceps" {{ $ejercicio->grupo_muscular == 'bíceps' ? 'selected' : '' }}>Bíceps</option>
                        <option value="tríceps" {{ $ejercicio->grupo_muscular == 'tríceps' ? 'selected' : '' }}>Tríceps</option>
                        <option value="abdominales" {{ $ejercicio->grupo_muscular == 'abdominales' ? 'selected' : '' }}>Abdominales</option>
                        <option value="cuádriceps" {{ $ejercicio->grupo_muscular == 'cuádriceps' ? 'selected' : '' }}>Cuádriceps</option>
                        <option value="isquiotibiales" {{ $ejercicio->grupo_muscular == 'isquiotibiales' ? 'selected' : '' }}>Isquiotibiales</option>
                        <option value="glúteos" {{ $ejercicio->grupo_muscular == 'glúteos' ? 'selected' : '' }}>Glúteos</option>
                        <option value="pantorrillas" {{ $ejercicio->grupo_muscular == 'pantorrillas' ? 'selected' : '' }}>Pantorrillas</option>
                        <option value="antebrazos" {{ $ejercicio->grupo_muscular == 'antebrazos' ? 'selected' : '' }}>Antebrazos</option>
                        <option value="trapecio" {{ $ejercicio->grupo_muscular == 'trapecio' ? 'selected' : '' }}>Trapecio</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('ejercicios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection