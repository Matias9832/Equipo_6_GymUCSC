@extends('layouts.app')

@section('content')
    <h1>Editar Noticia</h1>

    <form action="{{ route('news.update', $noticia) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Título:</label>
            <input type="text" name="titulo" class="form-control" value="{{ $noticia->titulo }}" required>
        </div>

        <div>
            <label>Contenido:</label>
            <textarea name="contenido" class="form-control" required>{{ $noticia->contenido }}</textarea>
        </div>

        <button class="btn btn-primary mt-2">Actualizar</button>
    </form>
@endsection
