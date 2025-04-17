@extends('layouts.app')

@section('content')
    <h1>Crear Noticia</h1>

    <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
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

        <button class="btn btn-success mt-2">Guardar</button>
    </form>
@endsection
