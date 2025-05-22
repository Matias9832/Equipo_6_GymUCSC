@extends('layouts.app')

@section('title', 'Espacios')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Espacios'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Espacios - <span class="text-muted">{{ session('nombre_sucursal') }}</span></h6>
                    <a href="{{ route('espacios.create') }}" class="btn btn-primary btn-sm">Crear Nuevo Espacio</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($espacios as $espacio)
                                    <tr>
                                        <td class="text-sm ps-3">{{ $espacio->nombre_espacio }}</td>
                                        <td><span class="badge bg-secondary">{{ ucfirst($espacio->tipo_espacio) }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('espacios.edit', $espacio) }}" class="text-warning me-2" title="Editar">
                                                <i class="ni ni-ruler-pencil"></i>
                                            </a>
                                            <form action="{{ route('espacios.destroy', $espacio) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('¿Estás seguro de eliminar este espacio?')" title="Eliminar">
                                                    <i class="ni ni-fat-remove"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">No hay espacios disponibles.</td>
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
