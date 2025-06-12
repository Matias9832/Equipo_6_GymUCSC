@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Empresa')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Editar Empresa'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Editar Empresa</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('empresas.update', $empresa) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control"
                                    value="{{ old('nombre', $empresa->nombre) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label><br>
                                <img src="{{ url($empresa->logo) }}" alt="Logo actual" style="height: 60px;"
                                    class="mb-2 d-block">
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Deja vacío si no deseas cambiar el logo.</small>
                            </div>

                            <div class="mb-3">
                                <label for="mision" class="form-label">Misión</label>
                                <textarea name="mision" id="mision" rows="3" class="form-control"
                                    required>{{ old('mision', $empresa->mision) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="vision" class="form-label">Visión</label>
                                <textarea name="vision" id="vision" rows="3" class="form-control"
                                    required>{{ old('vision', $empresa->vision) }}</textarea>
                            </div>

                            @if ($empresa->subdominio === null || $empresa->subdominio === 'Sin subdominio asignado')
                                <div class="mb-3">
                                    <label class="form-label">Dominio</label>
                                    <input type="text" class="form-control" value="Sin dominio asignado" disabled>
                                    <div class="text-danger small mt-1">
                                        Debe asignar un subdominio para personalizar
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <label for="dominio" class="form-label">Dominio personalizado</label>
                                    <input type="text" name="dominio" id="dominio" class="form-control"
                                        value="{{ $empresa->dominio !== 'Sin dominio asignado' ? $empresa->dominio : '' }}">
                                </div>
                            @endif

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar Empresa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection