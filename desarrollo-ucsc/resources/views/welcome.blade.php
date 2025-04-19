@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Noticias</h2>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">Panel Admin</a>
            @endif
        @endauth
    </div>

    <div class="row">
        <!-- Noticias -->
        <div class="col-md-8">
            @foreach ($noticias as $noticia)
            <div class="card mb-3">
                <div class="row g-0">
                    @if ($noticia->imagen)
                    <div class="col-md-4">
                        <img src="{{ asset('storage/' . $noticia->imagen) }}" class="img-fluid rounded-start" alt="Noticia">
                    </div>
                    @endif
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $noticia->titulo }}</h5>
                            <p class="card-text">{{ Str::limit($noticia->contenido, 120) }}</p>
                            <p class="card-text"><small class="text-muted">{{ $noticia->created_at->format('d M Y') }}</small></p>
                            <a href="#" class="btn btn-sm btn-primary">Leer más</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Actividades -->
        <div class="col-md-4">
            <h4 class="mb-3">Actividades de esta semana</h4>
            @foreach ($actividades as $actividad)
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">{{ $actividad->titulo }}</h6>
                    <p class="card-text">{{ $actividad->descripcion }}</p>
                    <p class="card-text"><small class="text-muted">{{ $actividad->fecha->format('d M Y') }}</small></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<footer class="text-center mt-5 py-3 bg-light">
    <small>&copy; {{ now()->year }} gymUCSC. Todos los derechos reservados.</small>
</footer>
@endsection
