@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
    @include('layouts.navbars.guest.navbar')
    <div style="height: 75px;"></div>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                @if($news->isEmpty())
                    <div class="card shadow-sm text-center p-5">
                        <div class="card-body">
                            <i class="ni ni-notification-70 display-4 text-secondary mb-3"></i>
                            <h5 class="card-title">No hay noticias disponibles</h5>
                            <p class="card-text text-muted">Vuelve pronto. Aquí aparecerán las últimas novedades del gimnasio.</p>
                        </div>
                    </div>
                @else
                    @foreach ($news as $noticias)
                        <div class="card mb-4 shadow-sm">
                            <div class="row g-0 flex-column flex-md-row">
                                <div class="col-md-4 d-flex align-items-center justify-content-center bg-light" style="padding: 5px;">
                                    @if ($noticias->images->count())
                                        <img src="{{ asset('storage/' . $noticias->images->first()->image_path) }}"  
                                            class="img-fluid rounded-start p-2" 
                                            alt="Imagen de la noticia" 
                                            style="max-height: 200px; object-fit: contain; width: 100%;">
                                    @else
                                        <div class="d-flex flex-column align-items-center justify-content-center text-muted" style="height: 180px; width: 100%;">
                                            <i class="ni ni-image" style="font-size: 3rem;"></i>
                                            <small>Imagen no disponible</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <a href="{{ route('news.show', $noticias->id_noticia) }}" class="text-decoration-none text-dark">
                                            <h5 class="card-title">{{ $noticias->nombre_noticia }}</h5>
                                            <p class="card-text">{{ Str::limit($noticias->descripcion_noticia, 100, '...') }}</p>
                                        </a>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($noticias->fecha_noticia)->format('d M Y') }} -
                                            {{ $noticias->administrador->nombre_admin }} -
                                            {{ $noticias->tipo_deporte }}
                                        </small>   
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div class="d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            </div>

            <!-- Salas por Sucursal -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Conoce Nuestras Salas</h4>
                        @foreach($sucursalesConSalas as $sucursal)
                            <h5 class="mb-2">{{ $sucursal->nombre_suc }}</h5>
                            @if($sucursal->salas->isNotEmpty())
                                <ul class="list-unstyled mb-4">
                                    @foreach($sucursal->salas as $sala)
                                        <li class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold">{{ $sala->nombre_sala }}</span>
                                            <span class="text-info small">
                                                {{ \Carbon\Carbon::parse($sala->horario_apertura)->format('H:i') }} a 
                                                {{ \Carbon\Carbon::parse($sala->horario_cierre)->format('H:i') }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted mb-4">No hay salas disponibles en esta sucursal.</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.guest.footer')
@endsection