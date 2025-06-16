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
                                    <h4 class="font-weight-bolder">Ingresar</h4>
                                    <p class="mb-0">Escribe tu RUT y tu contraseña para ingresar</p>
                                </div>
                                <div class="card-body">
                                    {{-- Mostrar errores generales --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form role="form" method="POST" action="{{ route('login.perform') }}">
                                        @csrf
                                        @method('post')
                                        <div class="flex flex-col mb-3">
                                            <input type="text" name="rut" class="form-control form-control-lg" placeholder="RUT sin puntos, ni dígito verificador" value="{{ old('rut') }}" required>
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingrese su contraseña" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Entrar</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-1 text-sm mx-auto">
                                        ¿Olvidaste tu contraseña? 
                                        <a href="{{ route('reset-password') }}" class="text-primary text-gradient font-weight-bold">Cambia tu contraseña</a>
                                    </p>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        ¿No tienes cuenta?
                                        <a href="{{ route('register') }}" class="text-primary text-gradient font-weight-bold">Regístrate</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://sitios.ucsc.cl/dsi/wp-content/uploads/sites/63/2022/08/gestion-institucional-ucsc.jpg');
              background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-2"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">Somos una comunidad en movimiento</h4>
                                <p class="text-white position-relative">Unimos deporte, talleres y gestión en una plataforma pensada para todos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection