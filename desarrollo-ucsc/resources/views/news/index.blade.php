@extends('layouts.app')

@section('content')
<div class="container py-4">  

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
                    <a href="{{ route('news.edit', $noticia) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('news.destroy', $noticia) }}" method="POST" class="d-inline">
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

