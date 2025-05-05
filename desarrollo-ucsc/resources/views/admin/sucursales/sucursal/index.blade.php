@extends('layouts.admin')

@section('title', 'Lista de Sucursales')

@section('content')
    <h1 class="h3">Lista de Sucursales</h1>
    <a href="{{ route('sucursales.create') }}" class="btn btn-primary mb-3">Crear Sucursal</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Ciudad</th>
                <th>Región</th>
                <th>País</th>
                <th>Marca</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sucursales as $sucursal)
                <tr>
                    <td>{{ $sucursal->id_suc }}</td>
                    <td>{{ $sucursal->nombre_suc }}</td>
                    <td>{{ $sucursal->direccion_suc }}</td>
                    <td>{{ $sucursal->ciudad->nombre_ciudad }}</td>
                    <td>{{ $sucursal->ciudad->region->nombre_region }}</td>
                    <td>{{ $sucursal->ciudad->region->pais->nombre_pais }}</td>
                    <td>{{ $sucursal->marca->nombre_marca }}</td>
                    <td>
                        <a href="{{ route('sucursales.edit', $sucursal->id_suc) }}" class="btn btn-sm btn-warning" >Editar</a>
                        <form action="{{ route('sucursales.destroy', $sucursal->id_suc) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar esta sucursal?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
