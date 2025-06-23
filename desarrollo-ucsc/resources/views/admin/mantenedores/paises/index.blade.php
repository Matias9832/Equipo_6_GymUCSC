@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Lista de Países')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Lista de Países'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Lista de Países</h6>
                    <a href="{{ route('paises.create') }}" class="btn btn-primary btn-sm">Crear País</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bandera</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paises as $pais)
                                    <tr>
                                        <td class="text-sm ps-4">{{ $pais->nombre_pais }}</td>
                                        <td class="ps-4">
                                            <img src="{{ $pais->bandera_pais }}" alt="Bandera de {{ $pais->nombre_pais }}" style="width: 50px; height: auto;" class="rounded">
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('paises.edit', $pais->id_pais) }}" class="text-info font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pen-to-square  text-primary"></i>
                                            </a>
                                            <form action="{{ route('paises.destroy', $pais->id_pais) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este país?')" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($paises->isEmpty())
                            <div class="text-center text-muted py-4">No hay países registrados.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
