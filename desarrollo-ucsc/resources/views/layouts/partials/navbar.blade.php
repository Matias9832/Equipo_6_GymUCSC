<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4">
    <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
        <img src="{{ asset('images/gym_logo.png') }}" alt="Logo GYM" style="height: 30px;" class="me-3">
        <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo UCSC" style="height: 30px;" class="me-3">
    </a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            @if (Route::has('login'))
                @auth
                    @if (Auth::user()->tipo_usuario === 'admin')
                        <li class="nav-item">
                            <a class="btn btn-dark btn-sm me-2" href="{{ route('admin.index') }}">
                                <i class="bi me-1"></i> Panel de Control
                            </a>
                        </li>
                    @endif
                    <li class="nav-item text-secondary">
                        <a class="nav-link" href="{{ route('ingreso.mostrar') }}">Ingresar a Sala</a>
                    </li>
                    <li class="nav-item d-flex align-items-center text-secondary small">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm ms-3">Cerrar sesión</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-danger btn-sm me-2">Iniciar sesión</a>
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
</nav>