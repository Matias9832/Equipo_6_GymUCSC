@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Fuente')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Editar Fuente'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Editar Fuente</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('personalizacion.fuentes.update', $fuente->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre_fuente" class="form-label">Nombre de la fuente</label>
                                <input type="text" name="nombre_fuente" id="nombre_fuente" class="form-control" value="{{ old('nombre_fuente', $fuente->nombre_fuente) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="familia_css" class="form-label">Familia CSS</label>
                                <input type="text" name="familia_css" id="familia_css" class="form-control" value="{{ old('familia_css', $fuente->familia_css) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="url_fuente" class="form-label">URL (opcional)</label>
                                <input type="url" name="url_fuente" id="url_fuente" class="form-control" value="{{ old('url_fuente', $fuente->url_fuente) }}">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('personalizacion.fuentes.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar Fuente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
