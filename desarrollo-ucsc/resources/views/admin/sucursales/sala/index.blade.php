@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Salas'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h5>Listado de Salas - <span class="text-muted">{{ session('nombre_sucursal') }}</span></h5>
                    <div>
                        <a href="{{ route('salas.create') }}" class="btn btn-primary btn-sm me-3">Registrar nueva sala</a>
                        @can('Datos Salas')
                            <a href="{{ route('datos-salas.index') }}" class="btn custom-excel-btn btn-sm"> Ver datos de Salas</a>
                        @endcan
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aforo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Horario</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salas as $sala)
                                    <tr>
                                        <td><span class="text-xs font-weight-bold ps-3">{{ $sala->nombre_sala }}</span></td>
                                        <td><span class="text-xs ps-3">{{ $sala->aforo_sala }}</span></td>
                                        <td>
                                            <span class="text-xs ps-3">
                                                {{ \Carbon\Carbon::parse($sala->horario_apertura)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($sala->horario_cierre)->format('H:i') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('salas.edit', $sala) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pen-to-square text-primary"></i>
                                            </a>

                                            <form action="{{ route('salas.destroy', $sala) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de eliminar esta sala?')" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>

                                            <!-- <div class="dropdown d-inline-block ms-2">
                                                <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Exportar Excel
                                                </button>
                                                <div class="dropdown-menu p-3 shadow rounded-3" style="min-width: 280px;">
                                                    <form action="{{ route('salas.exportar') }}" method="GET">
                                                        <input type="hidden" name="sala_id" value="{{ $sala->id_sala }}">

                                                        <div class="mb-2">
                                                            <label for="fecha" class="form-label">Fecha</label>
                                                            <input type="date" name="fecha" class="form-control" required>
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="tipo" class="form-label">Periodo</label>
                                                            <select name="tipo" class="form-select" required>
                                                                <option value="diario">Diario</option>
                                                                <option value="semanal">Semanal</option>
                                                                <option value="mensual">Mensual</option>
                                                            </select>
                                                        </div>

                                                        <button type="submit" class="btn btn-primary btn-sm w-100">Descargar</button>
                                                    </form>
                                                </div>
                                            </div> -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="text-center text-muted py-4">No hay salas disponibles.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $salas->links('pagination::bootstrap-4') }}
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>

<style>
    .custom-excel-btn {
        background-color: rgb(33, 115, 70) !important;
        color: #fff !important;
        border: none;
    }
</style>
@endsection