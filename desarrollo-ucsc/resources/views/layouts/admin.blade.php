@extends('layouts.app')
<!-- Esta es la barra de navegación del sidebar -->
@section('sidebar')
<div class="p-3">
    <h5 class="mb-4">Panel de Control</h5>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="welcome" class="nav-link text-dark">
                <i class="bi bi-house-door me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="alumnos" class="nav-link text-dark">
                <i class="bi bi-people me-2"></i> Alumnos
            </a>
        </li>
        <!-- Menú desplegable: Mantenedores Geográficos -->
        <li class="nav-item mb-2">
            <a class="nav-link text-dark d-flex align-items-center" data-bs-toggle="collapse" href="#mantenedoresGeograficos" role="button" aria-expanded="false" aria-controls="mantenedoresGeograficos">
                <i class="bi bi-geo-alt me-2"></i> Mantenedores Geográficos
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="mantenedoresGeograficos">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item mb-2">
                        <a href="{{ route('ciudades.index') }}" class="nav-link text-dark">
                            <i class="bi bi-building me-2"></i> Ciudades
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('regiones.index') }}" class="nav-link text-dark">
                            <i class="bi bi-map me-2"></i> Regiones
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('paises.index') }}" class="nav-link text-dark">
                            <i class="bi bi-globe me-2"></i> Países
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-gear me-2"></i> Configuración
            </a>
        </li>
    </ul>
</div>
@endsection

@section('content')
    <h1 class="h3">Este es el panel de control</h1>
    <p>Bienvenido al panel de administración. Aquí puedes gestionar las configuraciones y recursos del sistema.</p>
@endsection