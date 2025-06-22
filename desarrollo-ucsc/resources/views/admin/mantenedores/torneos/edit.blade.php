@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Torneos'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Editar información del torneo</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('torneos.update', $torneo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
                            <input type="text" name="nombre_torneo" id="nombre_torneo" class="form-control" placeholder="Ej: Liga de basketball interfacultades" value="{{ $torneo->nombre_torneo }}" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="{{ route('torneos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>    
@endsection