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
                                        @php
                                            $grupoActual = null;
                                        @endphp
                                        @foreach ($permisos as $permiso)
                                            @if ($permiso->subpermisos !== $grupoActual)
                                                <tr class="bg-light">
                                                    <td colspan="2"
                                                        class="fw-bold ps-4 py-2 d-flex justify-content-between align-items-center">
                                                        {{ $permiso->subpermisos }}
                                                        <form
                                                            action="{{ route('plan.permisos.destroySubgrupo', $permiso->subpermisos) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('¿Estás seguro de eliminar todos los permisos de este grupo?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger px-2 py-0"
                                                                style="margin-bottom: 0px !important;" title="Eliminar grupo">
                                                                &times;
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php $grupoActual = $permiso->subpermisos; @endphp
                                            @endif
                                            <tr>
                                                <td class="mb-0 text-sm fw-normal ps-4  d-flex justify-content-between align-items-center">{{ $permiso->nombre_permiso }}
                                                    <form action="{{ route('plan.permisos.destroy', $permiso) }}" method="POST"
                                                        onsubmit="return confirm('¿Eliminar este permiso?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0 m-0"
                                                            title="Eliminar permiso"
                                                            style="font-weight: bold; font-size: 1.2rem; line-height: 1;">
                                                            &times;
                                                        </button>
                                                    </form>
                                                </td>
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