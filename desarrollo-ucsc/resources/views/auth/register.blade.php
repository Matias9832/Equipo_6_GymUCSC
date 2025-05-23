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
                                    <h4 class="font-weight-bolder">Registrarse</h4>
                                    <p class="mb-0">Crea tu cuenta</p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('register.perform') }}">
                                        @csrf

                                        <div class="flex flex-col mb-3">
                                            <input type="text" name="rut" class="form-control" placeholder="RUT" value="{{ old('rut') }}" required>
                                            @error('rut') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <input type="email" name="correo" class="form-control" placeholder="Correo" value="{{ old('correo') }}" required>
                                            @error('correo') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <div class="input-group">
                                                <input type="password" name="contraseña" id="register-password" class="form-control" placeholder="Contraseña" required>
                                                <button type="button" class="btn btn-outline-secondary" tabindex="-1" onclick="togglePassword('register-password', this)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('contraseña') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                        </div>
                                        <div class="flex flex-col mb-3">
                                            <div class="input-group">
                                                <input type="password" name="contraseña_confirmation" id="register-password-confirm" class="form-control" placeholder="Confirmar contraseña" required>
                                                <button type="button" class="btn btn-outline-secondary" tabindex="-1" onclick="togglePassword('register-password-confirm', this)">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Registrarse</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="alert">
                                    @include('components.alert')
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://sitios.ucsc.cl/dsi/wp-content/uploads/sites/63/2022/08/gestion-institucional-ucsc.jpg');
              background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-2"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Somos comunidad en movimiento"</h4>
                                <p class="text-white position-relative">Unimos deporte, talleres y gestión en una plataforma pensada para todos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('layouts.footers.guest.footer')
@endsection

@push('js')
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush