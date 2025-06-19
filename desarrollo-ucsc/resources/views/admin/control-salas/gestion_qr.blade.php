<style>
    #sidenav-main {
        display: none;
        !important;
        opacity: 0 !important;
    }

    .sidenav.fixed-start+.main-content {
        margin-left: 0px !important;
    }
</style>

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Gestor de Qr')
@section('ocultarHamburguesa', true)


@section('content')
    <div class="container py-4">
        <nav class="navbar navbar-main shadow-none border-radius-xl" id="navbarBlur" style="padding-left: 0px !important;"
            data-scroll="false">
            <div class="container-fluid py-2 px-3">
                <nav aria-label="breadcrumb">
                    <h4 class="font-weight-bolder text-white mb-0">INGRESA ESCANEANDO EL CÓDIGO QR</h4>
                </nav>
            </div>
        </nav>


        @if (isset($qrCode))
            <div class="row justify-content-center align-items-center mb-5">
                {{-- QR Code --}}
                <div class="col-md-6 mb-3">
                    <div class="card p-4 shadow-sm h-100 text-center">
                        <h5 class="text-muted mb-2">{{ $sala->nombre_sala }}</h5>
                        <div style="overflow-x: auto;">
                            {!! $qrCode !!}
                        </div>
                    </div>
                </div>

                {{-- Datos de aforo --}}
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm p-4 mb-3 text-center">
                        <h5 class="text-muted mb-2">Aforo permitido</h5>
                        <h2 class="text-primary">{{ $aforoPermitido }}</h2>
                        <hr>
                        <h6 class="text-muted">Usuarios registrados</h6>
                        <h1 class="text-danger" id="aforo-actual">{{ $usuariosActivos }}</h1>
                    </div>

                    <div class="card shadow-sm p-4">
                        <div class="d-flex justify-content-around align-items-center gap-4 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <i
                                    class="fas fa-user fs-4 {{ ($personasConEnfermedad ?? 0) > 0 ? 'text-primary' : 'text-success' }}"></i>
                                <div>
                                    <h4 class="fw-bold text-danger" id="aforo-estudiantes">{{ $estudiantes ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-solid fa-medal fs-4 text-success"></i>
                                <div>
                                    <h4 class="fw-bold text-danger" id="aforo-seleccionados">{{ $seleccionados ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="position-relative my-3 text-center">
                    <hr>
                    <span class="position-absolute top-50 start-50 translate-middle bg-gray-100 px-3 text-muted"
                        style="z-index: 1;">Ó</span>
                </div>

                <div class="container">
                    <div class="card shadow-sm p-4 text-center">
                        <div class="custom-tab-container mt-4">

                            <h5 class="font-weight-bolder mb-0">INGRESA CON TUS CREDENCIALES</h5>
                            {{-- Botones para activar modales --}}
                            <div class="d-flex gap-3 justify-content-center mt-4">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIngresoManual">
                                    Registrar Ingreso
                                </button>
                                <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSalidaManual">
                                    Registrar Salida
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
        @endif


            {{-- Modal Ingreso Manual --}}
            <div class="modal fade" id="modalIngresoManual" tabindex="-1" aria-labelledby="modalIngresoManualLabel"
                aria-hidden="true">
                <div class="modal-dialog" style="margin: 0 auto; margin-top: 530px;">
                    <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                        <form id="form-registro-manual" action="{{ route('registro.manual') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_sala" id="id_sala" value="{{ $sala->id_sala }}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalIngresoManualLabel">Registrar Ingreso Manual</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="rutIngreso" class="form-label">RUT</label>
                                    <input type="text" name="rut" id="rutIngreso" class="form-control"
                                        placeholder="Sin puntos ni dígito verificador" required>
                                </div>
                                <div class="mb-3">
                                    <label for="passIngreso" class="form-label">Contraseña</label>
                                    <input type="password" name="password" id="passIngreso" class="form-control"
                                        placeholder="********" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Registrar Ingreso</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Modal Salida Manual --}}
            <div class="modal fade align-bottom" id="modalSalidaManual" tabindex="-1"
                aria-labelledby="modalSalidaManualLabel" aria-hidden="true">
                <div class="modal-dialog" style="margin: 0 auto; margin-top: 530px;">
                    <div class="modal-content">
                        <form id="form-salida-manual" action="{{ route('salida.manual') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_sala" value="{{ $sala->id_sala }}">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalSalidaManualLabel">Registrar Salida Manual</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="rutSalida" class="form-label">RUT</label>
                                    <input type="text" name="rut" id="rutSalida" class="form-control"
                                        placeholder="Sin puntos ni dígito verificador" required>
                                </div>
                                <div class="mb-3">
                                    <label for="passSalida" class="form-label">Contraseña</label>
                                    <input type="password" name="password" id="passSalida" class="form-control"
                                        placeholder="********" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary">Registrar Salida</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection   
    @section('scripts')
    <script>
        // INICIO REGISTRO MANUAL
        document.getElementById('form-registro-manual').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const mensaje = document.getElementById('mensajeIngreso');
            const idSala = document.getElementById('id_sala').value;

            fetch("{{ route('registro.manual') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: 
    
            })
            .then(response => response.json())
            .then(data => {
                mensaje.textContent = data.message;
                mensaje.style.color = data.success ? 'green' : 'red';
                if (data.success) {
                    actualizarAforo(idSala);
                    form.reset();
                }
            })
            .catch(error => {
                mensaje.textContent = 'Ocurrió un error.';
                mensaje.style.color = 'red';
            });
        });

        // SALIDA MANUAL
        document.getElementById('form-salida-manual').addEventListener('submit', function (e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const mensaje = document.getElementById('mensajeSalida');
            const idSala = document.getElementById('id_sala').value;

            fetch("{{ route('salida.manual') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mensaje.textContent = data.message;
                mensaje.style.color = data.success ? 'green' : 'red';
                if (data.success) {
                    actualizarAforo(idSala);
                    form.reset();
                }
            })
            .catch(error => {
                mensaje.textContent = 'Ocurrió un error.';
                mensaje.style.color = 'red';
            });
        });
    </script>


    @endsection