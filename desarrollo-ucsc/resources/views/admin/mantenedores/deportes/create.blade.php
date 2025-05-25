@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Deporte')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Deporte'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h3">Crear Deporte</h1>
                        <form action="{{ route('deportes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre_deporte" class="form-label">Nombre</label>
                                <input type="text" name="nombre_deporte" id="nombre_deporte" class="form-control"
                                    placeholder="Nombre del deporte" required>
                            </div>
                            <div class="mb-3">
                                <label for="jugadores_por_equipo" class="form-label">Jugadores por Equipo</label>
                                <input type="number" name="jugadores_por_equipo" id="jugadores_por_equipo"
                                    class="form-control" placeholder="Número de jugadores por equipo">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="3"
                                    placeholder="Descripción del deporte"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear Deporte</button>
                            <a href="{{ route('deportes.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection