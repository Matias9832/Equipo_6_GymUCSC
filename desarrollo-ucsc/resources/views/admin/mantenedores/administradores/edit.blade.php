@extends('layouts.admin')

@section('title', 'Administradores')

@section('content')
    <h1 class="h3">Lista de Administradores</h1>
    <a href="{{ route('administradores.create') }}" class="btn btn-success mb-3">Crear Administrador</a> <!-- Botón verde restaurado -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
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
                    <td>{{ $administrador->rut_admin }}</td>
                    <td>{{ $administrador->nombre_admin }}</td>
                    <td>{{ $usuario->correo_usuario ?? 'N/A' }}</td>
                    <td>{{ $administrador->rol->nombre_rol ?? 'Sin Rol' }}</td> <!-- Mostrar el nombre del rol -->
                    <td>
                        <a href="{{ route('administradores.edit', $administrador->id_admin) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('administradores.destroy', $administrador->id_admin) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection