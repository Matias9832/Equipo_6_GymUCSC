@extends('layouts.app')

@section('content')

    @include('layouts.navbars.guest.navbar')

    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Restablece tu contraseña</h4>
                                    <p class="mb-0">Ingresa tu email y espera unos segundos</p>
                                </div>
                                <div class="card-body">
                                    {{-- Mensaje de éxito --}}
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    {{-- Errores generales --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form role="form" method="POST" action="{{ route('reset.perform') }}">
                                        @csrf
                                        @method('post')
                                        <div class="flex flex-col mb-3">
                                            <input type="email" name="email" class="form-control form-control-lg"
                                                placeholder="Email" value="{{ old('email') }}" aria-label="Email">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Enviar correo</button>
                                        </div>
                                    </form>
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