<div class="offcanvas offcanvas-start d-xl-none bg-white bg-white navbar navbar-vertical navbar-expand-xs border-0 fixed-start"
    tabindex="-1" id="sidenav-central" aria-labelledby="offcanvasLabel" style="max-width: 17.125rem !important;">

    <div class="offcanvas-body position-sticky top-0 bg-white d-flex justify-content-center" style="z-index: 2;">
        <a class="navbar-brand m-0" href="{{ route('start') }}">
            <img src="{{ url('img\tenants\logo_ugym-fondoblanco.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">
    <ul class="navbar-nav">
        {{-- Inicio --}}
        <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() == 'tenants.index' ? 'active' : '' }}" href="{{ route('home') }}">
                <div class="ps-1">
                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    <span class="nav-link-text ms-1">Subdominios</span>
                </div>
            </a>
        </li>

        @include('layouts.tenants.navbars.tsiden')
    </ul>
</div>
</div>

<aside class="sidenav custom-sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 fixed-start"
    style="max-width: 17.125rem !important;" id="sidenav-central">

    <div class="sidenav-header position-sticky top-0 bg-white d-flex justify-content-center" style="z-index: 2;">
        <a class="navbar-brand m-0" href="{{ route('welcome') }}">
            <img src="{{ url('img\tenants\logo_ugym-fondoblanco.png') }}" class="navbar-brand-img" alt="main_logo">
        </a>
    </div>

    <hr class="horizontal dark mt-0">

    <div class="collapse navbar-collapse h-100 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- Inicio --}}
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'teanants.index' ? 'active' : '' }}"
                    href="{{ route('tenants.index') }}">
                    <div class="ps-1">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="ms-2 text-uppercase text-xs font-weight-bolder opacity-6 mb-0">Subdominios</span>
                </a>
            </li>

            {{-- Otros ítems --}}
            @include('layouts.tenants.navbars.tsiden')
        </ul>
    </div>
</aside>