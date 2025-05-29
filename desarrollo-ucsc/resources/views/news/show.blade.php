@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
@include('layouts.navbars.guest.navbar')
<div class="container my-4">
    <div class="bg-white rounded shadow-sm p-4">

        {{-- Si hay imágenes, muestro un carousel simple --}}
        @if($news->images->count())
            <div id="carouselNews{{ $news->id }}" class="carousel slide mb-4" data-bs-ride="carousel" style="max-height: 400px; overflow: hidden;">
                <div class="carousel-inner">
                    @foreach($news->images as $index => $image)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset($news->images->first()->image_path) }}" 
                                alt="Imagen de la noticia" 
                                class="img-fluid" 
                                style="max-height: 300px; max-width: 100%; object-fit: contain;">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselNews{{ $news->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselNews{{ $news->id }}" data-bs-slide="next">
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
            <span class="badge bg-white text-primary mb-2">{{ strtoupper($news->tipo_deporte) }}</span>
            <h1 class="fw-bold">{{ $news->nombre_noticia }}</h1>
            <small>
                {{ \Carbon\Carbon::parse($news->fecha_noticia)->locale('es')->translatedFormat('d F Y') }}, 
                por {{ $news->administrador->nombre_admin }}
            </small>
        </div>

        {{-- Descripción --}}
        <div>
            <p class="text-justify">{!! nl2br(e($news->descripcion_noticia)) !!}</p>
        </div>

        <div class="text-end mt-4">
            <a href="{{ url('/') }}" class="btn btn-secondary">Volver al inicio</a>
        </div>

    </div>
</div>
@endsection
