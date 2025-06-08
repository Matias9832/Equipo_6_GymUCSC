{{-- Tenants --}}
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
        href="#submenuGeografia" role="button" aria-expanded="false" aria-controls="submenuGeografia">
        <div class="d-flex align-items-center">
            <div class="ps-1">
                <i class="ni ni-world-2 text-info text-sm opacity-10"></i>
            </div>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Geografía</span>
        </div>
    </a>
    <div class="collapse" id="submenuGeografia">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'ciudades.index' ? 'active' : '' }}"
                    href="{{ route('ciudades.index') }}">
                    <i class="ni ni-square-pin text-dark text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Ciudades</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'regiones.index' ? 'active' : '' }}"
                    href="{{ route('regiones.index') }}">
                    <i class="ni ni-pin-3 text-primary text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Regiones</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'paises.index' ? 'active' : '' }}"
                    href="{{ route('paises.index') }}">
                    <i class="ni ni-world text-info text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Países</span>
                </a>
            </li>
        </ul>
    </div>
</li>

{{-- Reportes --}}
{{-- Otros --}}
<!-- <li class="nav-item d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-key-25 text-dark text-sm opacity-10"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Configuración General</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'control-salas.seleccionar' ? 'active' : '' }}" href="{{ route('control-salas.seleccionar') }}">
                    <div class="ps-1">
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