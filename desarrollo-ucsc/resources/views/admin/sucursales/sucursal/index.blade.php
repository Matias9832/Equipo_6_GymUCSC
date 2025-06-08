@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

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
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Dirección</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Comuna</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Región</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sucursales as $sucursal)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $sucursal->nombre_suc }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs ps-3">{{ $sucursal->direccion_suc }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-xs ps-3">{{ $sucursal->ciudad->nombre_ciudad ?? 'Sin comuna' }}</span>
                                            </td>
                                            <td>
                                                <span
                                                    class="text-xs ps-3">{{ $sucursal->ciudad->region->nombre_region ?? 'Sin región' }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('sucursales.edit', $sucursal->id_suc) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="fas fa-pen-to-square text-info"></i>
                                                </a>
                                                <form action="{{ route('sucursales.destroy', $sucursal->id_suc) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar esta sucursal?')"
                                                        title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="text-center text-muted py-4">
                                                    No hay sucursales registradas.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Paginación (si estás usando paginación en el controlador) --}}
                            <div class="d-flex justify-content-center mt-3">
                                {{ $sucursales->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection