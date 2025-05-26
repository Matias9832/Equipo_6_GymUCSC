@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Región')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Región'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('regiones.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_pais" class="form-label">País</label>
                            <select name="id_pais" id="id_pais" class="form-control" required>
                                <option value="">Seleccione un país</option>
                                @foreach($paises as $pais)
                                    <option value="{{ $pais->id_pais }}">{{ $pais->nombre_pais }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nombre_region" class="form-label">Nombre</label>
                            <input type="text" name="nombre_region" id="nombre_region" class="form-control" placeholder="Nombre de la región" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Región</button>
                        <a href="{{ route('regiones.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
