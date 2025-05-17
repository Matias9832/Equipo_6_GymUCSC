<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4">
    <div class="container-fluid">
        <!-- Logos -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
            <img src="{{ asset('images/gym_logo.png') }}" alt="Logo GYM" style="height: 30px;" class="me-3">
            <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo UCSC" style="height: 30px;" class="me-3">
        </a>

        <!-- Botón de colapso para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Elementos del menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center mt-3 mt-lg-0">
                @if (Route::has('login'))
                    @auth
                        @if (Auth::user()->tipo_usuario === 'admin')
                            <li class="nav-item me-2">
                                <a class="btn btn-dark btn-sm" href="{{ route('admin.index') }}">
                                    <i class="bi me-1"></i> Panel de Control
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> Mi Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('mi-perfil.edit') }}">
                                        <i class="bi bi-person"></i> Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('ingreso.mostrar') }}">
                                        <i class="bi bi-door-open"></i> Salas
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('actividad.usuario') }}">
                                        <i class="bi bi-graph-up"></i> Mi Actividad
                                    </a>
                                </li>
                                
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @else
                        <li class="nav-item me-2">
                            <a href="{{ route('login') }}" class="btn btn-danger btn-sm">Iniciar sesión</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn btn-outline-danger btn-sm">Registrarse</a>
                            </li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>