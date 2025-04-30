@extends('layouts.admin')

@section('title', 'Crear País')

@section('content')
    <h1 class="h3">Crear País</h1>
    <form action="{{ route('paises.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre_pais" class="form-label">Nombre</label>
            <input type="text" name="nombre_pais" id="nombre_pais" class="form-control" placeholder="Nombre del país" required>
        </div>
        <div class="mb-3">
            <label for="bandera_pais" class="form-label">Bandera (URL)</label>
            <input type="text" name="bandera_pais" id="bandera_pais" class="form-control" placeholder="URL de la bandera" required oninput="previewImage()">
        </div>
        <div class="mb-3">
            <label class="form-label">Vista previa de la bandera:</label>
            <div>
                <img id="bandera_preview" src="" alt="Vista previa de la bandera" style="width: 100px; height: auto; display: none;">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Crear País</button>
        <a href="{{ route('paises.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    <script>
        function previewImage() {
            const url = document.getElementById('bandera_pais').value;
            const img = document.getElementById('bandera_preview');
            if (url) {
                img.src = url;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }
        }
    </script>
@endsection