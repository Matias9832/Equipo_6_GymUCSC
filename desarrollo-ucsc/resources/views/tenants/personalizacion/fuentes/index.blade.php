@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Fuentes')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Fuentes'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Fuentes Disponibles</h6>
                        <a href="{{ route('personalizacion.fuentes.create') }}" class="btn btn-primary btn-sm">
                            Agregar Fuente
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">

                        @foreach ($fuentes as $fuente)
                            @if ($fuente->url_fuente)
                                <link href="{{ $fuente->url_fuente }}" rel="stylesheet" />
                            @endif
                        @endforeach

                        @if($fuentes->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Nombre</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Familia CSS</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                Texto de ejemplo</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-2">
                                                URL</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fuentes as $fuente)
                                            <tr>
                                                <td class="mb-0 text-sm fw-bold ps-4">{{ $fuente->nombre_fuente }}</td>
                                                <td class="">{{ $fuente->familia_css }}</td>
                                                <td class="">
                                                    <span style="font-family: {{ $fuente->familia_css }};">
                                                        "Bienvenido a Ugym"
                                                    </span>
                                                </td>
                                                <td class="">
                                                    @if ($fuente->url_fuente)
                                                        <a href="{{ $fuente->url_fuente }}" target="_blank">Ver fuente</a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('personalizacion.fuentes.edit', $fuente) }}"
                                                        class="btn btn-sm btn-warning">Editar</a>
                                                    <form action="{{ route('personalizacion.fuentes.destroy', $fuente) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('¿Eliminar esta fuente?')">
                                                            Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $fuentes->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info m-3">No hay fuentes registradas aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection