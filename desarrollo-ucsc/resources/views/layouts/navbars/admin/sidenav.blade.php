<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('welcome') }}">
            <img src="{{ asset('images/ucsc_logo.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Panel de Control</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav h-100">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/admin') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-house-door text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/alumnos*') ? 'active' : '' }}" href="{{ route('alumnos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-people text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Alumnos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/usuarios') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Usuarios</span>
                </a>
            </li>
            @role('Super Admin|Director')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/sucursales*') ? 'active' : '' }}" href="{{ route('sucursales.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-shop text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sucursales</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/espacios*') ? 'active' : '' }}" href="{{ route('espacios.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-rocket-takeoff text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Espacios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/salas*') ? 'active' : '' }}" href="{{ route('salas.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-rocket-takeoff text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Salas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/deportes') ? 'active' : '' }}" href="{{ route('deportes.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-trophy text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Deportes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/equipos') ? 'active' : '' }}" href="{{ route('equipos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-trophy text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Equipos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/torneos') ? 'active' : '' }}" href="{{ route('torneos.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-trophy text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Torneos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/maquinas*') ? 'active' : '' }}" href="{{ route('maquinas.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-gear text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Máquinas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/tipos_espacio*') ? 'active' : '' }}" href="{{ route('tipos_espacio.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-rocket-takeoff text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tipos de Espacios</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/tipos_sancion*') ? 'active' : '' }}" href="{{ route('tipos_sancion.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-hourglass-split text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tipos de Sanción</span>
                </a>
            </li>
            @endrole
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/control-salas/seleccionar') ? 'active' : '' }}" href="{{ route('control-salas.seleccionar') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-people text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión de QR</span>
                </a>
            </li>
            @role('Super Admin')
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#mantenedoresGeograficos" role="button" aria-expanded="false" aria-controls="mantenedoresGeograficos">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-geo-alt text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mantenedores Geográficos</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="mantenedoresGeograficos">
                    <ul class="navbar-nav ms-3">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/ciudades') ? 'active' : '' }}" href="{{ route('ciudades.index') }}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-building text-dark text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Ciudades</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/regiones') ? 'active' : '' }}" href="{{ route('regiones.index') }}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-map text-dark text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Regiones</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/paises') ? 'active' : '' }}" href="{{ route('paises.index') }}">
                                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-globe text-dark text-sm opacity-10"></i>
                                </div>
                                <span class="nav-link-text ms-1">Países</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/administradores*') ? 'active' : '' }}" href="{{ route('administradores.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-badge text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Administradores</span>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</aside>