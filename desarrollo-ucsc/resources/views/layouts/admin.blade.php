@extends('layouts.app')
<!-- Esta es la barra de navegación del sidebar -->
@section('sidebar')
<div class="p-3">
    <h5 class="mb-4">Panel de Control</h5>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('admin.index') }}" class="nav-link text-dark {{ Request::is('admin') ? 'fw-bold' : '' }}">
                <i class="bi bi-house-door me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('alumnos.index') }}" class="nav-link text-dark {{ Request::is('admin/alumnos*') ? 'fw-bold' : '' }}">
                <i class="bi bi-people me-2"></i> Alumnos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('sucursales.index') }}" class="nav-link text-dark {{ Request::is('admin/sucursales/sucursal*') ? 'fw-bold' : '' }}">
                <i class="bi bi-people me-2"></i> Sucursales
            </a>
        </li>


        <!-- Configuraciones para editar página web -->
        <li class="nav-item mb-2">
            <a href="{{ route('deportes.index') }}" class="nav-link text-dark {{ Request::is('admin/deportes') ? 'fw-bold' : '' }}">
                <i class="bi bi-trophy me-2"></i> Deportes
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('maquinas.index') }}" class="nav-link text-dark {{ Request::is('admin/maquinas*') ? 'fw-bold' : '' }}">
                <i class="bi bi-gear me-2"></i> Máquinas
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('espacios.index') }}" class="nav-link text-dark {{ Request::is('admin/espacios*') ? 'fw-bold' : '' }}">
                <i class="bi bi-rocket-takeoff"></i> Espacios
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('tipos_espacio.index') }}" class="nav-link text-dark {{ Request::is('admin/tipos_espacio*') ? 'fw-bold' : '' }}">
                <i class="bi bi-rocket-takeoff"></i> Tipos de Espacios
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('tipos_sancion.index') }}" class="nav-link text-dark {{ Request::is('admin/tipos_sancion*') ? 'fw-bold' : '' }}">
                <i class="bi bi-hourglass-split"></i> Tipos de Sanción
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('control_salas.gestion_qr') }}" class="nav-link text-dark {{ Request::is('admin/control_salas/gestion-qr') ? 'fw-bold' : '' }}">
                <i class="bi bi-people me-2"></i> Gestión de QR
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
                        <a href="{{ route('ciudades.index') }}" class="nav-link text-dark {{ Request::is('admin/ciudades') ? 'fw-bold' : '' }} ">
                            <i class="bi bi-building me-2"></i> Ciudades
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('regiones.index') }}" class="nav-link text-dark {{ Request::is('admin/regiones') ? 'fw-bold' : '' }}">
                            <i class="bi bi-map me-2"></i> Regiones
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('paises.index') }}" class="nav-link text-dark {{ Request::is('admin/paises') ? 'fw-bold' : '' }}">
                            <i class="bi bi-globe me-2"></i> Países
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        
    </ul>
</div>
@endsection

@section('content')
    <h1 class="h3">Este es el panel de control</h1>
    <p>Bienvenido al panel de administración. Aquí puedes gestionar las configuraciones y recursos del sistema.</p>
@endsection