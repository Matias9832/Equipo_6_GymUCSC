@extends('layouts.admin')

@section('title', 'Lista de Máquinas')

@section('content')
    <h1 class="h3">Lista de Máquinas</h1>
    <a href="{{ route('maquinas.create') }}" class="btn btn-primary mb-3">Crear Máquina</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maquinas as $maquina)
                <tr>
                    <td>{{ $maquina->id_maq }}</td>
                    <td>{{ $maquina->nombre_maq }}</td>
                    <td>{{ $maquina->estado_maq ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('maquinas.edit', $maquina->id_maq) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('maquinas.destroy', $maquina->id_maq) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar esta máquina?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection