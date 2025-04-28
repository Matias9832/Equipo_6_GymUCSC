@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $news->titulo }}</h1>

        @if ($news->imagen)
            <img src="{{ asset('storage/' . $news->imagen) }}" alt="Imagen de la noticia" class="img-fluid mb-3">
        @endif

        <p><strong>Categoría:</strong> {{ $news->category }}</p>
        <p><strong>Autor:</strong> {{ $news->author }}</p>
        <p><strong>Publicado el:</strong> {{ $news->published_at->format('d m Y') }}
            <strong>Por:</strong> {{ $news->author }}</p>
        </p>

        <div class="mt-4">
            {!! nl2br(e($news->contenido)) !!}
        </div>

        <a href="{{ url('/') }}" class="btn btn-primary mt-4">Volver al inicio</a>
    </div>
@endsection