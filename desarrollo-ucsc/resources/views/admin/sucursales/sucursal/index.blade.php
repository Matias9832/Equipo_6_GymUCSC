@extends('layouts.app')

@section('title', 'Sucursales')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sucursales'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Listado de Sucursales</h6>
                    <a href="{{ route('sucursales.create') }}" class="btn btn-primary btn-sm">Crear Sucursal</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dirección</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Comuna</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Región</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sucursales as $sucursal)
                                    <tr>
                                        <td class="text-sm ps-3">{{ $sucursal->nombre_suc }}</td>
                                        <td class="text-sm">{{ $sucursal->direccion_suc }}</td>
                                        <td class="text-sm">{{ $sucursal->comuna->nombre_comuna ?? 'Sin comuna' }}</td>
                                        <td class="text-sm">{{ $sucursal->comuna->region->nombre_region ?? 'Sin región' }}</td>
                                        <td class="text-center">
                                                <a href="{{ route('sucursales.edit', $sucursal->id_suc) }}" class="text-warning me-2" title="Editar">
                                                    <i class="ni ni-ruler-pencil"></i>
                                                </a>
                                                <form action="{{ route('sucursales.destroy', $sucursal->id_suc) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-link text-danger p-0" onclick="return confirm('¿Estás seguro de que quieres eliminar esta sucursal?')" title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">No hay sucursales registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
