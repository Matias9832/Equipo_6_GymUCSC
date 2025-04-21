@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>{{ $noticia->titulo }}</h1>
        <p class="text-muted">{{ $noticia->created_at->format('d M Y') }}</p>
        <hr>
        @if ($noticia->imagen)
            <img src="{{ asset($noticia->imagen) }}" alt="Imagen de la noticia" class="img-fluid">
        @endif
        <br>
        <div>
            {!! nl2br(e($noticia->contenido)) !!}
        </div>
        

        <a href="{{ route('noticias.index') }}" class="btn btn-secondary mt-4">← Volver</a>
    </div>
@endsection
