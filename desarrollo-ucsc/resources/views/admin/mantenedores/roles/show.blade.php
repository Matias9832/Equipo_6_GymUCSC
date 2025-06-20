@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Roles'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detalle del rol</h5>
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-sm" style="margin-bottom: 0px !important;">Volver</a>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nombre del rol:</label>
                            <div>{{ $role->name }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Permisos asignados:</label>

                            @if($permissions->isEmpty())
                                <p class="text-muted">Este rol no tiene permisos asignados.</p>
                            @else
                                <ul class="list-group">
                                    @foreach($permissions as $permission)
                                        <li class="list-group-item text-sm">{{ $permission->name }}</li>
                                    @endforeach
                                </ul>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $permissions->links('pagination::bootstrap-4') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection