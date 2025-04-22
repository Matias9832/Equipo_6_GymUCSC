@extends('layouts.app')
<!-- Esta es la barra de navegación del sidebar -->
@section('sidebar')
<div class="p-3">
    <h5 class="mb-4">Panel de Control</h5>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('welcome') }}" class="nav-link text-dark">
                <i class="bi bi-house-door me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="#" class="nav-link text-dark">
                <i class="bi bi-gear me-2"></i> Configuración
            </a>
        </li>
        <!-- Agrega más enlaces aquí -->
    </ul>
</div>
@endsection

@section('content')
    <h1 class="h3">Este es el panel de control</h1>
    <p>Bienvenido al panel de administración. Aquí puedes gestionar las configuraciones y recursos del sistema.</p>
@endsection