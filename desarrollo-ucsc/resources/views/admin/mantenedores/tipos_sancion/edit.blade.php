@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Tipo de Sanción')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Tipo de Sanción'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tipos_sancion.update', $tipo) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nombre_tipo_sancion" class="form-label">Nombre</label>
                            <input type="text" name="nombre_tipo_sancion" id="nombre_tipo_sancion" class="form-control" value="{{ $tipo->nombre_tipo_sancion }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_tipo_sancion" class="form-label">Descripción</label>
                            <textarea name="descripcion_tipo_sancion" class="form-control" rows="3" required>{{ old('descripcion_tipo_sancion', $tipo->descripcion_tipo_sancion) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <a href="{{ route('tipos_sancion.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
