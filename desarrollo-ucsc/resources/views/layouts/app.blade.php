<!DOCTYPE html>
<html lang="es">
    
<!-- Encabezado -->
@include('layouts.partials.header') 

<body class="bg-light">

    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Contenido principal -->
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
