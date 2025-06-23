@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar banner de talleres'])
@section('title', 'Editar banner de talleres')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($setting->banner_image_path)
                    <div class="mb-3" style="position: relative; display: inline-block; max-width: 100%;">
                        {{-- Imagen de fondo --}}
                        <img src="{{ global_asset($setting->banner_image_path) }}" class="img-fluid" style="max-height: 200px; border-radius: 6px;">

                        {{-- Botón eliminar imagen --}}
                        <form action="{{ route('talleres.banner.image.delete') }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de eliminar esta imagen?');"
                            style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1"
                                    style="border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                &times;
                            </button>
                        </form>
                    </div>   
                @endif


                {{-- Formulario principal --}}
                <form action="{{ route('talleressettings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Imagen de fondo</label>
                        <input type="file" name="banner_image" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subtítulo</label>
                        <input type="text" name="banner_subtitle" class="form-control"
                            value="{{ old('banner_subtitle', $setting->banner_subtitle) }}"
                            placeholder="Unidad de Deportes y Recreación">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Título principal</label>
                        <input type="text" name="banner_title" class="form-control"
                            value="{{ old('banner_title', $setting->banner_title) }}"
                            placeholder="Talleres Extraprogramáticos">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary mt-2">Actualizar</button>
                        <a href="{{ route('talleresnews.index') }}" class="btn btn-outline-secondary mt-2">Cancelar</a>
                    </div>
                </form>

            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

