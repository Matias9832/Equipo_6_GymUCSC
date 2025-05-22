@extends('layouts.app')

@section('title', 'Crear Tipo de Espacio')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Tipo de Espacio'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tipos_espacio.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_tipo" class="form-label">Nombre</label>
                            <input type="text" name="nombre_tipo" id="nombre_tipo" class="form-control" placeholder="Nombre del espacio" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Tipo de Espacio</button>
                        <a href="{{ route('tipos_espacio.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
