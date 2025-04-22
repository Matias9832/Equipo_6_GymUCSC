@extends('layouts.app')

@section('content')
<div class="container py-4">
    @auth
        <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bi bi-person-circle me-2"></i>
            ¡Hola, {{ Auth::user()->name }}! Bienvenido(a) al portal de noticias del gimnasio.
        </div>
    @endauth

    {{-- Mostrar botón solo a administradores --}}
    @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('noticias.create') }}" class="btn btn-primary mb-4">Crear nueva noticia</a>
    @endif

    @foreach($news as $noticia)
        <div class="border p-3 mb-3 rounded bg-white shadow">
            <h3 class="text-xl font-semibold">{{ $noticia->titulo }}</h3>
            <p class="mt-2">{{ $noticia->contenido }}</p>
            
            @if($noticia->imagen)
                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia" class="img-fluid mt-2" style="max-width: 100%; height: auto;">
            @endif

            <small class="text-muted d-block mt-2">{{ $noticia->created_at->format('d M Y') }}</small>
            
            {{-- Mostrar opciones solo a administradores --}}
            @if(Auth::check() && Auth::user()->is_admin)
                <div class="mt-3">
                    <a href="{{ route('noticias.edit', $noticia) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta noticia?')">Eliminar</button>
                    </form>
                </div>
            @endif
        </div>
    @endforeach

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $news->links() }}
    </div>
</div>
@endsection

