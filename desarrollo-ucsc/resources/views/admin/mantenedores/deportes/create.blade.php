@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Deportes'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3">Registrar nuevo deporte</h1>
                        <form action="{{ route('deportes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre_deporte" class="form-label">Nombre</label>
                                <input type="text" name="nombre_deporte" id="nombre_deporte" class="form-control"
                                    placeholder="Nombre del deporte" required>
                            </div>
                            <div class="mb-3">
                                <label for="jugadores_por_equipo" class="form-label">Jugadores por equipo</label>
                                <input type="number" name="jugadores_por_equipo" id="jugadores_por_equipo"
                                    class="form-control" placeholder="Número de jugadores por equipo">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"
                                    placeholder="Descripción del deporte"></textarea>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                <a href="{{ route('deportes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection