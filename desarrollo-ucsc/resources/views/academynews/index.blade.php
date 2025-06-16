@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
    @include('layouts.navbars.guest.navbar')
    
    <div class="container my-5">
        <div class="position-relative mb-5 overflow-hidden rounded" style="max-height: 600px; max-width: 100%;">
            <!-- Imagen de fondo -->
            <img src="{{ global_asset($banner?->banner_image_path ?? 'img/default_banner.jpg') }}"
                class="w-100 h-100 position-absolute top-0 start-0"
                style="object-fit: cover; z-index: 0;"
                alt="Banner academias deportivas">

            <!-- Contenido sobre la imagen -->
            <div class="position-relative z-1 d-flex align-items-center h-100 ps-5 p-5">
                <div class="bg-primary bg-opacity-75 text-white  p-md-5 rounded shadow" style="max-width: 650px;">
                    <div class="position-absolute top-0 end-0 m-1 d-flex align-items-center gap-1 z-1">
                        @if(Auth::check() && Auth::user()->is_admin)
                            @if($banner)
                                <a href="{{ route('academysettings.edit', $banner->id) }}" ...>
                                    <i class="fas fa-pen-to-square"></i>
                                </a>
                            @else
                                <div class="alert alert-warning text-white">
                                    No hay configuración de banner. Por favor, crea una en el panel de administración.
                                </div>
                            @endif
                        @endif
                    </div>
                    <small class="text-uppercase fw-semibold">
                        {{ $banner?->banner_subtitle ?? 'Unidad de Deportes y Recreación' }}
                    </small>

                    <h2 class="fw-bold display-flex text-white">
                        {{ $banner?->banner_title ?? 'Academias Deportivas' }}
                    </h2>

                    
                </div>
            </div>
        </div>
   
           
        @if ($featuredNews->isNotEmpty())
            <div id="featuredNewsCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <h4>Noticias Destacadas</h4>
                    @foreach ($featuredNews as $index => $noticia)
                        <div class="carousel-item @if($index == 0) active @endif" style="background-color: white; border-radius: 1rem; padding: 1rem;">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    @if ($noticia->images->count())
                                        <img src="{{ global_asset($noticia->images->first()->image_path) }}"
                                            class="d-block w-100 rounded"
                                            alt="Imagen de {{ $noticia->nombre_noticia }}"
                                            style="height: 300px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex justify-content-center align-items-center"
                                            style="height: 300px;">
                                            <i class="ni ni-image text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h4>{{ $noticia->nombre_noticia }}</h4>
                                    <p class="text-muted small">
                                        {{ \Carbon\Carbon::parse($noticia->fecha_noticia)->format('d M Y') }} – 
                                        {{ $noticia->administrador->nombre_admin }}
                                    </p>
                                    <p>{{ Str::limit(strip_tags($noticia->contenido_noticia), 120) }}</p>
                                    <a href="{{ route('academynews.show', $noticia->id_noticia) }}" class="btn btn-primary btn-sm">Ver más</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#featuredNewsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuredNewsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        @endif


        <div class="row">
            <div class="col-lg-8 w-100">
                @if($news->isEmpty())
                    <div class="card shadow-sm text-center p-5 position-relative mb-2">
                        @if(Auth::check() && Auth::user()->is_admin)
                            @can('Crear Noticias')
                                <div class="card-header pb-0 d-flex justify-content-between align-items-center w-100">
                                    <a href="{{ route('academynews.create') }}" class="btn btn-primary position-absolute" style="top: 15px; right: 15px; z-index: 1;">
                                        <i class="ni ni-fat-add me-2"></i> Crear nueva noticia
                                    </a>
                                </div>                                 
                            @endcan
                        @endif
                        <div class="card-body">
                            <i class="ni ni-notification-70 display-4 text-secondary mb-3"></i>
                            <h5 class="card-title">No hay noticias disponibles</h5>
                            <p class="card-text text-muted">Vuelve pronto. Aquí aparecerán las últimas novedades.</p>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm text-center p-5 position-relative mb-2">
                        @if(Auth::check() && Auth::user()->is_admin)
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                                <a href="{{ route('academynews.create') }}" class="btn btn-primary position-absolute" style="top: 15px; right: 15px; z-index: 1;">
                                    <i class="ni ni-fat-add me-2"></i> Crear nueva noticia
                                </a>
                            </div>   
                        @endif
                        <h3>Todas nuestras noticias</h3>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                            @foreach ($news as $noticias)
                                <div class="col">
                                    <div class="card h-100 shadow-sm text-start overflow-hidden" style="border-radius: 1rem;">
                                        {{-- Botones de admin --}}
                                        @if(Auth::check() && Auth::user()->is_admin)
                                            <div class="position-absolute top-0 end-0 m-2 d-flex align-items-center gap-1 z-1">
                                                <!-- botones -->
                                            </div>
                                        @endif

                                        <a href="{{ route('academynews.show', $noticias->id_noticia) }}" class="text-decoration-none text-dark d-block w-100">
                                            <div style="height: 200px; overflow: hidden; background-color: #f9f9f9;">
                                                @if ($noticias->images->count())
                                                    <img src="{{ global_asset($noticias->images->first()->image_path) }}"
                                                        alt="Imagen noticia"
                                                        class="w-100 h-100"
                                                        style="object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex justify-content-center align-items-center h-100 text-muted">
                                                        <i class="ni ni-image" style="font-size: 2rem;"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="bg-white p-3" style="min-height: 150px;">
                                                <h5 class="card-title">{{ $noticias->nombre_noticia }}</h5>
                                                <small class="text-muted d-block mt-2">
                                                    {{ \Carbon\Carbon::parse($noticias->fecha_noticia)->format('d M Y') }} – 
                                                    {{ $noticias->administrador->nombre_admin }}
                                                </small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <div class="d-flex justify-content-center">
                                    {{ $news->links() }}
                                </div>     

                        </div>
   
                    </div>    
                    @endif
                </div>    
                </div>
            </div>   
@endsection