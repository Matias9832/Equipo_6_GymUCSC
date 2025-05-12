<!DOCTYPE html>
<html lang="es">

<!-- Encabezado -->
@include('layouts.partials.header') 

<body class="bg-light">

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Botón para abrir sidebar en móvil -->
    @if(View::hasSection('sidebar'))
    <div class="d-md-none p-2 bg-white border-bottom shadow-sm">
        <button class="btn btn-outline-dark w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="bi bi-list me-2"></i> Panel de administrador
        </button>
    </div>

    <!-- Offcanvas Sidebar para móviles -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Panel de administrador</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
        </div>
        <div class="offcanvas-body">
            @yield('sidebar')
        </div>
    </div>
    @endif

    <!-- Toastr de mensajes -->
    @if(session('success') || session('update') || session('delete'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100; margin-top: 70px;">
            <div id="toastSuccess" class="toast align-items-center text-white 
                {{ session('success') ? 'bg-success' : (session('update') ? 'bg-primary' : 'bg-danger') }} 
                border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body text-center w-100">
                        {{ session('success') ?? session('update') ?? session('delete') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastLiveExample = document.getElementById('toastSuccess');
                if (toastLiveExample) {
                    const toast = new bootstrap.Toast(toastLiveExample, { delay: 3000 });
                    toast.show();
                }
            });
        </script>
    @endif

    @if(session('error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100; margin-top: 70px;">
            <div id="toastError" class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body text-center w-100">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastLiveExample = document.getElementById('toastError');
                if (toastLiveExample) {
                    const toast = new bootstrap.Toast(toastLiveExample, { delay: 3000 });
                    toast.show();
                }
            });
        </script>
    @endif

    <!-- Layout con sidebar si existe -->
    @if(View::hasSection('sidebar'))
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar solo visible en escritorio -->
        <aside class="bg-light border-end d-none d-md-block" style="width: 250px; min-height: 100vh;">
            @yield('sidebar')
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
    @else
    <!-- Solo contenido sin sidebar -->
    <main class="container my-4">
        @yield('content')
    </main>
    @endif

    <!-- Footer -->
    @if (!Request::is('admin*')) <!-- Oculta el footer en rutas que comiencen con "admin" -->
        @include('layouts.partials.footer')
    @endif
</body>
</html>
