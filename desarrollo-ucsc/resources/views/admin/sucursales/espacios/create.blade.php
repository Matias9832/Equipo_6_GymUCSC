@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Espacio')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Espacio'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4 p-4">
                <h2 class="h4 mb-4">Crear Espacio</h2>

                <form action="{{ route('espacios.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_espacio" class="form-label">Nombre</label>
                        <input type="text" name="nombre_espacio" id="nombre_espacio" class="form-control" placeholder="Nombre del espacio" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_espacio" class="form-label">Tipo de espacio</label>
                        <select name="tipo_espacio" id="tipo_espacio" class="form-select" required>
                            <option value="">Seleccione un tipo</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre_tipo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la ubicación</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ej: Gimnasio en medio del Campus de San Andrés, La cancha más cercana a la puerta principal" rows="2"></textarea>
                    </div>

                    <input type="hidden" name="id_suc" value="{{ session('sucursal_activa') }}">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('espacios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Crear Espacio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
