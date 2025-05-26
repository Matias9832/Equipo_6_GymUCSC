<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow mt-4 py-2">
                <div class="container-fluid">
                    <!-- Logos -->
                    <a class="navbar-brand d-flex align-items-center font-weight-bolder ms-lg-0 ms-3"
                        href="{{ route('welcome') }}">
                        <!-- <img src="{{ asset('img/gym/deportes_logo.png') }}" alt="Logo GYM" style="height: 30px;"
                            class="me-2"> -->
                        <span style="font-family: 'Montserrat', sans-serif; font-weight: 1000; font-size: 1.4rem;"
                            class="me-2">
                            DEPORTES
                        </span>
                        <img src="{{ asset('img/gym/ucsc_logo.png') }}" alt="Logo UCSC" style="height: 30px;"
                            class="me-2">
                    </a>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav ms-auto align-items-center">
                            @auth
                                @if(auth()->user()->tipo_usuario === 'admin')
                                    <li class="nav-item me-2" style="width: 176px;">
                                        <a href="{{ route('home') }}"
                                            class="btn btn-sm mb-0 btn-primary d-flex align-items-center">
                                            <i class="fa fa-chart-pie opacity-6 text-white me-1"></i>
                                            Panel de control
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item me-2 dropdown" style="width: 176px;">
                                    <a class="btn btn-sm mb-0 btn-light dropdown-toggle d-flex align-items-center justify-content-center w-100"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        Mi Cuenta
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('mi-perfil.edit') }}">
                                                <i class="fas fa-user-edit me-1"></i> Editar Perfil
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('ingreso.mostrar') }}">
                                                <i class="fas fa-door-open me-1"></i> Salas
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('actividad.usuario') }}">
                                                <i class="fas fa-calendar me-1"></i> Mi Actividad
                                            </a>
                                            
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item me-2" style="width: 176px;">
                                    <a href="{{ route('register') }}"
                                        class="btn btn-sm mb-0 btn-outline-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user-circle opacity-6 text-primary me-1"></i>
                                        Registrarse
                                    </a>
                                </li>
                                <li class="nav-item me-2" style="width: 176px;">
                                    <a href="{{ route('login') }}"
                                        class="btn btn-sm mb-0 btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-key opacity-6 text-white me-1"></i>
                                        Iniciar Sesión
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>