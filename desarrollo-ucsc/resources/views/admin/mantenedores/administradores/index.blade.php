@extends('layouts.admin')

@section('title', 'Administradores')

@section('content')
    <h1 class="h3">Lista de Administradores</h1>
    <a href="{{ route('administradores.create') }}" class="btn btn-primary mb-3">Crear Administrador</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Sucursal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($administradores as $administrador)
                @php
                    // Buscar el usuario relacionado con el administrador
                    $usuario = $usuarios->firstWhere('rut', $administrador->rut_admin);
                @endphp
                <tr>
                    <!-- RUT -->
                    <td>{{ $administrador->rut_admin }}</td>
                    <!-- Nombre -->
                    <td>{{ $administrador->nombre_admin }}</td>
                    <!-- Correo -->
                    <td>{{ $usuario->correo_usuario ?? 'N/A' }}</td>
                    <!-- Rol -->
                    <td>{{ $usuario ? $usuario->getRoleNames()->implode(', ') : 'Sin rol' }}</td>
                    <!-- Sucursal (falta) -->
                    <td>{{ $administrador->nombre_admin }}</td>
                    <!-- Acciones -->
                    <td>
                        <!-- Editar -->
                        <a href="{{ route('administradores.edit', $administrador) }}" class="btn btn-warning btn-sm">Editar</a>
                        <!-- Cambiar Sucursal -->
                        <a href="{{ route('administradores.edit', $administrador) }}" class="btn btn-warning btn-sm">Cambiar sucursal</a>
                        <!-- Eliminar -->
                        <form action="{{ route('administradores.destroy', $administrador) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar este administrador?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection