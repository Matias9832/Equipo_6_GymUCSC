@extends('layouts.app')

@section('content')

    @include('layouts.navbars.guest.navbar')

    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="container d-flex justify-content-center align-items-center vh-100">
                                <div class="card card-plain">
                                    <div class="card-header pb-0 text-start">
                                        <h4 class="font-weight-bolder">Verificar Cuenta</h4>
                                        <p class="mb-0">Ingresa el código enviado a tu email</p>
                                    </div>

                                    <!-- Mostrar mensaje de éxito -->
                                    @if (session('success'))
                                        <div class="alert alert-success my-2">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <!-- Mostrar mensaje informativo de intentos o reenvío -->
                                    @if (session('info'))
                                        <div class="alert alert-warning my-2">
                                            {{ session('info') }}
                                        </div>
                                    @endif

                                    <!-- Mostrar errores generales SOLO si no es el código inválido -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger my-2">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    @if ($error !== 'El código es inválido.')
                                                        <li>{{ $error }}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="card-body">
                                        <form method="POST" action="{{ route('verificar.codigo') }}">
                                            @csrf
                                            @if (!session('verificacion_id_usuario'))
                                                <div class="mb-3">
                                                    <label for="rut" class="form-label">RUT</label>
                                                    <input type="text" name="rut" id="rut" class="form-control"
                                                        value="{{ session('rut_verificacion') ?? old('rut') }}"
                                                        placeholder="Ingrese su RUT" required>
                                                    @error('rut')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                            <div class="mb-3">
                                                <label for="codigo" class="form-label">Código de Verificación</label>
                                                <input type="text" name="codigo" id="codigo" class="form-control"
                                                    placeholder="Ingrese el código enviado a su correo" required>
                                                @error('codigo')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100">Verificar</button>
                                        </form>
                                    </div>
                                    <div id="alert">
                                        @include('components.alert')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://sitios.ucsc.cl/dsi/wp-content/uploads/sites/63/2022/08/gestion-institucional-ucsc.jpg');
                                          background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-2"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Somos comunidad en
                                    movimiento</h4>
                                <p class="text-white position-relative">Unimos deporte, talleres y gestión en una plataforma
                                    pensada para todos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection