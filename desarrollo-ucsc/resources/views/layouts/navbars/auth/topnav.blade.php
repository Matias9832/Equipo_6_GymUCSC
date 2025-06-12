<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid px-3 mt-3">
        <nav aria-label="breadcrumb">
            <h3 class="font-weight-bolder text-white mb-0 ms-0 ms-xl-0 ms-lg-5 ms-md-5 ms-sm-5 ms-5">{{ $title }}</h3>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                @if (in_array(request()->route()->getName(), ['carreras.index', 'administradores.index', 'usuarios.index', 'alumnos.index','asistencia.ver','docentes.index']))
                    <div class="input-group">
                        <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                        <input id="buscador-general" type="text" class="form-control" placeholder="Búsqueda">
                    </div>
                @endif
            </div>
            <ul class="navbar-nav justify-content-end align-items-center">
                {{-- Enlace a Mi perfil --}}
                <li class="nav-item d-flex align-items-center me-3">
                    <a class="nav-link text-white font-weight-bold px-0 mx-2" href="{{ route('docentes.perfil') }}">
                        <i class="fas fa-user-circle me-sm-1"></i>
                        <span class="d-sm-inline d-none">Mi perfil</span>
                    </a>
                </li>
                {{-- Botón de cerrar sesión --}}
                <li class="nav-item d-flex align-items-center">
                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link text-white font-weight-bold px-0">
                            <i class="fa fa-sign-out-alt me-sm-1"></i>
                            <span class="d-sm-inline d-none">Cerrar sesión</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
