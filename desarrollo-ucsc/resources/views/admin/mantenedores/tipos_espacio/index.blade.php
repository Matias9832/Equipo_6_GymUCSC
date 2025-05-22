@extends('layouts.app')

@section('title', 'Tipos de Espacios')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Tipos de Espacios'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Listado de Tipos de Espacios</h6>
                    <a href="{{ route('tipos_espacio.create') }}" class="btn btn-primary btn-sm">Crear Nuevo Espacio</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tipos as $tipo)
                                    <tr>
                                        <td class="text-sm ps-4">{{ $tipo->nombre_tipo }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('tipos_espacio.edit', $tipo->id) }}" class="text-secondary font-weight-bold text-xs me-2" title="Editar">
                                                <i class="ni ni-ruler-pencil text-info"></i>
                                            </a>
                                            <form action="{{ route('tipos_espacio.destroy', $tipo->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este tipo de espacio?')" title="Eliminar">
                                                    <i class="ni ni-fat-remove"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">No hay Tipos de Espacios disponibles.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
