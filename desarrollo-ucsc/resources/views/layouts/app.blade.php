<!DOCTYPE html>
<html lang="es">
    
<!-- Encabezado -->
@include('layouts.partials.header') 


<body class="bg-light">

    <!-- Navbar -->
    @include('layouts.partials.navbar')
    
    <!-- Contenido principal -->
    
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
                        const toast = new bootstrap.Toast(toastLiveExample, {
                            delay: 3000 // Se cierra a los 3 segundos
                        });
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
                        const toast = new bootstrap.Toast(toastLiveExample, {
                            delay: 3000
                        });
                        toast.show();
                    }
                });
            </script>
        @endif

    
    @if(View::hasSection('sidebar'))
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <aside class="bg-light border-end" style="width: 250px; min-height: 100vh;">
            @yield('sidebar')
        </aside>
        
        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
    @else
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
