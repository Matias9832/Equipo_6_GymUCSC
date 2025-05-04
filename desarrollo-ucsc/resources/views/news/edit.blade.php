@extends('layouts.app')

@section('content')
<h1>Editar Noticia</h1>

@if ($news->images && $news->images->count())
    <div class="mb-3">
        <hr class="visually-hidden">
        <label class="form-label">Imágenes actuales</label>
        <div class="row g-3">
            @foreach($news->images as $image)
                <div class="col-md-3 position-relative">
                    <div style="width: 100%; height: 200px; overflow: hidden; border-radius: 0.5rem; position: relative;">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             style="width: 100%; height: 100%; object-fit: cover;">

                        {{-- Botón eliminar imagen, fuera del formulario principal --}}
                        <form action="{{ route('news.image.destroy', $image->id_imagen) }}" method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar esta imagen?');"
                              style="position: absolute; top: 5px; right: 5px; z-index: 10;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1"
                                    style="border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                &times;
                            </button>
                        </form>

                        {{-- Campo oculto para marcar imágenes a eliminar --}}
                        <input type="checkbox" name="delete_images[]" value="{{ $image->id_imagen }}" class="d-none">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<form action="{{ route('news.update', $news->id_noticia) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div>
        <label for="images" class="form-label">Subir nuevas imágenes</label>
        <input type="file" name="images[]" multiple class="form-control">
    </div>
        
    <div>
        <label for="nombre_noticia" class="form-label">Título:</label>
        <input type="text" name="nombre_noticia" class="form-control" value="{{ old('nombre_noticia', $news->nombre_noticia) }}" required>
    </div>

    <div>
        <label for="descripcion_noticia" class="form-label">Contenido:</label>
        <textarea name="descripcion_noticia" class="form-control" required>{{ $news->descripcion_noticia }}</textarea>
    </div>

    <div>
        <label>Categoría:</label>
        <select class="form-control" id="tipo_deporte" name="tipo_deporte" required>
            <option value="">Seleccione una categoría</option>
            @foreach($deportes as $deporte)
                <option value="{{ $deporte->nombre_deporte }}" 
                    {{ $news->tipo_deporte == $deporte->nombre_deporte ? 'selected' : '' }}>
                    {{ $deporte->nombre_deporte }}
                </option>
            @endforeach
        </select>
        
    </div>

    <button class="btn btn-primary mt-2">Actualizar</button>
</form>
@endsection

