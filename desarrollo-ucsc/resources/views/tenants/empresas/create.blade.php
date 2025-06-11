@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Nueva Empresa')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Agregar Empresa'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Nueva Empresa</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*" required>
                            </div>

                            <div class="mb-3">
                                <label for="mision" class="form-label">Misión</label>
                                <textarea name="mision" id="mision" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="vision" class="form-label">Visión</label>
                                <textarea name="vision" id="vision" class="form-control" rows="3" required></textarea>
                            </div>


                            <div class="d-flex justify-content-between">
                                <a href="{{ route('empresas.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Empresa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection