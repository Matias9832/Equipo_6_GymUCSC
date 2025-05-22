@extends('layouts.app')

@section('title', 'Editar Tipo de Espacio')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Tipo de Espacio'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tipos_espacio.update', $tipo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre_tipo" class="form-label">Nombre</label>
                            <input type="text" name="nombre_tipo" id="nombre_tipo" class="form-control" value="{{ $tipo->nombre_tipo }}" required>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <a href="{{ route('tipos_espacio.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
