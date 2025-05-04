
@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
    <h1 class="h3">Lista de Roles</h1>
    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Crear Rol</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $rol)
                <tr>
                    <td>{{ $rol->id_rol }}</td>
                    <td>{{ $rol->nombre_rol }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $rol) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('roles.destroy', $rol) }}" method="POST" class="d-inline">
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