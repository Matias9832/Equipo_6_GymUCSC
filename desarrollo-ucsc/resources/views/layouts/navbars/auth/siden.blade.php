@php
    $parentId = $parentId ?? 'sidenav-collapse-main'; // valor por defecto

    // Determina si el submenú Comunidad debe estar abierto
    $comunidadOpen = request()->routeIs('usuarios.index') ||
                     request()->routeIs('docentes.index') ||
                     request()->routeIs('administradores.index') ||
                     request()->routeIs('roles.index') ||
                     request()->routeIs('alumnos.index') ||
                     request()->routeIs('carreras.index');
    // Determina si el submenú Gestión de trabajo debe estar abierto
    $gestionTrabajoOpen = request()->routeis('control-salas*') ||
                         request()->routeIs('talleres*');
    // Determina si el submenú Gestión de Espacios debe estar abierto
    $gestionEspaciosOpen = request()->routeIs('sucursales*') ||
                           request()->routeIs('espacios*') ||
                           request()->routeIs('salas*') ||
                           request()->routeIs('maquinas*') ||
                           request()->routeIs('tipos_espacio*') ||
                           request()->routeIs('tipos_sancion*');
    // Determina si el submenú Gestión Deportiva debe estar abierto
    $gestionDeportivaOpen = request()->routeIs('deportes*') || 
                            request()->routeIs('equipos*') || 
                            request()->routeIs('torneos*');
    // Determina si el submenú Rutinas debe estar abierto
    $gestionRutinasOpen = request()->routeIs('rutinas*') ||
                          request()->routeIs('ejercicios*');
    // Determina si el submenú Geografía debe estar abierto
    $geografiaOpen = request()->routeIs('ciudades*') ||
                    request()->routeIs('regiones*') ||
                    request()->routeIs('paises*');
    // Determina si el submenú Reportes debe estar abierto
    $reportesOpen = request()->routeIs('datos-salas*') ||
                    request()->routeIs('datos-talleres*');

@endphp
            {{-- Comunidad --}}
@canAny(['Acceso al Mantenedor de Alumnos', 'Acceso al Mantenedor de Carreras', 'Ver Usuarios', 'Crear Usuarios', 'Editar Usuarios', 'Eliminar Usuarios', 'Acceso al Mantenedor de Administradores'])
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center{{ $comunidadOpen ? '' : ' collapsed' }}"
        data-bs-toggle="collapse"
        href="#submenuComunidad"
        role="button"
        aria-expanded="{{ $comunidadOpen ? 'true' : 'false' }}"
        aria-controls="submenuComunidad">
        <div class="d-flex align-items-center">
            <i class="ni ni-single-02 text-dark text-sm opacity-10 ps-1"></i>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Comunidad</span>
        </div>
    </a>
    <div class="collapse{{ $comunidadOpen ? ' show' : '' }}" id="submenuComunidad" data-bs-parent="#{{ $parentId }}">
        <ul class="nav flex-column ms-3">
            @canany(['Ver Usuarios', 'Crear Usuarios', 'Editar Usuarios', 'Eliminar Usuarios'])
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'usuarios.index' ? 'active' : '' }}"
                    href="{{ route('usuarios.index') }}">
                    <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i> Usuarios
                </a>
            </li>
            @endcanany
            @can('Acceso al Mantenedor de Alumnos')
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'docentes.index' ? 'active' : '' }}"
                    href="{{ route('docentes.index') }}">
                    <i class="fas fa-chalkboard-teacher text-dark text-sm opacity-10"></i> Docentes
                </a>
            </li>
            @endcan
            @can('Acceso al Mantenedor de Administradores')
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'administradores.index' ? 'active' : '' }}"
                    href="{{ route('administradores.index') }}">
                    <i class="ni ni-badge text-dark text-sm opacity-10"></i> Administradores
                </a>
            </li>
            @endcan
            @can('Acceso al Mantenedor de Roles')
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}"
                    href="{{ route('roles.index') }}">
                    <i class="ni ni-watch-time text-dark text-sm opacity-10"></i> Roles
                </a>
            </li>
            @endcan
            @can('Acceso al Mantenedor de Alumnos')
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'alumnos.index' ? 'active' : '' }}"
                    href="{{ route('alumnos.index') }}">
                    <i class="ni ni-hat-3 text-dark text-sm opacity-10"></i> Alumnos
                </a>
            </li>
            @endcan
            @can('Acceso al Mantenedor de Carreras')
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'carreras.index' ? 'active' : '' }}"
                    href="{{ route('carreras.index') }}">
                    <i class="ni ni-book-bookmark text-dark text-sm opacity-10"></i> Carreras
                </a>
            </li>
            @endcan
        </ul>
    </div>
</li>
@endcanany

{{-- Gestión de trabajo --}}
@canany(['Acceso al Mantenedor de Talleres', 'Acceso a Gestión de Asistencia Talleres', 'Acceso a Gestión de QR', 'Acceso a Salas Abiertas'])
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center{{ $gestionTrabajoOpen ? '' : ' collapsed' }}"
            data-bs-toggle="collapse"
            href="#submenuGestionTrabajo"
            role="button"
            aria-expanded="{{ $gestionTrabajoOpen ? 'true' : 'false' }}"
            aria-controls="submenuGestionTrabajo">
            <div class="d-flex align-items-center">
                <i class="ni ni-laptop text-dark text-sm opacity-10 ps-1"></i>
                <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión de trabajo</span>
            </div>
        </a>
        <div class="collapse{{ $gestionTrabajoOpen ? ' show' : '' }}" id="submenuGestionTrabajo" data-bs-parent="#{{ $parentId }}">
            <ul class="nav flex-column ms-3">
                @canany(['Acceso a Salas Abiertas', 'Acceso a Gestión de QR'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'control-salas.seleccionar' ? 'active' : '' }}"
                            href="{{ route('control-salas.seleccionar') }}">
                            <i class="fas fa-qrcode text-dark text-sm opacity-10"></i> Gestión de QR
                        </a>
                    </li>
                @endcanany
                @canany(['Acceso al Mantenedor de Talleres', 'Acceso a Gestión de Asistencia Talleres'])
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'talleres.index' ? 'active' : '' }}"
                            href="{{ route('talleres.index') }}">
                            <i class="ni ni-briefcase-24 text-dark text-sm opacity-10"></i> Talleres
                        </a>
                    </li>
                @endcanany
            </ul>
        </div>
    </li>
@endcanany

{{-- Espacios --}}
@canany(['Acceso al Mantenedor de Sucursales', 'Acceso al Mantenedor de Espacios', 'Acceso al Mantenedor de Salas', 'Acceso al Mantenedor de Máquinas', 'Acceso al Mantenedor de Tipos de Espacio', 'Acceso al Mantenedor de Tipos de Sanción'])
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center{{ $gestionEspaciosOpen ? '' : ' collapsed' }}"
            data-bs-toggle="collapse"
            href="#submenuGestionEspacios"
            role="button"
            aria-expanded="{{ $gestionEspaciosOpen ? 'true' : 'false' }}"
            aria-controls="submenuGestionEspacios">
            <div class="d-flex align-items-center">
                <i class="ni ni-building text-dark text-sm opacity-10 ps-1"></i>
                <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión de Espacios</span>
            </div>
        </a>
        <div class="collapse{{ $gestionEspaciosOpen ? ' show' : '' }}" id="submenuGestionEspacios" data-bs-parent="#{{ $parentId }}">
            <ul class="nav flex-column ms-3">
                @can('Acceso al Mantenedor de Sucursales')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'sucursales.index' ? 'active' : '' }}"
                            href="{{ route('sucursales.index') }}">
                            <i class="ni ni-shop text-dark text-sm opacity-10"></i> Sucursales
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Espacios')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'espacios.index' ? 'active' : '' }}"
                            href="{{ route('espacios.index') }}">
                            <i class="ni ni-album-2 text-dark text-sm opacity-10"></i> Espacios
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Salas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'salas.index' ? 'active' : '' }}"
                            href="{{ route('salas.index') }}">
                            <i class="ni ni-building text-dark text-sm opacity-10"></i> Salas
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Máquinas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'maquinas.index' ? 'active' : '' }}"
                            href="{{ route('maquinas.index') }}">
                            <i class="ni ni-settings text-dark text-sm opacity-10"></i> Máquinas
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Tipos de Espacio')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'tipos_espacio.index' ? 'active' : '' }}"
                            href="{{ route('tipos_espacio.index') }}">
                            <i class="ni ni-collection text-dark text-sm opacity-10"></i> Tipos de Espacios
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Tipos de Sanción')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'tipos_sancion.index' ? 'active' : '' }}"
                            href="{{ route('tipos_sancion.index') }}">
                            <i class="ni ni-watch-time text-dark text-sm opacity-10"></i> Tipos de Sanción
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
@endcanany

            {{-- Gestión Deportiva --}}
@canany(['Acceso al Mantenedor de Deportes', 'Acceso al Mantenedor de Equipos', 'Acceso al Mantenedor de Torneos'])
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center{{ $gestionDeportivaOpen ? '' : ' collapsed' }}"
            data-bs-toggle="collapse"
            href="#submenuDeportivo"
            role="button"
            aria-expanded="{{ $gestionDeportivaOpen ? 'true' : 'false' }}"
            aria-controls="submenuDeportivo">
            <div class="d-flex align-items-center">
                <div class="ps-1">
                    <i class="ni ni-trophy text-dark text-sm opacity-10"></i>
                </div>
                <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión Deportiva</span>
            </div>
        </a>
        <div class="collapse{{ $gestionDeportivaOpen ? ' show' : '' }}" id="submenuDeportivo" data-bs-parent="#{{ $parentId }}">
            <ul class="nav flex-column ms-3">
                @can('Acceso al Mantenedor de Deportes')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'deportes.index' ? 'active' : '' }}"
                            href="{{ route('deportes.index') }}">
                            <i class="fas fa-futbol text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Deportes</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Equipos')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'equipos.index' ? 'active' : '' }}"
                            href="{{ route('equipos.index') }}">
                            <i class="ni ni-user-run text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Equipos</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Torneos')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'torneos.index' ? 'active' : '' }}"
                            href="{{ route('torneos.index') }}">
                            <i class="ni ni-trophy text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Torneos</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
@endcanany

{{-- Rutinas --}}
@canany(['Acceso al Mantenedor de Rutinas', 'Acceso al Mantenedor de Ejercicios'])
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center{{ $gestionRutinasOpen ? '' : ' collapsed' }}"
            data-bs-toggle="collapse"
            href="#submenuRutinas"
            role="button"
            aria-expanded="{{ $gestionRutinasOpen ? 'true' : 'false' }}"
            aria-controls="submenuRutinas">
            <div class="d-flex align-items-center ps-1">
                <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Gestión de Rutinas</span>
            </div>
        </a>
        <div class="collapse{{ $gestionRutinasOpen ? ' show' : '' }}" id="submenuRutinas" data-bs-parent="#{{ $parentId }}">
            <ul class="nav flex-column ms-3">
                @can('Acceso al Mantenedor de Rutinas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'rutinas.index' ? 'active' : '' }}"
                            href="{{ route('rutinas.index') }}">
                            <i class="fas fa-tasks text-dark text-sm opacity-10"></i>Rutinas
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Ejercicios')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'ejercicios.index' ? 'active' : '' }}"
                            href="{{ route('ejercicios.index') }}">
                            <i class="fas fa-dumbbell text-dark text-sm opacity-10"></i>Ejercicios
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
@endcanany

{{-- Geografía --}}
@canany(['Acceso al Mantenedor de Ciudades', 'Acceso al Mantenedor de Regiones', 'Acceso al Mantenedor de Países'])
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center{{ $geografiaOpen ? '' : ' collapsed' }}"
            data-bs-toggle="collapse"
            href="#submenuGeografia"
            role="button"
            aria-expanded="{{ $geografiaOpen ? 'true' : 'false' }}"
            aria-controls="submenuGeografia">
            <div class="d-flex align-items-center">
                <div class="ps-1">
                    <i class="ni ni-world-2 text-dark text-sm opacity-10"></i>
                </div>
                <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Geografía</span>
            </div>
        </a>
        <div class="collapse{{ $geografiaOpen ? ' show' : '' }}" id="submenuGeografia" data-bs-parent="#{{ $parentId }}">
            <ul class="nav flex-column ms-3">
                @can('Acceso al Mantenedor de Ciudades')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'ciudades.index' ? 'active' : '' }}"
                            href="{{ route('ciudades.index') }}">
                            <i class="ni ni-square-pin text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Ciudades</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Regiones')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'regiones.index' ? 'active' : '' }}"
                            href="{{ route('regiones.index') }}">
                            <i class="ni ni-pin-3 text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Regiones</span>
                        </a>
                    </li>
                @endcan
                @can('Acceso al Mantenedor de Países')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'paises.index' ? 'active' : '' }}"
                            href="{{ route('paises.index') }}">
                            <i class="ni ni-world text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Países</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
@endcanany

{{-- Reportes --}}
@canany(['Datos Salas', 'Datos Talleres'])
    <li class="nav-item">
        <a class="nav-link d-flex justify-content-between align-items-center{{ $reportesOpen ? '' : ' collapsed' }}"
            data-bs-toggle="collapse"
            href="#submenuDatos"
            role="button"
            aria-expanded="{{ $reportesOpen ? 'true' : 'false' }}"
            aria-controls="submenuDatos">
            <div class="d-flex align-items-center">
                <div class="ps-1">
                    <i class="ni ni-chart-bar-32 text-dark text-sm opacity-10"></i>
                </div>
                <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Reportes</span>
            </div>
        </a>
        <div class="collapse{{ $reportesOpen ? ' show' : '' }}" id="submenuDatos" data-bs-parent="#{{ $parentId }}">
            <ul class="nav flex-column ms-3">
                @can('Datos Salas')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'datos-salas.index' ? 'active' : '' }}"
                            href="{{ route('datos-salas.index') }}">
                            <i class="fas fa-chart-line text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Datos Salas</span>
                        </a>
                    </li>
                @endcan
                @can('Datos Talleres')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'datos-talleres.index' ? 'active' : '' }}"
                            href="{{ route('datos-talleres.index') }}">
                            <i class="fas fa-chart-line text-dark text-sm opacity-10"></i>
                            <span class="nav-link-text ms-1">Datos Talleres</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </li>
@endcanany
            
            <style>
            .collapse {
                transition: height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            }
            </style>
            