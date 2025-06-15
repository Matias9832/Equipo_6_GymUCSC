<!DOCTYPE html>
<html lang="en">

<head>
    @php
        use App\Models\Marca;
        $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
    @endphp

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url($ultimaMarca->logo_marca) }}">
    <!-- <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/img/apple-icon.png') }}"> -->
    <link rel="icon" type="image/png" href="{{ url($ultimaMarca->logo_marca) }}">
    <title>
        Panel de Control | Sistema de Gestión Deportes {{ $ultimaMarca->nombre_marca ?? 'Marca por defecto' }}
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ url('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ url('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="{{ url('assets/css/app.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    @php
        use App\Models\Tenants\TemaTenant;

        $tenant = tenancy()->tenant ?? null;

        $tema = $tenant
            ? TemaTenant::where('tenant_id', $tenant->id)->first()
            : null;
    @endphp

    @include('layouts.colors.tema-css', ['tema' => $tema])

</head>

<body class="{{ $class ?? '' }}">

    @if (!in_array(request()->route()->getName(), ['verificar.vista', 'reset-password', 'login']))
        @if(session('success') || session('update') || session('delete'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
                <div id="toastSuccess" class="toast align-items-center text-white 
                                                                {{ session('success') ? 'bg-success' : (session('update') ? 'bg-primary' : 'bg-danger') }} 
                                                                border-0 show" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body text-center w-100">
                            {{ session('success') ?? session('update') ?? session('delete') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Cerrar"></button>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toastLiveExample = document.getElementById('toastSuccess');
                    if (toastLiveExample) {
                        const toast = new bootstrap.Toast(toastLiveExample, { delay: 3000 });
                        toast.show();
                    }
                });
            </script>
        @endif

        @if(session('error'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
                <div id="toastError" class="toast align-items-center text-white bg-danger border-0 show" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body text-center w-100">
                            {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Cerrar"></button>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toastLiveExample = document.getElementById('toastError');
                    if (toastLiveExample) {
                        const toast = new bootstrap.Toast(toastLiveExample, { delay: 3000 });
                        toast.show();
                    }
                });
            </script>
        @endif
        @if(session('info'))
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
                <div id="toastInfo" class="toast align-items-center text-white bg-info border-0 show" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body text-center w-100">
                            {{ session('info') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Cerrar"></button>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toastLiveExample = document.getElementById('toastInfo');
                    if (toastLiveExample) {
                        const toast = new bootstrap.Toast(toastLiveExample, { delay: 3000 });
                        toast.show();
                    }
                });
            </script>
        @endif
    @endif


    @guest
        @yield('content')
    @endguest

    @auth
        @if (in_array(request()->route()->getName(), ['login', 'register', 'edit-perfil.edit', 'recover-password', 'salud.edit', 'salud.create']))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
                <div class="min-height-300 bg-primary position-absolute w-100"></div>
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                <div class="position-absolute w-100 min-height-300 top-0"
                    style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                    <span class="mask bg-primary opacity-6"></span>
                </div>
            @endif
            @include('layouts.navbars.auth.sidenav')
            <main class="main-content border-radius-lg">
                @yield('content')
            </main>
        @endif
    @endauth

    <!--   Core JS Files   -->
    <script src="{{ url('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- jQuery (debe ir antes de Select2 JS)
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- JS de Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Select2 base + Bootstrap 5 theme -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ url('assets/js/argon-dashboard.js') }}"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Idioma español -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <!-- Script Menú Collapsed -->
    <script>
        const submenus = document.querySelectorAll('.collapse');
        submenus.forEach(menu => {
            menu.addEventListener('show.bs.collapse', function () {
                submenus.forEach(m => {
                    if (m !== menu) {
                        new bootstrap.Collapse(m, { toggle: false }).hide();
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleBtn = document.getElementById("sidenav-toggle");
            const sidenav = document.getElementById("sidenav-main-collapsed");

            toggleBtn.addEventListener("click", function () {
                sidenav.classList.toggle("collapsed");
            });

            // Asegurar que se muestre correctamente al redimensionar
            window.addEventListener("resize", function () {
                if (window.innerWidth >= 1200) {
                    sidenav.classList.remove("collapsed");
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidenav = document.getElementById('sidenav-main-collapsed');
            const closeIcon = document.getElementById('iconSidenav');

            closeIcon?.addEventListener('click', function () {
                const bsCollapse = bootstrap.Collapse.getInstance(sidenav) || new bootstrap.Collapse(sidenav);
                bsCollapse.hide();
            });
        });
    </script>


    @stack('js')
    @stack('scripts')
</body>

</html>