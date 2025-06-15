@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar banner de academias'])
@section('title', 'Editar banner de academias')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('academysettings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Imagen de fondo</label>
                        <input type="file" name="banner_image" class="form-control">
                    </div>

                    @if($setting->banner_image_path)
                        <div class="mb-3">
                            <img src="{{ global_asset($setting->banner_image_path) }}" class="img-fluid" style="max-height: 200px;">
                        </div>
                    @endif

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
                            placeholder="Academias Deportivas">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary mt-2">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
