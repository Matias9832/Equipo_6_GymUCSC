@extends('layouts.admin')

@section('title', 'Lista de Alumnos')

@section('content')
    <h1>Listado de Espacios</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('espacios.create') }}" class="btn btn-primary mb-3">Crear Nuevo Espacio</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Sucursal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($espacios as $espacio)
                <tr>
                    <td>{{ $espacio->id }}</td>
                    <td>{{ $espacio->nombre_espacio }}</td>
                    <td>{{ ucfirst($espacio->tipo_espacio) }}</td>
                    <td>{{ $espacio->id_suc}}</td>
                    <td>
                        <a href="{{ route('espacios.edit', $espacio) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('espacios.destroy', $espacio) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este espacio?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay espacios disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection