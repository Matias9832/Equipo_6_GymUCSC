@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Salas')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Salas'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 shadow rounded-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Salas - <span class="text-muted">{{ session('nombre_sucursal') }}</span></h6>
                    <a href="{{ route('salas.create') }}" class="btn btn-primary btn-sm">Crear Nueva Sala</a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-3">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Aforo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Horario</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salas as $sala)
                                    <tr>
                                        <td class="text-sm ps-3">{{ $sala->nombre_sala }}</td>
                                        <td class="text-sm">{{ $sala->aforo_sala }}</td>
                                        <td class="text-sm">
                                            {{ \Carbon\Carbon::parse($sala->horario_apertura)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($sala->horario_cierre)->format('H:i') }}
                                        </td>
                                        <td class="text-sm text-center">
                                            <a href="{{ route('salas.edit', $sala) }}" class="text-warning me-2" title="Editar">
                                                <i class="ni ni-ruler-pencil"></i>
                                            </a>

                                            <form action="{{ route('salas.destroy', $sala) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('¿Estás seguro de eliminar esta sala?')" title="Eliminar">
                                                    <i class="ni ni-fat-remove"></i>
                                                </button>
                                            </form>

                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
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
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">No hay salas disponibles.</td>
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
