@extends('layouts.app')

@section('title', 'Lista de Usuarios')

@section('content')
    <h1 class="h3">Lista de Usuarios</h1>

    @can('Crear Usuarios')
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Crear Usuario</a> 
    @endcan

    <table class="table table-striped">
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol / Tipo de usuario</th>
                @role('Super Admin|Director|Coordinador')
                    <th>Acciones</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                @php
                    $nombre = 'Sin nombre';
                    $rolOTipo = '';

                    if ($usuario->tipo_usuario === 'admin') {
                        $admin = \App\Models\Administrador::where('rut_admin', $usuario->rut)->first();
                        $nombre = $admin ? $admin->nombre_admin : 'Sin nombre';
                        $rolOTipo = $usuario->getRoleNames()->implode(', ') ?: 'Sin rol';
                    } else {
                        $alumno = \App\Models\Alumno::where('rut_alumno', $usuario->rut)->first();
                        $nombre = $alumno 
                            ? $alumno->nombre_alumno . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno 
                            : 'Sin nombre';
                        $rolOTipo = $usuario->tipo_usuario === 'estudiante' ? 'Estudiante' : 'Seleccionado';
                    }
                @endphp
                <tr>
                    <td>{{ $usuario->rut }}</td>
                    <td>{{ $nombre }}</td>
                    <td>{{ $usuario->correo_usuario }}</td>
                    <td>{{ $rolOTipo }}</td>
                    @role('Super Admin|Director|Coordinador')
                        <td>
                            @can('Editar Usuarios')
                                <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-sm btn-warning">Editar</a>
                            @endcan

                            @can('Eliminar Usuarios')
                                <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </td>
                    @endrole
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
