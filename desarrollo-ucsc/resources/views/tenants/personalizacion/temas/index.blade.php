@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Temas')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Temas'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Temas Disponibles</h6>
                        <a href="{{ route('personalizacion.temas.create') }}" class="btn btn-primary btn-sm">
                            Agregar Tema
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($temas->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-4">
                                                Nombre</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Fuente</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Colores</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($temas as $tema)
                                            <tr>
                                                <td class="mb-0 text-sm fw-bold ps-4">{{ $tema->nombre_tema }}</td>
                                                <td style="font-family: '{{ $tema->familia_css }}">
                                                    <small class="text-muted">{{ $tema->nombre_fuente }}</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-start gap-2 ps-3">
                                                        <span class="badge text-white"
                                                            style="background-color: {{ $tema->bs_primary }}; min-width: 70px;">Primary</span>
                                                        <span class="badge text-white"
                                                            style="background-color: {{ $tema->bs_success }}; min-width: 70px;">Success</span>
                                                        <span class="badge text-white"
                                                            style="background-color: {{ $tema->bs_danger }}; min-width: 70px;">Danger</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('personalizacion.temas.edit', $tema) }}"
                                                        class="text-secondary font-weight-bold text-xs me-2" style="margin-bottom: 0rem !important;"><i
                                                            class="fas fa-pen-to-square text-primary"></i></a>
                                                    <form action="{{ route('personalizacion.temas.destroy', $tema) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            style="margin-bottom: 0rem !important;"
                                                            onclick="return confirm('¿Eliminar este tema?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $temas->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info m-3">No hay temas registrados aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection