@extends('layouts.app')

@section('title', 'Creación de Tenants')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow border-0">
                    <div
                        class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="text-white mb-0">Subdominios Activos</h4>
                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                            data-bs-target="#crearTenantModal">+ Crear nuevo Tenant</a>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($tenants->count())
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="ps-1" scope="col">ID del Tenant</th>
                                            <th class="ps-1" scope="col">Dominio</th>
                                            <th class="ps-1" scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tenants as $tenant)
                                            <tr>
                                                <td>{{ $tenant->id }}</td>
                                                <td>{{ $tenant->domains->first()->domain ?? 'Sin dominio' }}</td>
                                                <td>
                                                    @if ($tenant->domains->first())
                                                        <a href="http://{{ $tenant->domains->first()->domain }}:8000" target="_blank"
                                                            class="btn btn-sm btn-primary" style="margin_bottom: 0px; !important;">
                                                            Visitar
                                                        </a>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                No hay tenants registrados aún.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Tenant -->
    <div class="modal fade" id="crearTenantModal" tabindex="-1" aria-labelledby="crearTenantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearTenantModalLabel">Crear Nuevo Tenant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="subdominio">Subdominio</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="subdominio" name="subdominio"
                                    placeholder="ej: deportes1" required>
                                <span class="input-group-text">.ugym.local</span>
                            </div>
                            <small class="form-text text-muted">Este será el dominio completo:
                                <strong>subdominio.ugym.local</strong></small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Crear</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection