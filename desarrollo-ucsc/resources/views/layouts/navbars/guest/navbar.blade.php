<div id="main-navbar" class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow mt-4 py-2">
                <div class="container-fluid">
                    <!-- Logos -->
                    <a class="navbar-brand d-flex align-items-center font-weight-bolder ms-lg-0 ms-3"
                        href=" {{ route('welcome') }}">
                        @php
                            use App\Models\Marca;
                            $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
                        @endphp
                        <img src="{{ url($ultimaMarca->logo_marca) }}" alt="Logo Marca" style="height: 30px;"
                            class="me-2">
                    </a>
                    <!-- Botones de navegación -->
                    <div class="d-flex align-items-center flex-wrap overflow-auto" >
                        <ul class="nav nav-tabs custom-tab-buttons" role="tablist">
                            <li class="nav-item" role="presentation" >
                                <a class="nav-link custom-button {{ request()->routeIs('welcome') ? 'active' : '' }}"
                                href="{{ route('welcome') }}">
                                    <span class="button-main-text">Inicio</span>
                                    <span class="underline-text"></span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link custom-button {{ request()->routeIs('academynews.index') ? 'active' : '' }}"
                                href="{{ route('academynews.index') }}">
                                    <span class="button-main-text">Academia Deportiva</span>
                                    <span class="underline-text"></span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link custom-button {{ request()->routeIs('talleresnews.index') ? 'active' : '' }}"
                                    href="{{ route('talleresnews.index') }}">
                                    <span class="button-main-text">Talleres Extraprogamaticos</span>
                                    <span class="underline-text"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Botones de cuenta -->
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav ms-auto align-items-center">
                            @auth
                                @if(auth()->user()->tipo_usuario === 'admin')
                                    <li class="nav-item me-2 mb-1" style="width: 176px;">
                                        <a href="{{ route('home') }}"
                                            class="btn btn-sm mb-0 btn-primary d-flex align-items-center">
                                            <i class="fa fa-chart-pie opacity-6 text-white me-1"></i>
                                            Panel de control
                                        </a>
                                    </li>
                                @endif
                                <li class="nav-item me-2 dropdown mb-1" style="width: 176px;">
                                    <a class="btn btn-sm mb-0 btn-light dropdown-toggle d-flex align-items-center justify-content-center w-100"
                                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                                        Mi Cuenta
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        @if(auth()->user()->tipo_usuario === 'admin')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('docentes.perfil') }}">
                                                    <i class="fas fa-user-circle me-sm-1"></i>Mi perfil
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a class="dropdown-item" href="{{ route('edit-perfil.edit') }}">
                                                    <i class="fas fa-user-edit me-1"></i> Editar Perfil
                                                </a>
                                            </li>
                                        @endif
                                        <li>
                                            <a class="dropdown-item" href="{{ route('ingreso.mostrar') }}">
                                                <i class="fas fa-door-open me-1"></i> Salas
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('usuario.talleres') }}" class="dropdown-item">
                                                <i class="fas fa-chalkboard-teacher me-2"></i> Mis Talleres
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('rutinas.personalizadas.index') }}" class="dropdown-item">
                                                <i class="fa fa-dumbbell me-2"></i> Rutinas
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('actividad.usuario') }}">
                                                <i class="fas fa-calendar me-1"></i> Mi Actividad
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('torneos.usuario.index') }}">
                                                <i class="fas fa-trophy me-1"></i> Torneos
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item me-2 mb-1" style="width: 176px;">
                                    <a href="{{ route('login') }}"
                                        class="btn btn-sm mb-0 btn-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-key opacity-6 text-white me-1"></i>
                                        Iniciar Sesión
                                    </a>
                                </li>
                                <li class="nav-item me-2 mb-1" style="width: 176px;">
                                    <a href="{{ route('register') }}"
                                        class="btn btn-sm mb-0 btn-outline-primary d-flex align-items-center justify-content-center">
                                        <i class="fas fa-user-circle opacity-6 text-primary me-1"></i>
                                        Registrarse
                                    </a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var navbar = document.getElementById("main-navbar");
        var headroom = new Headroom(navbar, {
            tolerance: 5,
            offset: 100,
            classes: {
                initial: "headroom",
                pinned: "headroom--pinned",
                unpinned: "headroom--unpinned",
                top: "headroom--top",
                notTop: "headroom--not-top"
            }
        });
        headroom.init();
    });
</script>
<style>
/* Resetear estilos de nav-tabs */
.custom-tab-buttons {
    border-bottom: none !important; /* Elimina el borde inferior feo */
}

.custom-tab-buttons .nav-item {
    margin-right: 0.5rem; /* Espacio entre los botones */
    margin-bottom: 0; /* Asegura que no haya margen inferior extra */
}

/* Estilos para los botones de Inicio y Academia */
.custom-tab-buttons .custom-button {
    display: flex; /* Usar flexbox para organizar texto y subrayado */
    flex-direction: column; /* Apilar texto y subrayado */
    align-items: center; /* Centrar horizontalmente */
    justify-content: center; /* Centrar verticalmente */
    padding: 0.625rem 1.25rem; /* Padding para un tamaño de botón adecuado */
    border-radius: 0.5rem; /* Bordes redondeados */
    font-weight: 600; /* Hace el texto un poco más audaz */
    transition: all 0.2s ease-in-out; /* Transición suave para hover */
    text-decoration: none; /* Quita el subrayado del enlace */
    color: #67748e; /* Color de texto por defecto de Argon (gris) */
    background-color: transparent !important; /* Asegura que no haya background, incluso en active */
    border: none; /* Elimina cualquier borde no deseado de los enlaces */
    position: relative; /* Necesario para posicionar el subrayado */
    overflow: hidden; /* Asegura que el subrayado no se desborde al animarse */
    white-space: nowrap; /* Evita que el texto se "rompa" en varias líneas */
}

/* Estilo para el texto principal del botón */
.custom-tab-buttons .custom-button .button-main-text {
    position: relative; /* Necesario para que el texto no se mueva */
    z-index: 2; /* Para que el texto esté por encima del subrayado */
}

/* Estilo para la línea de subrayado */
.custom-tab-buttons .custom-button .underline-text {
    content: '';
    position: absolute;
    bottom: 0.2rem; /* Distancia desde la parte inferior del botón */
    left: 50%; /* Centrar la línea */
    transform: translateX(-50%); /* Centrar la línea */
    width: 0; /* Ancho inicial 0 para la animación */
    height: 3px; /* Grosor de la línea */
    background-color: var(--bs-primary); /* Color primary de Bootstrap/Argon */
    transition: width 0.3s ease-in-out; /* Animación de ancho */
    border-radius: 2px; /* Pequeño radio para suavizar los bordes de la línea */
}

/* Efecto al pasar el ratón (hover) */
.custom-tab-buttons .custom-button:hover {
    color: #344767; /* Color de texto más oscuro al pasar el ratón */
    background-color: transparent !important; /* Asegura que no haya background en hover */
}

/* Animación del subrayado al pasar el ratón */
.custom-tab-buttons .custom-button:hover .underline-text {
    width: 80%; /* Ancho de la línea al pasar el ratón */
}

/* Estilo para el botón activo */
.custom-tab-buttons .custom-button.active {
    color: #344767; /* Mantenemos el color oscuro para el texto activo sin background */
    background-color: transparent !important; /* Asegura que no haya background cuando está activo */
    box-shadow: none !important; /* Elimina cualquier sombra no deseada */
    border: none !important; /* Elimina cualquier borde cuando está activo */
}

/* Estilo de la línea de subrayado para el botón activo */
.custom-tab-buttons .custom-button.active .underline-text {
    width: 80%; /* La línea siempre visible y al 80% de ancho cuando está activo */
    background-color: var(--bs-primary); /* La línea se mantiene en color primary */
}

/* Asegurar que el contenedor no genere scroll inesperado */
.d-flex.align-items-center.flex-wrap.overflow-auto {
    overflow: visible !important; /* Esto debería eliminar el scroll en el contenedor principal de los botones */
}

/* Estilos para el efecto de Headroom.js */
.headroom--unpinned {
    transform: translateY(-100%);
    transition: transform 0.3s ease-in-out;
}
.headroom--pinned {
    transform: translateY(0);
    transition: transform 0.3s ease-in-out;
}
</style>