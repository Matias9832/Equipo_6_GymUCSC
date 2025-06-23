@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Lista de Regiones')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Lista de Regiones'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Lista de Regiones</h6>
                    <a href="{{ route('regiones.create') }}" class="btn btn-primary btn-sm">Crear Región</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">País</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($regiones as $region)
                                    <tr>
                                        <td class="text-sm ps-4">{{ $region->nombre_region }}</td>
                                        <td class="text-sm ps-4">{{ $region->pais->nombre_pais }}</td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('regiones.edit', $region->id_region) }}" class="text-secondary font-weight-bold text-xs me-2" title="Editar">
                                                <i class="fas fa-pen-to-square text-primary"></i>
                                            </a>
                                            <form action="{{ route('regiones.destroy', $region->id_region) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar esta región?')" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($regiones->isEmpty())
                            <div class="text-center text-muted py-4">No hay regiones registradas.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
