@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Subdominios')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Subdominios'])

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Subdominios Activos</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#crearTenantModal">
                            Crear nuevo Tenant
                        </button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($tenants->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    ID</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Dominio</th>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tenants as $tenant)
                                                <tr>
                                                    <td><span class="text-xs font-weight-bold ps-3">{{ $tenant->id }}</span></td>
                                                    <td><span
                                                            class="text-xs ps-3">{{ $tenant->domains->first()->domain ?? 'Sin dominio' }}</span>
                                                    </td>
                                                    <td>
                                                        <a href="http://{{ $tenant->domains->first()->domain }}:8000"
                                                            target="_blank" class="btn btn-sm btn-secondary">
                                                            Visitar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">No hay tenants registrados aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('tenants.subdominios._modal')

@endsection