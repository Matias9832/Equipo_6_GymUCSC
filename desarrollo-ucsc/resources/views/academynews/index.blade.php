@extends('layouts.guest', ['class' => 'bg-gray-100'])


@section('content')
    @include('layouts.navbars.guest.navbar')
    
    <div class="container my-5">
        <div class="position-relative mb-5 overflow-hidden rounded" style="max-height: 600px; max-width: 100%;">
            <!-- Imagen de fondo -->
            <img src="{{ global_asset($banner?->banner_image_path ?? url('https://direcciones.ucsc.cl/content/uploads/sites/17/2023/08/stock-deportes-y-recreacion.jpg')) }}"
                class="w-100 h-100 position-absolute top-0 start-0"
                style="object-fit: cover; z-index: 0;"
                alt="Banner academias deportivas">

            <!-- Contenido sobre la imagen -->
            <div class="position-relative z-1 d-flex align-items-center h-100 ps-5 p-5">
                <!-- Contenedor del texto con position-relative para posicionar el botón -->
                <div class="bg-primary bg-opacity-75 text-white p-md-5 rounded shadow position-relative" style="max-width: 650px;">
                    
                    <!-- Botón en la esquina superior derecha del card -->
                    @if(Auth::check() && Auth::user()->is_admin)
                        <a href="{{ route('academysettings.edit') }}" 
                        class="btn btn-sm text-white bg-info position-absolute"
                        style="top: 10px; right: 10px; z-index: 2;">
                            <i class="fas fa-pen-to-square"></i>
                        </a>
                    @endif

                    <small class="text-uppercase fw-semibold">
                        {{ $banner?->banner_subtitle ?? 'UNIDAD DE DEPORTES Y RECREACIÓN' }}
                    </small>

                    <h2 class="fw-bold display-flex text-white">
                        {{ $banner?->banner_title ?? 'ACADEMIAS DEPORTIVAS' }}
                    </h2>                    
                </div>
            </div>
        </div>

        
        {{-- Sección de academias deportivas --}}
        <div class="mt-5">
            <div class="card shadow-sm text-center p-5 position-relative mb-2">

                @if(Auth::check() && Auth::user()->is_admin)
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('academias.create') }}" class="btn btn-primary position-absolute" style="top: 15px; right: 15px; z-index: 1;">
                            <i class="ni ni-fat-add me-2"></i> Crear nueva academia
                        </a>
                    </div>
                @endif

                <h3 class="mb-4">Nuestras academias deportivas</h3>

                
                @if($academias->isEmpty())
                    <div class="card-body">
                        <i class="ni ni-hat-3 display-4 text-secondary mb-3"></i>
                        <h5 class="card-title">No hay academias registradas</h5>
                        <p class="card-text text-muted">Pronto podrás conocer nuestras academias disponibles.</p>
                    </div>
                @else
                    
                    <div class="accordion" id="accordionAcademias">
                        @foreach ($academias as $key => $academia)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $key }}">
                                    <div class="d-flex justify-content-between align-items-center px-3 py-2 bg-white border rounded-top" style="cursor: pointer;">
                                        {{-- Botón que despliega el acordeón --}}
                                        <div class="flex-grow-1 accordion-toggle collapsed d-flex align-items-center"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                            aria-expanded="false" aria-controls="collapse{{ $key }}">
                                            <h5>
                                                <strong class="">{{ $academia->nombre_academia }}</strong>
                                                <i class="fas fa-chevron-down ms-2 transition" id="arrow-{{ $key }}"></i>
                                            </h5>
                                        </div>

                                        {{-- Botones de acción a la derecha --}}
                                        @if(Auth::check() && Auth::user()->is_admin)
                                            <div class="d-flex gap-2 ms-3 pt-2">
                                                <a href="{{ route('academias.edit', $academia->id_academia) }}"
                                                class="btn btn-sm btn-info text-white"
                                                onclick="event.stopPropagation();">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('academias.destroy', $academia->id_academia) }}"
                                                    method="POST"
                                                    onsubmit="event.stopPropagation(); return confirm('¿Estás seguro de eliminar esta academia?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $key }}"
                                    data-bs-parent="#accordionAcademias">
                                    <div class="accordion-body text-start">
                                        <p><strong>Descripción:</strong> {{ $academia->descripcion_academia }}</p>
                                        <p><strong>Matrícula:</strong> ${{ $academia->matricula }}
                                            @if($academia->implementos)
                                                <span>- Incluye {{ $academia->implementos }}</span>
                                            @endif
                                        </p>
                                        <p><strong>Mensualidad:</strong> ${{ $academia->mensualidad }}</p>

                                        @if($academia->horarios && $academia->horarios->count())
                                            <p><strong>Horarios:</strong></p>
                                            <ul>
                                                @foreach($academia->horarios as $horario)
                                                    <li>{{ $horario->dia_semana }} de {{ $horario->hora_inicio }} a {{ $horario->hora_fin }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>


                @endif
            </div>
        </div>

        <br class="mb-5 p-4">

        {{-- Sección de noticias destacadas --}}
           
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
                                                <button class="btn btn-sm btn-light toggle-featured px-2 py-1" data-id="{{ $noticias->id_noticia }}" title="Destacar" disabled>
                                                    <i class="fas fa-star {{ $noticias->is_featured ? 'text-warning' : 'text-muted' }}"></i>
                                                </button>
                                                <a href="{{ route('academynews.edit', $noticias->id_noticia) }}" class="btn btn-sm btn-info px-2 py-1" title="Editar">
                                                    <i class="fas fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('academynews.destroy', $noticias->id_noticia) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                
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

@section('custom-css')
<style>
    .accordion .accordion-item .accordion-toggle.collapsed h5{
        color: black;
    }

    .accordion .accordion-item .accordion-toggle h5{

        color: var(--bs-primary);
    }
</style>
@endsection