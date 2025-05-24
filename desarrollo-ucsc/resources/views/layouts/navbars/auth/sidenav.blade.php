<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header position-sticky top-0 bg-white" style="z-index: 2;">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('welcome') }}">
            <img src="{{ asset('img/gym/ucsc_logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Panel de Control</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse h-100 w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- Inicio --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Menú de inicio</span>
                </a>
            </li>

            {{-- Comunidad --}}
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Comunidad</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'alumnos.index' ? 'active' : '' }}" href="{{ route('alumnos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-hat-3 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Alumnos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'usuarios.index' ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Usuarios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'administradores.index' ? 'active' : '' }}" href="{{ route('administradores.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-badge text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Administradores</span>
                </a>
            </li>

            {{-- Espacios --}}
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-building text-success text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión de Espacios</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'sucursales.index' ? 'active' : '' }}" href="{{ route('sucursales.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-shop text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sucursales</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'espacios.index' ? 'active' : '' }}" href="{{ route('espacios.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-world text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Espacios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'salas.index' ? 'active' : '' }}" href="{{ route('salas.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-building text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Salas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'maquinas.index' ? 'active' : '' }}" href="{{ route('maquinas.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-settings text-secondary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Máquinas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'tipos_espacio.index' ? 'active' : '' }}" href="{{ route('tipos_espacio.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-collection text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tipos de Espacios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'tipos_sancion.index' ? 'active' : '' }}" href="{{ route('tipos_sancion.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-watch-time text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tipos de Sanción</span>
                </a>
            </li>

            {{-- Gestión Deportiva --}}
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-trophy text-warning text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión Deportiva</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'deportes.index' ? 'active' : '' }}" href="{{ route('deportes.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-trophy text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Deportes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'talleres.index' ? 'active' : '' }}" href="{{ route('talleres.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-trophy text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">talleres</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'equipos.index' ? 'active' : '' }}" href="{{ route('equipos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-user-run text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Equipos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'torneos.index' ? 'active' : '' }}" href="{{ route('torneos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-basket text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Torneos</span>
                </a>
            </li>

            {{-- Geografía --}}
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-world-2 text-info text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Geografía</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'ciudades.index' ? 'active' : '' }}" href="{{ route('ciudades.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-building text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Ciudades</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'regiones.index' ? 'active' : '' }}" href="{{ route('regiones.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-pin-3 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Regiones</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'paises.index' ? 'active' : '' }}" href="{{ route('paises.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-world text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Países</span>
                </a>
            </li>

            {{-- Otros --}}
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-key-25 text-dark text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Otros</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'control-salas.seleccionar' ? 'active' : '' }}" href="{{ route('control-salas.seleccionar') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-planet text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión de QR</span>
                </a>
            </li>
        </ul>
    </div>
</aside>