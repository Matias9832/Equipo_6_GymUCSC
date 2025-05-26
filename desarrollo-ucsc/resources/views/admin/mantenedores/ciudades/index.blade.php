@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Ciudades'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Ciudades</h6>
                        <a href="{{ route('ciudades.create') }}" class="btn btn-primary btn-sm">Crear Ciudad</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Región</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            País</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ciudades as $ciudad)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $ciudad->nombre_ciudad }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $ciudad->region->nombre_region }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $ciudad->region->pais->nombre_pais }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('ciudades.edit', $ciudad->id_ciudad) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="ni ni-ruler-pencil text-info"></i>
                                                </a>
                                                <form action="{{ route('ciudades.destroy', $ciudad->id_ciudad) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar esta ciudad?')"
                                                        title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($ciudades->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay ciudades registradas.
                                </div>
                            @endif
                            <div class="d-flex justify-content-center mt-3">
                                {{ $ciudades->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection