@extends('layouts.app')

@section('content')
    <h1>Crear Noticia</h1>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div>
            <label for="images" class="form-label">Imagenes:</label>
            <input type="file" name="images[]" multiple class="form-control">
        </div>

        <div>
            <label for="nombre_noticia" class="form-label">Título:</label>
            <input type="text" name="nombre_noticia" class="form-control" required>
        </div>

        <div>
            <label for="descripcion_noticia" class="form-label">Contenido:</label>
            <textarea name="descripcion_noticia" class="form-control" required></textarea>
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
        

        <button class="btn btn-success mt-2">Guardar</button>
    </form>
@endsection
