<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            @if(!View::hasSection('ocultarHamburguesa'))
                <div class="d-flex align-items-center d-xl-none"
                    style="position: fixed; top: .7rem; left: 0.5rem; z-index: 1055;">
                    <button class="btn btn-icon btn-outline-primary text-white" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#sidenav-central" aria-controls="sidenav-central">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            @endif
            <h4 class="font-weight-bolder text-white mb-0 ms-0 ms-xl-0 ms-lg-5 ms-md-5 ms-sm-5 ms-5">{{ $title }}</h4>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <form role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link text-white font-weight-bold px-0">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Cerrar sesión</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->