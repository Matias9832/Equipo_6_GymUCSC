@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Subdominios')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Subdominios'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6 class="text-dark">Subdominios Activos</h6>
                        <a class="btn btn-primary btn-sm" href="{{ route('tenants.create') }}">Crear nuevo Tenant</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($tenants->count())
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Logo</th>
                                                <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                            Empresa</th> -->
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Dominio</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                                    Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tenants as $tenant)
                                                <tr>
                                                    <td class="ps-4">
                                                        @if ($tenant->empresa && $tenant->empresa->logo)
                                                            <img src="{{ url($tenant->empresa->logo) }}" alt="Logo"
                                                                style="max-height: 34px;">
                                                        @else
                                                            —
                                                        @endif
                                                    </td>
                                                    <!-- <td class="text-sm fw-bold">
                                                                    {{ $tenant->empresa->nombre ?? 'Empresa no asignada' }}
                                                                </td> -->
                                                    <td class="text-sm ps-4">
                                                        {{ $tenant->domains->first()->domain ?? 'Sin dominio asignado' }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($tenant->domains->first())
                                                            <a href="http://{{ $tenant->domains->first()->domain }}"
                                                                target="_blank" class="btn-sm btn-primary">
                                                                <i class="fas fa-arrow-up-right-from-square me-1"></i>
                                                                Ir
                                                            </a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info m-3">No hay tenants registrados aún.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection