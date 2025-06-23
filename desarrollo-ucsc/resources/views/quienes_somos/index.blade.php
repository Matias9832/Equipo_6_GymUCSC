@extends('layouts.guest', ['class' => 'bg-gray-100'])

@section('content')
@include('layouts.navbars.guest.navbar')

<div class="container my-5">
    <!-- Banner superior -->
    <div class="position-relative mb-5 overflow-hidden rounded" style="max-height: 600px; max-width: 100%;">
        <!-- Imagen de fondo -->
        <img src="{{ global_asset($banner?->banner_image_path ?? url('https://direcciones.ucsc.cl/content/uploads/sites/17/2024/10/extra-desk.png')) }}"
            class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; z-index: 0;"
            alt="Banner Quiénes Somos">

        <!-- Contenido sobre la imagen -->
        <div class="position-relative z-1 d-flex align-items-center h-100 ps-5 p-5">
            <div class="bg-primary bg-opacity-75 text-white p-md-5 rounded shadow position-relative"
                style="max-width: 650px;">
                @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('quienes-somos.banner.edit') }}" class="btn btn-sm text-white bg-secondary position-absolute"
                    style="top: 10px; right: 10px; z-index: 2;">
                    <i class="fas fa-pen-to-square me-2"></i>Editar 
                </a>
                @endif

                <small class="text-uppercase fw-semibold">
                    {{ $banner?->banner_subtitle ?? 'Unidad de Deportes y Recreación' }}
                </small>

                <h2 class="fw-bold display-flex text-white text-uppercase">
                    {{ $banner?->banner_title ?? 'Quiénes Somos' }}
                </h2>
            </div>
        </div>
    </div>

    <!-- Cards de docentes -->
    <div class="mt-5">
        <div class="card shadow-sm text-center p-5 position-relative mb-2">
            <h3 class="mb-4">Nuestro equipo docente</h3>
            @if($docentes->isEmpty())
                <div class="card-body">
                    <i class="ni ni-hat-3 display-4 text-secondary mb-3"></i>
                    <h5 class="card-title">No hay docentes registrados</h5>
                    <p class="card-text text-muted">Pronto podrás conocer a nuestro equipo docente.</p>
                </div>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
                    @foreach ($docentes as $docente)
                        <div class="col">
                            <x-card-docente
                                :nombre="$docente->nombre_admin"
                                :foto="$docente->foto_perfil"
                                :cargo="$docente->descripcion_cargo"
                                :sucursal="optional($docente->sucursales->first())->nombre_suc ?? null"
                                :ubicacion="optional($docente->sucursales->first())->ubicacion ?? null"
                                :correo="optional($docente->usuario)->correo_usuario"
                                :telefono="optional($docente->usuario)->telefono_usuario"
                                :sobre-mi="$docente->sobre_mi"
                                :talleres="$docente->talleres?->pluck('nombre_taller')->toArray() ?? []"
                            />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    #cerrar-perfil-docente{
        display: none !important;
    }
</style>
@endsection