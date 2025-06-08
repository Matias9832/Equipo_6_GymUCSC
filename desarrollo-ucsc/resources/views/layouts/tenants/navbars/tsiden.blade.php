{{-- Tenants --}}
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center" href="{{ route('empresas.index') }}">
        <div class="d-flex align-items-center">
            <div class="ps-1">
                <i class="ni ni-building text-primary text-sm opacity-10"></i>
            </div>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Empresas</span>
        </div>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
        href="#submenuColores" role="button" aria-expanded="false" aria-controls="submenuColores">
        <div class="d-flex align-items-center">
            <div class="ps-1">
                <i class="ni ni-palette text-primary text-sm opacity-10"></i>
            </div>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Personalización</span>
        </div>
    </a>
    <div class="collapse" id="submenuColores">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'personalizacion.temas.index' ? 'active' : '' }}"
                    href="{{ route('personalizacion.temas.index') }}">
                    <i class="ni ni-badge text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Temas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'personalizacion.colores.index' ? 'active' : '' }}"
                    href="{{ route('personalizacion.colores.index') }}">
                    <i class="ni ni-palette text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Colores</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'personalizacion.fuentes.index' ? 'active' : '' }}"
                    href="{{ route('personalizacion.fuentes.index') }}">
                    <i class="ni ni-align-left-2 text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Fuentes</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
        href="#submenuPlanes" role="button" aria-expanded="false" aria-controls="submenuPlanes">
        <div class="d-flex align-items-center">
            <div class="ps-1">
                <i class="ni ni-folder-17 text-primary text-sm opacity-10"></i>
            </div>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Planes</span>
        </div>
    </a>
    <div class="collapse" id="submenuPlanes">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'planes.index' ? 'active' : '' }}"
                    href="{{ route('planes.index') }}">
                    <i class="ni ni-collection text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Planes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'planes.cuentas.index' ? 'active' : '' }}"
                    href="{{ route('planes.cuentas.index') }}">
                    <i class="ni ni-single-copy-04 text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Cuentas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'planes.permisos.index' ? 'active' : '' }}"
                    href="{{ route('planes.permisos.index') }}">
                    <i class="ni ni-key-25 text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Permisos</span>
                </a>
            </li>
        </ul>
    </div>
</li>
