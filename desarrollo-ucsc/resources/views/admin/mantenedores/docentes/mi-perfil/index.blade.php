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
                                <a class="dropdown-item" href="javascript:;">
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
                                    <input class="form-control" type="text" value="{{ $administrador->numero_contacto ?? 'Puedes agregar aquí un número de contacto' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Descripción de ubicación</label>
                                    <input class="form-control" type="text" value="{{ $administrador->descripcion_ubicacion ?? 'Puedes poner aquí dónde encontrar tu puesta de trabajo' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Sobre mí</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="4" readonly style="width: 100%; overflow-wrap: break-word;">{{ $administrador->sobre_mi ?? 'Agrega aquí una breve descripción sobre ti.' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta lateral -->
            <div class="col-md-4">
                <div class="card card-profile">
                    <!-- Imagen de cabecera -->
                    <img src="/img/gym/foto-gimnasio.jpeg" alt="Image placeholder" class="card-img-top">

                    <!-- Foto de perfil superpuesta -->
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n7 position-relative z-index-2">
                                <img src="{{ url('img/perfiles/' . $administrador->foto_perfil) }}"
                                    class="rounded-circle img-fluid border border-2 border-white"
                                    style="width: 120px !important; height: 120px !important; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <!-- Cuerpo de la tarjeta -->
                    <div class="card-body pt-0">
                        <div class="text-center mt-3">
                            <h5 class="mb-1">{{ $administrador->nombre_admin }}</h5>
                            <div class="h6 font-weight-300 text-muted">
                                {{ $administrador->descripcion_cargo ?? $rol }}
                            </div>

                            @if($sucursal)
                                <div class="mt-2">
                                    <i class="ni ni-pin-3 me-1"></i> {{ $sucursal->nombre_suc }}
                                </div>
                            @endif

                            @if($administrador->descripcion_ubicacion)
                                <div>
                                    <i class="ni ni-map-big me-1"></i> {{ $administrador->descripcion_ubicacion }}
                                </div>
                            @endif

                            @if($administrador->numero_contacto)
                                <div class="mt-2">
                                    <i class="ni ni-mobile-button me-1"></i> {{ $administrador->numero_contacto }}
                                </div>
                            @endif

                            @if($administrador->sobre_mi)
                                <div class="mt-3 px-3">
                                    <p class="text-sm text-dark fst-italic" style="white-space: pre-wrap;">"{{ $administrador->sobre_mi }}"</p>
                                </div>
                            @endif

                            @if($talleres && $talleres->count())
                                <hr class="horizontal dark mt-3 mb-2">
                                <h6 class="text-sm text-primary text-uppercase mb-2">Talleres a cargo</h6>
                                <ul class="list-unstyled text-start ps-4">
                                    @foreach($talleres as $taller)
                                        <li class="mb-1">
                                            <i class="ni ni-hat-3 text-success me-2"></i> {{ $taller->nombre_taller }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
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
@endsection
