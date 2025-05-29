<button class="navbar-toggler ms-3 d-xl-none" type="button" id="iconSidenavToggle">
    <span class="navbar-toggler-icon"></span>
</button>

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
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}"
                    href="{{ route('home') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Menú de inicio</span>
                </a>
            </li>

            {{-- Comunidad --}}
            @canAny(['Acceso al Mantenedor de Alumnos', 'Acceso al Mantenedor de Carreras', 'Ver Usuarios', 'Crear Usuarios', 'Editar Usuarios', 'Eliminar Usuarios', 'Acceso al Mantenedor de Administradores'])
                <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Comunidad</h6>
                </li>
                @canany(['Acceso al Mantenedor de Alumnos'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'alumnos.index' ? 'active' : '' }}"
                            href="{{ route('alumnos.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-hat-3 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Alumnos</span>
                        </a>
                    </li>
                @endcanany
                @can('Acceso al Mantenedor de Carreras')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'carreras.index' ? 'active' : '' }}"
                            href="{{ route('carreras.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-book-bookmark text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Carreras</span>
                        </a>
                    </li>
                @endcan
                @canany(['Ver Usuarios', 'Crear Usuarios', 'Editar Usuarios', 'Eliminar Usuarios'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'usuarios.index' ? 'active' : '' }}"
                            href="{{ route('usuarios.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Usuarios</span>
                        </a>
                    </li>
                @endcanany
                @canany(['Acceso al Mantenedor de Administradores'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'administradores.index' ? 'active' : '' }}"
                            href="{{ route('administradores.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-badge text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Administradores</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Gestión de trabajo --}}
            @canany(['Acceso al Mantenedor de Talleres', 'Acceso a Gestión de Asistencia Talleres', 'Acceso a Gestión de QR', 'Acceso a Salas Abiertas'])
                <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="ni ni-laptop text-dark text-sm opacity-10"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión de trabajo</h6>
                </li>
                @canany(['Acceso a Salas Abiertas', 'Acceso a Gestión de QR'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'control-salas.seleccionar' ? 'active' : '' }}"
                            href="{{ route('control-salas.seleccionar') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-qrcode text-dark text-sm"></i>
                            </div>
                            <span class="nav-link-text ms-1">Gestión de QR</span>
                        </a>
                    </li>
                @endcanany
                @canany(['Acceso al Mantenedor de Talleres', 'Acceso a Gestión de Asistencia Talleres'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'talleres.index' ? 'active' : '' }}"
                            href="{{ route('talleres.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-briefcase-24 text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Talleres</span>
                        </a>
                    </li>
                @endcanany
            @endcanany

            {{-- Espacios --}}
            @canany(['Acceso al Mantenedor de Sucursales', 'Acceso al Mantenedor de Espacios', 'Acceso al Mantenedor de Salas', 'Acceso al Mantenedor de Máquinas', 'Acceso al Mantenedor de Tipos de Espacio', 'Acceso al Mantenedor de Tipos de Sanción'])
                <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="ni ni-building text-success text-sm opacity-10"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión de Espacios</h6>
                </li>
                @can('Acceso al Mantenedor de Sucursales')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'sucursales.index' ? 'active' : '' }}"
                            href="{{ route('sucursales.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-shop text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Sucursales</span>
                        </a>
                    </li>
                @endcan
                @can(['Acceso al Mantenedor de Espacios'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'espacios.index' ? 'active' : '' }}"
                            href="{{ route('espacios.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-album-2 text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Espacios</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Salas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'salas.index' ? 'active' : '' }}"
                            href="{{ route('salas.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-building text-warning text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Salas</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Máquinas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'maquinas.index' ? 'active' : '' }}"
                            href="{{ route('maquinas.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-settings text-secondary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Máquinas</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Tipos de Espacio')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'tipos_espacio.index' ? 'active' : '' }}"
                            href="{{ route('tipos_espacio.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-collection text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Tipos de Espacios</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Tipos de Sanción')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'tipos_sancion.index' ? 'active' : '' }}"
                            href="{{ route('tipos_sancion.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-watch-time text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Tipos de Sanción</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            {{-- Gestión Deportiva --}}
            @canany(['Acceso al Mantenedor de Deportes', 'Acceso al Mantenedor de Equipos', 'Acceso al Mantenedor de Torneos'])
                <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="ni ni-trophy text-warning text-sm opacity-10"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión Deportiva</h6>
                </li>
                @can(['Acceso al Mantenedor de Deportes'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'deportes.index' ? 'active' : '' }}"
                            href="{{ route('deportes.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-futbol text-dark text-sm"></i>
                            </div>
                            <span class="nav-link-text ms-1">Deportes</span>
                        </a>
                    </li>
                @endcan
                @can(['Acceso al Mantenedor de Equipos'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'equipos.index' ? 'active' : '' }}"
                            href="{{ route('equipos.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-user-run text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Equipos</span>
                        </a>
                    </li>
                @endcan
                @can(['Acceso al Mantenedor de Torneos'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'torneos.index' ? 'active' : '' }}"
                            href="{{ route('torneos.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-trophy text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Torneos</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            {{-- Geografía --}}
            @canany(['Acceso al Mantenedor de Ciudades', 'Acceso al Mantenedor de Regiones', 'Acceso al Mantenedor de Países'])
                <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="ni ni-world-2 text-info text-sm opacity-10"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Geografía</h6>
                </li>
                @can(['Acceso al Mantenedor de Ciudades'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'ciudades.index' ? 'active' : '' }}"
                            href="{{ route('ciudades.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-square-pin text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Ciudades</span>
                        </a>
                    </li>
                @endcan
                @can(['Acceso al Mantenedor de Regiones'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'regiones.index' ? 'active' : '' }}"
                            href="{{ route('regiones.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-pin-3 text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Regiones</span>
                        </a>
                    </li>
                @endcan
                @can(['Acceso al Mantenedor de Países'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'paises.index' ? 'active' : '' }}"
                            href="{{ route('paises.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-world text-info text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Países</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            {{-- Rutinas --}}
            @canany(['Acceso al Mantenedor de Rutinas', 'Acceso al Mantenedor de Ejercicios'])
                <li class="nav-item mt-3 d-flex align-items-center">
                    <div class="ps-4">
                        <i class="ni ni-calendar-grid-58 text-success text-sm opacity-10"></i>
                    </div>
                    <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Rutinas</h6>
                </li>
                @can('Acceso al Mantenedor de Rutinas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'rutinas.index' ? 'active' : '' }}"
                            href="{{ route('rutinas.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-success text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Gestión de Rutinas</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Ejercicios')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'ejercicios.index' ? 'active' : '' }}"
                            href="{{ route('ejercicios.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-dumbbell text-primary text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Gestión de Ejercicios</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            {{-- Reportes --}}
            {{-- Otros --}}
            <!-- <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-key-25 text-dark text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Configuración General</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'control-salas.seleccionar' ? 'active' : '' }}" href="{{ route('control-salas.seleccionar') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-planet text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Personalización</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="#">
                    <span class="nav-link-text ms-1"></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="#">
                    <span class="nav-link-text ms-1"></span>
                </a>
            </li>
            <li class="nav-item">
                <a class="#">
                    <span class="nav-link-text ms-1"></span>
                </a>
            </li>
        </ul>
    </div>
</aside>