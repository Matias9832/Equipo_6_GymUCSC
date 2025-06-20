@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Roles'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Editar información del rol</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del rol</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $role->name) }}"
                                {{ $role->name === 'superadmin' ? 'readonly' : '' }}
                                required>
                        </div>

                        <label class="form-label mb-2">Permisos asignados</label>
                        <div class="border rounded p-3 mb-4" style="max-height: 300px; overflow-y: auto;">
                            @foreach($permissions as $permission)
                                <div class="form-check">
                                    <input type="checkbox"
                                        class="form-check-input"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        id="perm_{{ $permission->id }}"
                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}
                                        {{ $role->name === 'superadmin' ? 'disabled' : '' }}
                                    >
                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach

                            @if($permissions->isEmpty())
                                <p class="text-muted text-sm">No hay permisos definidos.</p>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            @if($role->name !== 'superadmin')
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            @endif
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
