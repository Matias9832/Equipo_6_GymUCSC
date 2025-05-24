@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Carreras'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">

                    <div class="card-header pb-0">
                        <h6 class="mb-0">Lista de Carreras</h6>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            UA
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre Carrera
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Cantidad de Estudiantes
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($carreras as $carrera)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1 ps-3">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $carrera->UA ?? '-' }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 ps-3"
                                                    title="{{ $carrera->nombre_carrera }}">
                                                    {{ $carrera->nombre_carrera }}
                                                </p>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-sm bg-gradient-info shadow text-white px-3 py-2"
                                                    style="font-size: 0.75rem; width: 55px;">
                                                    {{ $carrera->cantidad_estudiantes }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                No hay carreras registradas.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>

                            {{-- Paginación --}}
                            <div class="d-flex justify-content-center mt-3">
                                {{ $carreras->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection