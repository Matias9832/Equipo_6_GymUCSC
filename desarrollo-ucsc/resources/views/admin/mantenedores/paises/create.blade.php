@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear País')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear País'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('paises.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_pais" class="form-label">Nombre</label>
                            <input type="text" name="nombre_pais" id="nombre_pais" class="form-control" placeholder="Nombre del país" required>
                        </div>
                        <div class="mb-3">
                            <label for="bandera_pais" class="form-label">Bandera (URL)</label>
                            <input type="url" name="bandera_pais" id="bandera_pais" class="form-control" placeholder="URL de la bandera" required oninput="previewImage()">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vista previa de la bandera:</label>
                            <div>
                                <img id="bandera_preview" src="" alt="Vista previa de la bandera" style="width: 100px; height: auto; display: none;" class="rounded">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear País</button>
                        <a href="{{ route('paises.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
