@php
    use App\Models\Marca;
    $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
@endphp

<div class="offcanvas offcanvas-start d-xl-none bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 mt-2"
    tabindex="-1" id="sidenav-main" aria-labelledby="offcanvasLabel" style="width: 250px;">

    <div class="offcanvas-body position-sticky top-0 bg-white" style="z-index: 2;">

        <a class="navbar-brand m-0" href="{{ route('welcome') }}">
            <img src="{{ url($ultimaMarca->logo_marca) }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Panel de Control</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">
    <ul class="navbar-nav">
        {{-- Inicio --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="ps-1">
                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Menú de inicio</span>
                </div>
            </a>
        </li>

        @include('layouts.navbars.auth.siden')
    </ul>
</div>
</div>

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">

    <div class="sidenav-header position-sticky top-0 bg-white" style="z-index: 2;">

        <a class="navbar-brand m-0" href="{{ route('welcome') }}">
            <img src="{{ url($ultimaMarca->logo_marca) }}" class="navbar-brand-img h-100" alt="main_logo">
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
                    <div class="ps-1">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        <span class="nav-link-text ms-1">Menú de inicio</span>
                    </div>
                </a>
            </li>

            @include('layouts.navbars.auth.siden')
        </ul>
    </div>
</aside>