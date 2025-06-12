@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nueva Noticia</h1>
    <form action="{{ route('academynews.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre Noticia</label>
            <input type="text" name="nombre_noticia" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Contenido</label>
            <textarea name="descripcion_noticia" class="form-control" required></textarea>
        </div>        
        <div class="form-check">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input">
            <label class="form-check-label">Destacar noticia</label>
        </div>
        <div class="form-group">
            <label>Destacada hasta (opcional)</label>
            <input type="datetime-local" name="featured_until" class="form-control">
        </div>
        <button class="btn btn-primary mt-3">Guardar</button>
    </form>
</div>
@endsection
