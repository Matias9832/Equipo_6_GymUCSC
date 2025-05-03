@extends('layouts.admin')

@section('title', 'Lista de Salas')

@section('content')
    <h1>
        Listado de Salas:
        <span class="text-muted">{{ session('nombre_sucursal') }}</span>
    </h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('salas.create') }}" class="btn btn-primary mb-3">Crear Nueva Sala</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Aforo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salas as $sala)
                <tr>
                    <td>{{ $sala->id_sala }}</td>
                    <td>{{ $sala->nombre_sala }}</td>
                    <td>{{ $sala->aforo_sala }}</td>
                    <td>
                        <a href="{{ route('salas.edit', $sala) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('salas.destroy', $sala) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta sala?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay salas disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection