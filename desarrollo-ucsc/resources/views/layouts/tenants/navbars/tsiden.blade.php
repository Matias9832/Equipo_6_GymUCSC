{{-- Tenants --}}
<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center
        {{ Route::currentRouteName() == 'empresas.index' ? 'active' : '' }}" href="{{ route('empresas.index') }}">
        <div class="d-flex align-items-center">
            <div class="ps-1">
                <i class="ni ni-building text-primary text-sm opacity-10"></i>
            </div>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Empresas</span>
        </div>
    </a>
</li>

@php
    $isPersonalizacionActive = in_array(Route::currentRouteName(), [
        'personalizacion.temas.index',
        'personalizacion.colores.index',
        'personalizacion.fuentes.index'
    ]); 
@endphp

<li class="nav-item">
    <a class="nav-link d-flex justify-content-between align-items-center {{ $isPersonalizacionActive ? 'active' : '' }}"
        data-bs-toggle="collapse" href="#submenuColores" role="button"
        aria-expanded="{{ $isPersonalizacionActive ? 'true' : 'false' }}" aria-controls="submenuColores">
        <div class="d-flex align-items-center">
            <div class="ps-1">
                <i class="ni ni-palette text-primary text-sm opacity-10"></i>
            </div>
            <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Personalización</span>
        </div>
    </a>
    <div class="collapse {{ $isPersonalizacionActive ? 'show' : '' }}" id="submenuColores">
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