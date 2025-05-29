@extends('layouts.app')

@section('content')
<div class="container my-1 mx-1">
    <div class="bg-white rounded shadow-sm p-1">

        <!-- Imagen principal -->
        @if($news->images->count())
            <div id="carouselNews{{ $news->id }}" class="carousel slide mb-4" data-bs-ride="carousel"
                style="height: 500px; overflow: hidden; position: relative; p-1">
                <div class="carousel-inner h-100">
                    @foreach($news->images as $index => $image)
                        <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset($image->image_path) }}" 
                                class="d-block mx-auto"
                                style="height: 80%; width: auto; object-fit: contain;">
                        </div>
                    @endforeach
                </div>

                <!-- Botón previo -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselNews{{ $news->id }}" data-bs-slide="prev" style="opacity: 0.2; transition: opacity 0.3s;">
                    <span class="carousel-control-prev-icon" style="background-color: lightgray; background-size: 100% 100%;"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>

                    <!-- Botón siguiente -->
                <button class="carousel-control-next" type="button" data-bs-target="#carouselNews{{ $news->id }}" data-bs-slide="next" style="opacity: 0.3; transition: opacity 0.3s;">
                    <span class="carousel-control-next-icon" style="background-color: lightgray; background-size: 100% 100%;" ></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        @endif


        <!-- Encabezado tipo UCSC -->
        <div class="bg-primary text-white py-5 px-4">
            <div class="mb-3 d-flex flex-wrap">
                <span class="badge bg-white text-primary me-2">{{ strtoupper($news->tipo_deporte) }}</span>
                
            </div>
            <h1 class="fw-bold">{{ $news->nombre_noticia }}</h1>
            <small>
                {{ \Carbon\Carbon::parse($news->fecha_noticia)->locale('es')->translatedFormat('d F Y') }},
                por {{ $news->administrador->nombre_admin }}
            </small>
        </div>

        <!-- Cuerpo de la noticia -->
        <div class="px-4 py-5">
            <p class="text-justify">{!! nl2br(e($news->descripcion_noticia)) !!}</p>

            <div class="mt-4 text-end">
                <a href="{{ url('/') }}" class="btn btn-secondary">Volver al inicio</a>
            </div>
        </div>

    </div>
</div>
@endsection

