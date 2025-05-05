@extends('layouts.admin')

@section('title', 'Editar Rol del Administrador')

@section('content')
    <h1 class="h3">Editar Rol del Administrador</h1>
    <form action="{{ route('administradores.updateRol', $administrador->id_admin) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <select name="id_rol" id="id_rol" class="form-control" required>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id_rol }}" {{ $administrador->id_rol == $rol->id_rol ? 'selected' : '' }}>
                        {{ $rol->nombre_rol }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Rol</button>
        <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection