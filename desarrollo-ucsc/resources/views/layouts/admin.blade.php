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
            <a href="{{ route('usuarios.index') }}" class="nav-link text-dark {{ Request::is('admin/usuarios') ? 'fw-bold' : '' }}">
                <i class="bi bi-person me-2"></i> Usuarios
            </a>
        </li>

        @role('Super Admin|Director') 
        <li class="nav-item mb-2">
            <a href="{{ route('sucursales.index') }}" class="nav-link text-dark {{ Request::is('admin/sucursales*') ? 'fw-bold' : '' }}">
                <i class="bi bi-shop me-2"></i> Sucursales
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('espacios.index') }}" class="nav-link text-dark {{ Request::is('admin/espacios*') ? 'fw-bold' : '' }}">
                <i class="bi bi-rocket-takeoff"></i> Espacios
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('salas.index') }}" class="nav-link text-dark {{ Request::is('admin/salas*') ? 'fw-bold' : '' }}">
                <i class="bi bi-rocket-takeoff"></i> Salas
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('deportes.index') }}" class="nav-link text-dark {{ Request::is('admin/deportes') ? 'fw-bold' : '' }}">
                <i class="bi bi-trophy me-2"></i> Deportes
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('equipos.index') }}" class="nav-link text-dark {{ Request::is('admin/equipos') ? 'fw-bold' : '' }}">
                <i class="bi bi-trophy me-2"></i> Equipos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('torneos.index') }}" class="nav-link text-dark {{ Request::is('admin/torneos') ? 'fw-bold' : '' }}">
                <i class="bi bi-trophy me-2"></i> Torneos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('maquinas.index') }}" class="nav-link text-dark {{ Request::is('admin/maquinas*') ? 'fw-bold' : '' }}">
                <i class="bi bi-gear me-2"></i> Máquinas
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
        @endrole
        <li class="nav-item mb-2">
            <a href="{{ route('control-salas.seleccionar') }}" class="nav-link text-dark {{ Request::is('control-salas/seleccionar') ? 'fw-bold' : '' }}">
                <i class="bi bi-people me-2"></i> Gestión de QR
            </a>
        </li>
        @role('Super Admin') 
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
        <li class="nav-item mb-2">
            <a href="{{ route('administradores.index') }}" class="nav-link text-dark {{ Request::is('admin/administradores*') ? 'fw-bold' : '' }}">
                <i class="bi bi-person-badge me-2"></i> Administradores
            </a>
        </li>
        @endrole
    </ul>
</div>
@endsection


@section('content')
    <h1 class="h3">Este es el panel de control</h1>
    <p>Bienvenido al panel de administración. Aquí puedes gestionar las configuraciones y recursos del sistema.</p>
    
@endsection

