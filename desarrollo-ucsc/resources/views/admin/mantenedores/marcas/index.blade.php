@extends('layouts.app')

@section('title', 'Lista de Marcas')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Lista de Marcas'])

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3">Lista de Marcas</h1>
        <a href="{{ route('marcas.create') }}" class="btn btn-primary">Crear Marca</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nombre</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Logo</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Misión</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Visión</th>
                        <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($marcas as $marca)
                    <tr>
                        <td class="text-sm">{{ $marca->nombre_marca }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $marca->logo_marca) }}" alt="Logo" width="60" class="rounded">
                        </td>
                        <td class="text-sm">{{ Str::limit($marca->mision_marca, 50) }}</td>
                        <td class="text-sm">{{ Str::limit($marca->vision_marca, 50) }}</td>
                        <td class="text-center">
                            <a href="{{ route('marcas.edit', $marca->id_marca) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                            <form action="{{ route('marcas.destroy', $marca->id_marca) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta marca?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger p-1">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
