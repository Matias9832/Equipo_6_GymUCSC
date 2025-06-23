@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Noticia')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Noticias'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Editar noticia</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($news->images && $news->images->count())
                            <div class="mb-3">
                                <hr class="visually-hidden">
                                <label class="form-label">Imágenes actuales</label>
                                <div class="row g-3">
                                    @foreach($news->images as $image)
                                        <div class="col-md-3 position-relative">
                                            <div style="width: 100%; height: 200px; overflow: hidden; border-radius: 0.5rem; position: relative;">
                                                <img src="{{ global_asset($image->image_path) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
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
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('news.update', $news->id_noticia) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="images" class="form-label">Subir nuevas imágenes</label>
                                <input type="file" name="images[]" id="imageInput" multiple class="form-control">
                            </div>
                            <div id="imagePreviewContainer" class="row g-3 mt-3"></div>

                            <div class="form-group">
                                <label for="nombre_noticia">Título</label>
                                <input type="text" name="nombre_noticia" class="form-control" placeholder="Título de la noticia"
                                    value="{{ old('nombre_noticia', $news->nombre_noticia) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion_noticia">Contenido</label>
                                <textarea name="descripcion_noticia" class="form-control" placeholder="Cuerpo de la noticia" rows="4" required>{{ old('descripcion_noticia', $news->descripcion_noticia) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="tipo_deporte" class="form-label">Categoría</label>
                                <select class="form-control" id="tipo_deporte" name="tipo_deporte" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($deportes as $deporte)
                                        <option value="{{ $deporte->nombre_deporte }}" 
                                            {{ (old('tipo_deporte', $news->tipo_deporte) == $deporte->nombre_deporte) ? 'selected' : '' }}>
                                            {{ $deporte->nombre_deporte }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-check mb-3">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                    {{ (old('is_featured') ?? $news->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    <i class="fas fa-star text-warning me-1"></i> ¿Marcar como noticia destacada?
                                </label>
                            </div>

                            <div class="mb-3" id="featured_until_container" style="display: none;">
                                <label class="form-label">Tiempo hasta que sea destacada (opcional)</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="featured_date" name="featured_date" placeholder="Fecha"
                                            autocomplete="off"
                                            value="{{ old('featured_date', $news->featured_until ? \Carbon\Carbon::parse($news->featured_until)->format('Y-m-d') : '') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="featured_time" name="featured_time" placeholder="Hora"
                                            autocomplete="off"
                                            value="{{ old('featured_time', $news->featured_until ? \Carbon\Carbon::parse($news->featured_until)->format('H:i') : '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button class="btn btn-primary mt-2">Actualizar</button>
                                <a href="{{ route('news.index') }}" class="btn btn-outline-secondary mt-2">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@section('custom-css')
<style>
    .form-check-label i.text-warning {
        vertical-align: middle;
    }
</style>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mostrar/ocultar el campo de fecha según el checkbox
        const isFeatured = document.getElementById('is_featured');
        const featuredUntilContainer = document.getElementById('featured_until_container');

        function toggleFeaturedUntil() {
            featuredUntilContainer.style.display = isFeatured.checked ? 'block' : 'none';
        }

        // Inicializa el estado al cargar
        toggleFeaturedUntil();

        isFeatured.addEventListener('change', toggleFeaturedUntil);

        // Flatpickr para la fecha (solo días desde hoy)
        flatpickr("#featured_date", {
            dateFormat: "Y-m-d",
            minDate: "today",
            locale: "es"
        });

        // Flatpickr para la hora
        flatpickr("#featured_time", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            locale: "es"
        });

        // Preview de imágenes nuevas
        const input = document.getElementById('imageInput');
        const previewContainer = document.getElementById('imagePreviewContainer');
        input.addEventListener('change', function () {
            previewContainer.innerHTML = '';
            Array.from(input.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3');
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = '200px';
                    img.style.objectFit = 'cover';
                    img.classList.add('rounded');
                    col.appendChild(img);
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        });
    });
</script>    