@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Empresas')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Empresas'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Empresas Registradas</h6>
                        <a href="{{ route('empresas.create') }}" class="btn btn-primary btn-sm">
                            Agregar Empresa
                        </a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($empresas->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-4">
                                                Logo
                                            </th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-4">
                                                Nombre</th>
                                            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 ps-4">
                                                Dominio</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                                                Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($empresas as $empresa)
                                            @php
                                                $url = null;
                                                if ($empresa->dominio && $empresa->dominio !== 'Sin dominio asignado') {
                                                    $url = 'http://' . $empresa->dominio;
                                                } elseif ($empresa->subdominio && $empresa->subdominio !== 'Sin subdominio asignado') {
                                                    $url = 'http://' . $empresa->subdominio;
                                                }
                                            @endphp
                                            <tr>
                                                <td class="ps-4">
                                                    <img src="{{ url($empresa->logo) }}" alt="Logo" style="max-height: 34px;">
                                                </td>
                                                <td class="text-sm fw-bold ps-4">{{ $empresa->nombre }}</td>
                                                <td class="text-sm ps-4">
                                                    @if($empresa->dominio && $empresa->dominio !== 'Sin dominio asignado')
                                                        {{ $empresa->dominio }}
                                                    @elseif($empresa->subdominio && $empresa->subdominio !== 'Sin subdominio asignado')
                                                        {{ $empresa->subdominio }}
                                                    @else
                                                        <span class="text-muted">Sin subdominio asignado</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('empresas.edit', $empresa) }}"
                                                        class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                        title="Editar">
                                                        <i class="fas fa-pen-to-square text-primary"></i>
                                                    </a>
                                                    <form action="{{ route('empresas.destroy', $empresa) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            onclick="return confirm('¿Eliminar esta empresa?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    @if($url)
                                                        <a href="{{ $url }}:8000" class="ms-2" target="_blank" title="Visitar sitio">
                                                            <i class="fas fa-globe text-success"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $empresas->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info m-3">No hay empresas registradas aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection