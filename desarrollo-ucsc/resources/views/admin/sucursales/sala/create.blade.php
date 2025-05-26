@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Sala')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Sala'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4 p-4">
                <h6 class="mb-4">Crear Sala</h6>

                <form action="{{ route('salas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_sala" class="form-label">Nombre de la Sala</label>
                        <input type="text" name="nombre_sala" id="nombre_sala" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="aforo_sala" class="form-label">Aforo</label>
                        <input type="number" name="aforo_sala" id="aforo_sala" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Horario (Apertura - Cierre)</label>
                        <div class="d-flex gap-2">
                            <input type="time" name="horario_apertura" class="form-control" required>
                            <span class="align-self-center">-</span>
                            <input type="time" name="horario_cierre" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('salas.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>
@endsection
