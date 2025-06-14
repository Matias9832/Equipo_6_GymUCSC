@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Crear Noticia')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Noticia'])
    <div class="container-fluid py-4">
        <div class="card">
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


                <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="images" class="form-label">Imágenes:</label>
                        <input type="file" name="images[]" id="imageInput" multiple class="form-control">
                    </div>

                    <div id="imagePreviewContainer" class="row g-3 mt-3"></div>

                    <div>
                        <label for="nombre_noticia" class="form-label">Título:</label>
                        <input type="text" name="nombre_noticia" class="form-control" required>
                    </div>

                    <div>
                        <label for="descripcion_noticia" class="form-label">Contenido:</label>
                        <textarea name="descripcion_noticia" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_deporte" class="form-label">Categoría</label>
                        <select class="form-control" id="tipo_deporte" name="tipo_deporte" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($deportes as $deporte)
                                <option value="{{ $deporte->nombre_deporte }}">{{ $deporte->nombre_deporte }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
                            {{ old('is_featured')=='1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning me-1"></i> ¿Marcar como noticia destacada?
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="featured_until" class="form-label">
                            Tiempo hasta que sea destacada (opcional)
                        </label>
                        <input type="datetime-local" class="form-control" id="featured_until" name="featured_until"
                            value="{{ old('featured_until', isset($noticia) && $noticia->featured_until ? \Carbon\Carbon::parse($noticia->featured_until)->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                        <button class="btn btn-success mt-2">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const input = document.getElementById('imageInput');
        const previewContainer = document.getElementById('imagePreviewContainer');

        input.addEventListener('change', function () {
            previewContainer.innerHTML = ''; // Limpiar previews previos

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
