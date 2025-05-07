@extends('layouts.app')

@if(session('success') || session('update') || session('delete'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100; margin-top: 70px;">
    <div id="toastSuccess" class="toast align-items-center text-white 
        {{ session('success') ? 'bg-success' : (session('update') ? 'bg-primary' : 'bg-danger') }} 
        border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body text-center w-100">
                {{ session('success') ?? session('update') ?? session('delete') }}
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


@section('content')
<div class="row">
    <div class="col-lg-8">
        <h4 class="mb-4 mt-4">Noticias</h4>
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

                @foreach ($news as $noticias)
                <div class="card mb-3 position-relative" style="min-height: 200px;">
                    @if(Auth::check() && Auth::user()->is_admin)
                        <div class="position-absolute top-0 end-0 m-2 d-flex gap-2 z-3">
                            <a href="{{ route('news.edit', $noticias->id_noticia) }}" 
                            class="btn btn-warning btn-sm d-flex align-items-center justify-content-center p-0" 
                            title="Editar"
                            style="width: 40px; height: 40px;">
                                <i class="bi bi-pen-fill"></i>
                            </a>
                        
                            <form id="form-eliminar-{{ $noticias->id_noticia }}" action="{{ route('news.destroy', $noticias->id_noticia) }}" method="POST" class="d-inline form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-danger btn-sm d-flex align-items-center justify-content-center p-0 btn-mostrar-modal" 
                                        title="Eliminar"
                                        style="width: 40px; height: 40px;"
                                        data-id="{{ $noticias->id_noticia }}">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="row g-0 flex-column flex-md-row">
                        <div class="col-md-4 d-flex align-items-center justify-content-center bg-light" style="padding: 5px;">
                            @if ($noticias->images->count())
                                    <img src="{{ asset('storage/' . $noticias->images->first()->image_path) }}"  
                                    class="img-fluid rounded-start p-2" 
                                    alt="Imagen de la noticia" 
                                    style="max-height: 200px; object-fit: contain; width: 100%;">
                            @else
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted" style="height: 180px; width: 100%;">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
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

                            <div class="card-footer bg-transparent">
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
    </div>    

     <!-- Salas por Sucursal -->
     <div class="col-lg-4">
        <h4 class="mb-4 mt-4">Conoce Nuestras Salas</h4>

        @foreach($sucursalesConSalas as $sucursal)
            <h5>{{ $sucursal->nombre_suc }}</h5>
            @if($sucursal->salas->isNotEmpty())
                <ul>
                @foreach($sucursal->salas as $sala)
                    <li class="d-flex justify-content-between mb-3">
                        <span class="tw-bold">
                            <strong>{{ $sala->nombre_sala }}</strong>
                        </span>
                        <span class="text-info">
                            {{ \Carbon\Carbon::parse($sala->horario_apertura)->format('H:i') }} a 
                            {{ \Carbon\Carbon::parse($sala->horario_cierre)->format('H:i') }}
                        </span>
                    </li>
                @endforeach
                </ul>
            @else
                <p>No hay salas disponibles en esta sucursal.</p>
            @endif
        @endforeach
    </div> 

    <div class="d-flex justify-content-center">
        {{ $news->links() }}
    </div>
</div>
@endsection

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        
        <div class="modal-body">
          ¿Estás seguro de que quieres eliminar esta noticia?
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Sí, eliminar</button>
        </div>
  
      </div>
    </div>
  </div>

  <script>
    let idEliminar = null;

    document.addEventListener('DOMContentLoaded', function () {
        const botonesEliminar = document.querySelectorAll('.btn-mostrar-modal');

        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function () {
                idEliminar = this.getAttribute('data-id');
                const modalEliminar = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
                modalEliminar.show();
            });
        });

        const btnConfirmarEliminar = document.getElementById('btnConfirmarEliminar');
        btnConfirmarEliminar.addEventListener('click', function () {
            if (idEliminar) {
                const form = document.querySelector(`form[action*="/news/${idEliminar}"]`);
                form.submit();
            }
        });
    });

</script>

