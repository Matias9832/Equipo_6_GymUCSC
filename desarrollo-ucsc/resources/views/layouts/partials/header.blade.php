<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="{{ asset('images/gym_logo.png') }}" alt="Logo GYM" style="height: 30px;" class="me-3">
        <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo UCSC" style="height: 30px;" class="me-3">
    </a>
    <div class="ms-auto d-flex">
        @if (Route::has('login'))
            @auth
                <div class="d-flex align-items-center me-3 text-secondary small">
                    <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-danger btn-sm me-2">Iniciar sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-danger btn-sm">Registrarse</a>
                @endif
            @endauth
        @endif
    </div>
</nav>