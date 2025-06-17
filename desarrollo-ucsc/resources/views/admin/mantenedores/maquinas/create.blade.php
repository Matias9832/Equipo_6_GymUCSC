@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Máquinas'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Registrar nueva máquina</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('maquinas.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_maq" class="form-label">Nombre</label>
                            <input type="text" name="nombre_maq" id="nombre_maq" class="form-control" placeholder="Nombre de la máquina" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado_maq" class="form-label">Estado</label>
                            <select name="estado_maq" id="estado_maq" class="form-select" required>
                                <option value="1">Disponible</option>
                                <option value="0">En mantenimiento</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('maquinas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
