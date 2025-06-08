@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Mi perfil'])

    <div class="card shadow-lg mx-4 mt-4">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ url('img/perfiles/' . $administrador->foto_perfil) }}" class="rounded-circle img-fluid border border-2 border-white">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $administrador->nombre_admin }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $rol ?? 'Sin rol asignado' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab">
                                    <i class="ni ni-app"></i>
                                    <span class="ms-2">Información</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab">
                                    <i class="ni ni-email-83"></i>
                                    <span class="ms-2">Talleres</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 d-flex align-items-center justify-content-center" data-bs-toggle="tab" href="javascript:;" role="tab">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span class="ms-2">Cambiar foto de perfil</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0">Perfil personal</p>
                            <a href="{{ route('edit-perfil.edit') }}" class="btn btn-primary btn-sm ms-auto">Editar perfil</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Información de usuario</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Nombres</label>
                                    <input class="form-control" type="text" value="{{ $administrador->nombre_admin }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Correo electrónico</label>
                                    <input class="form-control" type="text" value="{{ $admin->correo_usuario }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Rol asignado</label>
                                    <input class="form-control" type="text" value="{{ $rol }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Sucursal</label>
                                    <input class="form-control" type="text" value="{{ $sucursal->nombre_suc ?? 'Sin sucursal' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Información de contacto</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Número de contacto</label>
                                    <input class="form-control" type="text" value="{{ $administrador->numero_contacto ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción de ubicación</label>
                                    <input class="form-control" type="text" value="{{ $administrador->descripcion_ubicacion ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Sobre mí</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" value="{{ $administrador->sobre_mi ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta lateral -->
            <div class="col-md-4">
                <div class="card card-profile">
                    <img src="/img/gym/foto-gimnasio.jpeg" alt="Image placeholder" class="card-img-top">
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <a href="javascript:;">
                                    <img src="{{ url('img/perfiles/' . $administrador->foto_perfil) }}" class="rounded-circle img-fluid border border-2 border-white">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-center mt-4">
                            <h5>{{ $administrador->nombre_admin }}</h5>
                            <div class="h6 font-weight-300">
                                {{ $rol }}
                            </div>
                            <div class="h6 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>Sucursal: {{ $sucursal->nombre_suc ?? 'Sin asignar' }}
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>{{ $administrador->descripcion_ubicacion ?? 'Sin ubicación' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
