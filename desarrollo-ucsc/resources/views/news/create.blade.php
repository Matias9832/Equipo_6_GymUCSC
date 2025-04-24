@extends('layouts.app')

@section('content')
    <h1>Crear Noticia</h1>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label>Título:</label>
            <input type="text" name="titulo" class="form-control" required>
        </div>

        <div>
            <label>Contenido:</label>
            <textarea name="contenido" class="form-control" required></textarea>
        </div>

        <div>
            <label>Imagen:</label>
            <input type="file" name="imagen" class="form-control">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        

        <button class="btn btn-success mt-2">Guardar</button>
    </form>
@endsection
