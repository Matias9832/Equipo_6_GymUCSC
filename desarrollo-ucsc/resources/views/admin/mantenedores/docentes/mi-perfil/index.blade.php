@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Mi perfil'])

    <div class="card shadow-lg mx-4 mt-4">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ url('img/perfiles/' . $administrador->foto_perfil) }}" class="rounded-circle img-fluid border border-2 border-white" style="object-fit: cover; width: 100%; height: 100%;">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $administrador->nombre_admin }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            {{ $administrador->descripcion_cargo ?? $rol }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <li class="dropdown me-3 d-flex justify-content-end">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="configuracionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ni ni-settings-gear-65 me-1"></i> Configuración
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="configuracionDropdown">
                            <li>
                                <form id="form-foto" action="{{ route('docentes.foto.update') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="file" name="foto_perfil" id="input_foto" accept="image/*">
                                </form>
                                <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('input_foto').click();">
                                    <i class="ni ni-image me-2 text-primary"></i> Cambiar foto de perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('docentes.contacto.edit') }}">
                                    <i class="ni ni-single-copy-04 me-2 text-info"></i> Editar información de contacto
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('salud.edit') }}">
                                    <i class="ni ni-collection me-2 text-warning"></i> Editar información de salud
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('edit-perfil.edit') }}">
                                    <i class="ni ni-lock-circle-open me-2 text-warning"></i> Cambiar contraseña
                                </a>
                            </li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body mt-2">
                        <p class="text-uppercase text-sm">Información de usuario</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Nombres</label>
                                    <input class="form-control readonly-input" type="text" value="{{ $administrador->nombre_admin }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Correo electrónico</label>
                                    <input class="form-control readonly-input" type="text" value="{{ $admin->correo_usuario }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Rol asignado</label>
                                    <input class="form-control readonly-input" type="text" value="{{ $rol }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Sucursal</label>
                                    <input class="form-control readonly-input" type="text" value="{{ $sucursal->nombre_suc ?? 'Sin sucursal' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Información de contacto</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Número de contacto</label>
                                    <input class="form-control readonly-input" type="text" value="{{ $administrador->numero_contacto}}" placeholder="Puedes agregar aquí un número de contacto" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción de ubicación</label>
                                    <input class="form-control readonly-input" type="text" value="{{ $administrador->descripcion_ubicacion}}" placeholder="Puedes poner aquí dónde encontrar tu puesto de trabajo" readonly>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Sobre mí</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control readonly-input" rows="4" readonly placeholder="Agrega aquí una breve descripción sobre ti" style="width: 100%; overflow-wrap: break-word;">{{ $administrador->sobre_mi ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta lateral -->
            <div class="col-md-4">
                <x-card-docente 
                    :nombre="$administrador->nombre_admin"
                    :foto="$administrador->foto_perfil"
                    :cargo="$administrador->descripcion_cargo ?? $rol"
                    :sucursal="$sucursal->nombre_suc ?? null"
                    :ubicacion="$administrador->descripcion_ubicacion"
                    :correo="$admin->correo_usuario"
                    :telefono="$administrador->numero_contacto"
                    :sobre-mi="$administrador->sobre_mi"
                    :talleres="$talleres?->pluck('nombre_taller')->toArray()"
                />
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
    <script>
        document.getElementById('input_foto').addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) { // 2MB en bytes
                alert('La imagen supera el límite de 2 MB.');
                this.value = ''; // limpia el input
            } else {
                document.getElementById('form-foto').submit();
            }
        });
    </script>
    <style>
        .readonly-input {
            cursor: default !important;
            pointer-events: none;
        }
    </style>
@endsection
