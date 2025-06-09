@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
    @include('layouts.navbars.guest.navbar')
    <div class="container my-5">
         
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

                                        {{-- Imagen --}}
                                        <div style="height: 200px; overflow: hidden; background-color: #f9f9f9;" >
                                             @if ($noticias->images->count())
                                                <img src="{{ asset('img/' . $noticias->images->first()->image_path) }}"
                                                    alt="Imagen noticia"
                                                    class="w-100 h-100"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex justify-content-center align-items-center h-100 text-muted">
                                                    <i class="ni ni-image" style="font-size: 2rem;"></i>
                                                </div>
                                            @endif
                                        <br>
                                        <span class="badge bg-danger mb-2">{{ $noticias->tipo_deporte }}</span>
                                        </div>

                                        @if(Auth::check() && Auth::user()->is_admin)
                                            <div class="position-absolute top-0 end-0 m-2 d-flex z-1">
                                                <a href="{{ route('news.edit', $noticias->id_noticia) }}" class="btn btn-sm btn-info me-1 px-2 py-1" title="Editar">
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

                                        <div class="bg-white p-3" style="min-height: 150px;">

                                            <a href="{{ route('news.show', $noticias->id_noticia) }}" class="text-decoration-none text-dark">
                                                <h5 class="card-title">{{ $noticias->nombre_noticia }}</h5>
                                            </a>

                                            <small class="text-muted d-block mt-2">
                                                {{ \Carbon\Carbon::parse($noticias->fecha_noticia)->format('d M Y') }} – 
                                                {{ $noticias->administrador->nombre_admin }}.
                                            </small>
                                        </div>

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