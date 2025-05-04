@extends('layouts.admin')

@section('title', 'Seleccionar Sala')

@section('content')
<div class="container">
    <h1 class="mb-4">Seleccionar Sala y Aforo</h1>

    <form action="{{ route('control-salas.generarQR') }}" method="POST">
        @csrf

        {{-- Seleccionar sala --}}
        <div class="mb-3">
            <label for="id_sala" class="form-label">Sala:</label>
            <select name="id_sala" id="id_sala" class="form-select" required>
                @foreach ($salas as $sala)
                    <option value="{{ $sala->id_sala }}">
                        {{ $sala->nombre_sala }} (Máx: {{ $sala->aforo_sala }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Seleccionar aforo --}}
        <div class="mb-3">
            <label for="aforo" class="form-label">Aforo permitido:</label>
            <input type="number" name="aforo" id="aforo" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Generar QR</button>
    </form>
</div>
@endsection
