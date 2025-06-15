@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
@include('layouts.navbars.guest.navbar')
<div class="container my-4">
    
    <div class="bg-white border-radius-lg shadow-sm p-4" style="position: relative; z-index: 1000;">

        {{-- Si hay imágenes, muestro un carousel simple --}}
        @if($academynews->images->count())
            <div id="carouselNews{{ $academynews->id }}" class="carousel slide mb-4" data-bs-ride="carousel"
                style="height: 500px; overflow: hidden; position: relative; p-1">
                <div class="carousel-inner h-100">
                    @foreach($academynews->images as $index => $image)
                        <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ global_asset($image->image_path) }}" 
                                class="d-block mx-auto img-fluid"
                                style="height: 100%; width: auto; object-fit: contain;">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselNews{{ $academynews->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselNews{{ $academynews->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        @else
            <div class="text-center text-muted mb-4">
                <i class="ni ni-image" style="font-size: 4rem;"></i>
                <p>Imagen no disponible</p>
            </div>
        @endif

        {{-- Datos principales --}}
        <div class="bg-primary text-white p-4 rounded mb-4">
            
            <h1 class="text-white fw-bold">{{ $academynews->nombre_noticia }}</h1>
            <small>
                {{ \Carbon\Carbon::parse($academynews->fecha_noticia)->locale('es')->translatedFormat('d F Y') }}, 
                por {{ $academynews->administrador->nombre_admin }}
            </small>
        </div>

        {{-- Descripción --}}
        <div>
            <p class="text-justify">{!! nl2br(e($academynews->descripcion_noticia)) !!}</p>
        </div>

        <div class="text-end mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Volver al inicio</a>
        </div>

    </div>
</div>

<style>
@media (max-width: 768px) {
    #carouselNews{{ $academynews->id }} {
        height: 20vh !important; 
    }
}
</style>

@endsection