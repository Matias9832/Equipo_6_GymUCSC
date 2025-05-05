@extends('layouts.app')
@if(session('success') || session('update') || session('delete'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100; margin-top: 70px;">
        <div id="toastSuccess" class="toast align-items-center { { session('success') ? 'text-bg-success' : (session('update') ? 'text-bg-primary' : 'text-bg-danger') }} border-0 show" 
     style="background: none; box-shadow: none;" 
     role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    @if (session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @elseif (session('update'))
                        <div class="alert alert-warning text-center">
                            {{ session('update') }}
                        </div>
                    @elseif (session('delete'))
                        <div class="alert alert-danger text-center">
                            {{ session('delete') }}
                        </div>
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastLiveExample = document.getElementById('toastSuccess');
            if (toastLiveExample) {
                const toast = new bootstrap.Toast(toastLiveExample, {
                    delay: 3000 // Se cierra a los 3 segundos
                });
                toast.show();
            }
        });
    </script>
@endif
@section('title', 'Noticias')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <h4 class="mb-4">Noticias</h4>
        @auth
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-person-circle me-2"></i>
                ¡Hola {{ Auth::user()->name }}! Bienvenido(a) al portal de noticias del gimnasio.
            </div>
            
            {{-- Mostrar botón solo a administradores --}}
            @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('news.create') }}" class="btn btn-primary mb-4">Crear nueva noticia</a>
            @endif

        @endauth
        

        @if($news->isEmpty())
            <div class="card shadow-sm text-center p-5">
                <div class="card-body">
                    <i class="bi bi-info-circle display-4 text-secondary mb-3"></i>
                    <h5 class="card-title">No hay noticias disponibles</h5>
                    <p class="card-text text-muted">Vuelve pronto. Aquí aparecerán las últimas novedades del gimnasio.</p>
                </div>
            </div>
        @else
            @foreach($news as $item)
            <div class="card mb-4 shadow-sm">
                <div class="row g-0">
                    <div class="col-md-5">
                        @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid object-fit-cover rounded-start h-100" alt="{{ $item->title }}">
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <p class="text-muted mb-1">
                                <small>
                                    <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($item->published_at)->format('d M Y') }} |
                                    <i class="bi bi-tag"></i> {{ $item->category }} |
                                    <i class="bi bi-person"></i> {{ $item->author }}
                                </small>
                            </p>
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <p class="card-text">{{ Str::limit($item->content, 100) }}</p>
                            <a href="#" class="text-primary">Read more →</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
