@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Permisos')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Permisos'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Permisos Registrados</h6>
                        <a href="{{ route('plan.permisos.create') }}" class="btn btn-primary btn-sm">
                            Agregar Permiso
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($permisos->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-4">
                                                Nombre del Permiso
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permisos as $permiso)
                                            <tr>
                                                <td class="mb-0 text-sm fw-bold ps-4">{{ $permiso->nombre_permiso }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $permisos->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info m-3">No hay permisos registrados aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
