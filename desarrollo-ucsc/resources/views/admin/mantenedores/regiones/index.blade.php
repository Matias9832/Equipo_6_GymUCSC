
@extends('layouts.admin')

@section('title', 'Lista de Regiones')

@section('content')
    <h1 class="h3">Lista de Regiones</h1>
    <a href="{{ route('regiones.create') }}" class="btn btn-primary mb-3">Crear Región</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>País</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($regiones as $region)
                <tr>
                    <td>{{ $region->id_region }}</td>
                    <td>{{ $region->nombre_region }}</td>
                    <td>{{ $region->pais->nombre_pais }}</td>
                    <td>
                        <a href="{{ route('regiones.edit', $region->id_region) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('regiones.destroy', $region->id_region) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar esta región?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection