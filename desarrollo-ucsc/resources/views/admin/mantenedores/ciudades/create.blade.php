@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Ciudad')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Ciudad'])

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('ciudades.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre_ciudad" class="form-label">Nombre de la Ciudad</label>
                        <input type="text" name="nombre_ciudad" id="nombre_ciudad" class="form-control" placeholder="Nombre de la ciudad" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_region" class="form-label">Región</label>
                        <select name="id_region" id="id_region" class="form-control" required>
                            <option value="" disabled selected>Seleccione una región</option>
                            @foreach($regiones as $region)
                                <option value="{{ $region->id_region }}">{{ $region->nombre_region }} - {{ $region->pais->nombre_pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Ciudad</button>
                    <a href="{{ route('ciudades.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
@endsection
