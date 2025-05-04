
@extends('layouts.admin')

@section('title', 'Lista de Usuarios')

@section('content')
    <h1 class="h3">Lista de Usuarios</h1>
    <!-- Por ahora no crearemos administradores desde la tabla de usuarios -->
    <!-- <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Crear Usuario</a> -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>Correo</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id_usuario }}</td>
                    <td>{{ $usuario->rut }}</td>
                    <td>{{ $usuario->correo_usuario }}</td>
                    <td>{{ ucfirst($usuario->tipo_usuario) }}</td>
                    <td>
                        <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar este usario?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection