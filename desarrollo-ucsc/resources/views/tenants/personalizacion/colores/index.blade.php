@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Colores')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Colores'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Colores Disponibles</h6>
                        <a href="{{ route('personalizacion.colores.create') }}" class="btn btn-primary btn-sm">
                            Agregar Color
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($colore->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Nombre</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Color</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($colore as $color)
                                            <tr>
                                                <td class="mb-0 text-sm fw-bold ps-4">{{ $color->nombre_color }}</td>
                                                <td class="">
                                                    <span class="badge"
                                                        style="background-color: {{ $color->codigo_hex }}; min-width:150px !important;">
                                                        {{ $color->codigo_hex }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('personalizacion.colores.edit', $color->id) }}"
                                                        class="text-secondary font-weight-bold text-xs me-2" style="margin-bottom: 0rem !important;"><i
                                                            class="fas fa-pen-to-square text-primary"></i></a>
                                                    <form action="{{ route('personalizacion.colores.destroy', $color) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            style="margin-bottom: 0rem !important;"
                                                            onclick="return confirm('¿Eliminar este color?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $colore->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info m-3">No hay colores registrados aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection