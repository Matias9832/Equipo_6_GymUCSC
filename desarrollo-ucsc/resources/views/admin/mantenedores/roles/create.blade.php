@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Roles'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3">Registrar nuevo rol</h1>

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del rol</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Ej: administrador, editor, alumno..." required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Permisos asignados</label>
                                <div class="border rounded p-3" style="max-height: 250px; overflow-y: auto;">
                                    @foreach ($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="permissions[]" value="{{ $permission->id }}"
                                                id="perm_{{ $permission->id }}">
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach

                                    @if($permissions->isEmpty())
                                        <p class="text-muted text-sm">No hay permisos definidos en el sistema.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
