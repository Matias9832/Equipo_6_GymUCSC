<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-1 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 mx-1">
        <nav aria-label="breadcrumb">
            <div class="d-flex align-items-center flex-wrap">
                @if (!View::hasSection('ocultarHamburguesa'))
                    <button class="btn btn-icon btn-outline-primary text-white d-xl-none me-2" type="button"
                        style="padding-left: 10px; padding-right: 10px; margin-bottom: 0 !important;"
                        data-bs-toggle="offcanvas" data-bs-target="#sidenav-central" aria-controls="sidenav-central">
                        <i class="fas fa-bars"></i>
                    </button>
                @endif
                <h4 class="font-weight-bolder text-white mb-0">{{ $title }}</h4>
            </div>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            </div>
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <form role="form" method="POST" action="{{ route('tenant-logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('tenant-logout') }}"
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