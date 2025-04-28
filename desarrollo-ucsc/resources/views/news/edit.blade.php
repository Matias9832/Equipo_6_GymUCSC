@extends('layouts.app')

@section('content')
    <h1>Editar Noticia</h1>

    <form action="{{ route('news.update', $news -> id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Título:</label>
            <input type="text" name="titulo" class="form-control" value="{{ $news->titulo }}" required>
        </div>

        <div>
            <label>Contenido:</label>
            <input type="text" name="contenido" class="form-control" value="{{ $news->contenido }}" required>
        </div>
        <div>
            <label>Imagen:</label>
            <input type="file" name="imagen" class="form-control">

        <div>
            <label>Categoría:</label>
            <textarea name="category" class="form-control" required>{{ $news->category }}</textarea>
        </div>

        <button class="btn btn-primary mt-2">Actualizar</button>
     
    </form>
@endsection
