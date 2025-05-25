@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Espacios')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Espacios'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Listado de Espacios - <span class="text-muted">{{ session('nombre_sucursal') }}</span></h6>
                        <a href="{{ route('espacios.create') }}" class="btn btn-primary btn-sm">Crear Nuevo Espacio</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                            Tipo
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($espacios as $espacio)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $espacio->nombre_espacio }}</span>
                                            </td>
                                            <td class="ps-3">
                                                <span class="badge bg-gradient-success text-xs" style="min-width: 200px;">{{ ucfirst($espacio->tipo_espacio) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('espacios.edit', $espacio->id_espacio) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="ni ni-ruler-pencil text-info"></i>
                                                </a>
                                                <form action="{{ route('espacios.destroy', $espacio->id_espacio) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este espacio?')"
                                                        title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">
                                                <div class="text-center text-muted py-4">
                                                    No hay espacios disponibles.
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Paginación (si aplica) --}}
                            <div class="d-flex justify-content-center mt-3">
                                {{ $espacios->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
