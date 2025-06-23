@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
    @include('layouts.navbars.guest.navbar')
    <div class="container my-5">

        <div class="position-relative mb-5 overflow-hidden rounded" style="max-height: 600px; max-width: 100%;">
        <!-- Imagen de fondo -->
        <img src="{{ global_asset($banner?->banner_image_path ?? url('https://direcciones.ucsc.cl/content/uploads/sites/17/2024/10/extra-desk.png')) }}"
            class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; z-index: 0;"
            alt="Banner Noticias">

        <!-- Contenido sobre la imagen -->
        <div class="position-relative z-1 d-flex align-items-center h-100 ps-5 p-5">
            <!-- Contenedor del texto con position-relative para posicionar el botón -->
            <div class="bg-primary bg-opacity-75 text-white p-md-5 rounded shadow position-relative"
                style="max-width: 650px;">

                <!-- Botón en la esquina superior derecha del card -->
                @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('newssettings.edit') }}" class="btn btn-sm text-white bg-secondary position-absolute"
                    style="top: 10px; right: 10px; z-index: 2;">
                    <i class="fas fa-pen-to-square"></i> Editar banner
                </a>
                @endif

                <small class="text-uppercase fw-semibold">
                    {{ $banner?->banner_subtitle ?? 'Direccion de Apoyo a los Estudiantes' }}
                </small>

                <h2 class="fw-bold display-flex text-white text-uppercase">
                    {{ $banner?->banner_title ?? 'Unidad de Deportes y Recreación' }}
                </h2>
            </div>
        </div>
    </div>

        @if ($featuredNews->isNotEmpty())
            <div id="featuredNewsCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
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
                                <a href="{{ route('news.show', $noticia->id_noticia) }}" class="btn btn-danger btn-sm">Ver más</a>
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
            <div class="col-lg-8">
                @if($news->isEmpty())
                <div class="card shadow-sm text-center p-5 position-relative mb-2">
                    @if(Auth::check() && Auth::user()->is_admin)
                    @can('Crear Noticias')
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                                <a href="{{ route('news.create') }}" class="btn btn-primary position-absolute" style="top: 15px; right: 15px; z-index: 1;">
                                    <i class="ni ni-fat-add me-2"></i> Crear nueva noticia
                                </a>
                            </div> 
                            @endcan
                            @endif
                            <div class="card-body">
                                <i class="ni ni-notification-70 display-4 text-secondary mb-3"></i>
                                <h5 class="card-title">No hay noticias disponibles</h5>
                                <p class="card-text text-muted">Vuelve pronto. Aquí aparecerán las últimas novedades del gimnasio.</p>
                        </div>
                    </div>
                    @else
                    <div class="card shadow-sm text-center p-5 position-relative mb-2">
                        @if(Auth::check() && Auth::user()->is_admin)
                            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                                
                                <a href="{{ route('news.create') }}" class="btn btn-primary position-absolute" style="top: 15px; right: 15px; z-index: 1;">
                                    <i class="ni ni-fat-add me-2"></i> Crear nueva noticia
                                </a>
                            </div>   
                        @endif
                        
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            @foreach ($news as $noticias)
                                <div class="col">
                                    <div class="card h-100 shadow-sm position-relative text-start overflow-hidden" style="border-radius: 1rem;">
                                        {{-- Botones de admin, fuera del <a> --}}
                                        @if(Auth::check() && Auth::user()->is_admin)
                                            <div class="position-absolute top-0 end-0 m-2 d-flex align-items-center gap-1 z-1">
                                                <button class="btn btn-sm btn-light toggle-featured px-2 py-1" data-id="{{ $noticias->id_noticia }}" title="Destacar" disabled>
                                                    <i class="fas fa-star {{ $noticias->is_featured ? 'text-warning' : 'text-muted' }}"></i>
                                                </button>

                                                <a href="{{ route('news.edit', $noticias->id_noticia) }}" class="btn btn-sm btn-primary px-2 py-1" title="Editar">
                                                    <i class="fas fa-pen-to-square"></i>
                                                </a>
                                                <form action="{{ route('news.destroy', $noticias->id_noticia) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta noticia?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger px-2 py-1" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        <a href="{{ route('news.show', $noticias->id_noticia) }}" class="text-decoration-none text-dark d-block">
                                        {{-- Imagen --}}
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

                                                <span class="badge bg-danger position-absolute m-2 mt-4" style="top: 0; left: 0;">
                                                    {{ $noticias->tipo_deporte }}
                                                </span>
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
                    </div>    
                    @endif
                            
                            <div class="d-flex justify-content-center">
                                {{ $news->links() }}
                            </div>
            </div>

            <!-- Salas por Sucursal -->
            <div class="col-lg-4">
                <div class="bg-white text-white rounded shadow p-4 p-md-5 mb-5 position-relative overflow-hidden">

                    <!-- Si deseas un botón de edición como en el banner -->
                    @if(Auth::check() && Auth::user()->is_admin)
                        <a href="{{ route('salas.index') }}" class="btn btn-sm text-white bg-secondary position-absolute"
                            style="top: 10px; right: 10px; z-index: 2;">
                            <i class="fas fa-pen-to-square"></i> Editar Salas
                        </a>
                    @endif

                    <h4 class="mb-4 fw-bold text-uppercase text-black">Conoce Nuestras Salas</h4>

                    @foreach($sucursalesConSalas as $sucursal)
                        <div class="mb-3">
                            <h5 class="fw-bold">{{ $sucursal->nombre_suc }}</h5>

                            @if($sucursal->salas->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($sucursal->salas as $sala)
                                        <li class="d-flex justify-content-between align-items-center mb-2 border-bottom border-primary pb-2 text-primary">
                                            <span class="fw-semibold">{{ $sala->nombre_sala }}</span>
                                            <span class="text-primary-50 small">
                                                {{ \Carbon\Carbon::parse($sala->horario_apertura)->format('H:i') }} a 
                                                {{ \Carbon\Carbon::parse($sala->horario_cierre)->format('H:i') }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mb-4 text-primary">No hay salas disponibles en esta sucursal.</p>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
    @include('layouts.footers.guest.footer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-featured').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const url = "{{ route('news.toggleFeatured', ':id') }}".replace(':id', id);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = this.querySelector('i');
                    icon.classList.toggle('text-warning', data.destacado);
                    icon.classList.toggle('text-muted', !data.destacado);
                }
            });
        });
    });
});

</script>
@endpush
