@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://ucsc.cl/content/uploads/2023/08/hero-facultad.jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">¡Bienvenido a la comunidad!</h1>
                        <p class="text-lead text-white">Accede a talleres, torneos y al gimnasio desde un solo lugar.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Verificar Cuenta</h5>
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

                            <form method="POST" action="{{ route('verificar.codigo') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="codigo" class="form-label">Código de Verificación</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese el código enviado a su correo" required>
                                    @error('codigo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Verificar</button>
                                <p class="text-sm mt-3 mb-0">¿No tienes una cuenta? <a href="{{ route('register') }}"
                                        class="text-dark font-weight-bolder">Regístrate</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection