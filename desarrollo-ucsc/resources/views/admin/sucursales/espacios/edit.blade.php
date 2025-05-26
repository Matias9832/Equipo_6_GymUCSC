@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Espacio')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Espacio'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow rounded-4 p-4">
                <h2 class="h4 mb-4">Editar Espacio</h2>

                <form action="{{ route('espacios.update', $espacio) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre_espacio" class="form-label">Nombre</label>
                        <input type="text" name="nombre_espacio" id="nombre_espacio" class="form-control" value="{{ old('nombre_espacio', $espacio->nombre_espacio) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_espacio" class="form-label">Tipo de espacio</label>
                        <select name="tipo_espacio" id="tipo_espacio" class="form-select" required>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->nombre_tipo }}" {{ $tipo->nombre_tipo == $espacio->tipo_espacio ? 'selected' : '' }}>
                                    {{ $tipo->nombre_tipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la ubicación</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="Ej: Segundo piso, ala norte">{{ old('descripcion', $espacio->descripcion) }}</textarea>
                    </div>
                    
                    <input type="hidden" name="id_suc" value="{{ session('sucursal_activa') }}">

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('espacios.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
