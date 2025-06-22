@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Noticias Talleres'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Editar noticia</h5>
                    </div>
                    <div class="card-body">
                        @if ($newstalleres->images && $newstalleres->images->count())
                            <div class="mb-3">
                                <hr class="visually-hidden">
                                <label class="form-label">Imágenes actuales</label>
                                <div class="row g-3">
                                    @foreach($newstalleres->images as $image)
                                        <div class="col-md-3 position-relative">
                                            <div style="width: 100%; height: 200px; overflow: hidden; border-radius: 0.5rem; position: relative;">
                                                <img src="{{ global_asset($image->image_path) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">

                                                {{-- Botón eliminar imagen, fuera del formulario principal --}}
                                                <form action="{{ route('newsTalleres.image.destroy', $image->id_imagen) }}" method="POST"
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

                            <form action="{{ route('talleresnews.update', $newstalleres->id_noticia) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="images" class="form-label">Subir nuevas imágenes</label>
                                    <input type="file" name="images[]" multiple class="form-control">
                                </div>
                                    
                                <div class="mb-3">
                                    <label for="nombre_noticia" class="form-label">Título:</label>
                                    <input type="text" name="nombre_noticia" class="form-control" value="{{ old('nombre_noticia', $newstalleres->nombre_noticia) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion_noticia" class="form-label">Contenido:</label>
                                    <textarea name="descripcion_noticia" class="form-control" rows="4" required>{{ old('descripcion_noticia', $newstalleres->descripcion_noticia) }}</textarea>
                                </div>

                                <div class="form-check mb-3">
                                    <input type="hidden" name="is_featured" value="0">
                                    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                    {{ (old('is_featured') ?? $newstalleres->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i> Marcar como noticia destacada
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <label for="featured_until" class="form-label">
                                        Tiempo hasta que sea destacada (opcional)
                                    </label>
                                    <input type="datetime-local" class="form-control" id="featured_until" name="featured_until"
                                        value="{{ old('featured_until', $newstalleres->featured_until ? \Carbon\Carbon::parse($newstalleres->featured_until)->format('Y-m-d\TH:i') : '') }}">

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button class="btn btn-primary mt-2">Actualizar</button>
                                    <a href="{{ route('talleresnews.index') }}" class="btn btn-outline-secondary mt-2">Cancelar</a>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>    
        @include('layouts.footers.auth.footer')
    </div>

@endsection

<script>
    function eliminarImagen(id) {
    fetch(`/noticias-talleres/imagen/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Imagen eliminada');
            // Aquí puedes eliminar el nodo del DOM si deseas
        }
    });
}

</script>


