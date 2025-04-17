@foreach($noticias as $noticia)
    <div class="border p-3 mb-3">
        <h3>{{ $noticia->titulo }}</h3>
        <p>{{ $noticia->contenido }}</p>
        
        @if($noticia->imagen)
            <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen de la noticia" class="img-fluid mt-2">
        @endif
        
        <small>{{ $noticia->created_at->format('d M Y') }}</small>
        <div class="mt-2">
            <a href="{{ route('noticias.edit', $noticia) }}" class="btn btn-sm btn-warning">Editar</a>

            <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
@endforeach
