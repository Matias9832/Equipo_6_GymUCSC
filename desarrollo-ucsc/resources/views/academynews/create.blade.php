@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Noticias Academias'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header mb-0 pb-0">
                        <h5>Crear nueva noticia</h5>
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
                        <form action="{{ route('academynews.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="images" class="form-label">Imágenes:</label>
                                <input type="file" name="images[]" id="imageInput" multiple class="form-control">
                            </div>

                            <div id="imagePreviewContainer" class="row g-3 mt-3"></div>
                            <div class="form-group">
                                <label for="nombre_noticia">Título</label>
                                <input type="text" name="nombre_noticia" class="form-control" placeholder="Título de la noticia" required value="{{ old('nombre_noticia') }}">
                            </div>
                            <div class="form-group">
                                <label for="descripcion_noticia">Cuerpo</label>
                                <textarea name="descripcion_noticia" class="form-control" placeholder="Cuerpo de la noticia" required>{{ old('descripcion_noticia') }}</textarea>
                            </div>        
                            <div class="form-check mb-3">
                                <input type="hidden" name="is_featured" value="0">
                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                                    {{ old('is_featured')=='1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    <i class="fas fa-star text-warning me-1"></i> ¿Marcar como noticia destacada?
                                </label>
                            </div>
                            <!-- Fecha y hora de tiempo máximo de noticia destacada -->
                            <div class="mb-3" id="featured_until_container" style="display: none;">
                                <label class="form-label">Tiempo hasta que sea destacada (opcional)</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="featured_date" name="featured_date" placeholder="Fecha"
                                            autocomplete="off"
                                            value="{{ old('featured_date') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="featured_time" name="featured_time" placeholder="Hora"
                                            autocomplete="off"
                                            value="{{ old('featured_time') }}">
                                    </div>
                                </div>
                            </div>
                            <!--Botones de guardar y cancelar  -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button class="btn btn-primary mt-2">Guardar</button>
                                <a href="{{ route('academynews.index') }}" class="btn btn-outline-secondary mt-2">Cancelar</a>
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

@section('scripts')
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

        // Preview de imágenes
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
@endsection