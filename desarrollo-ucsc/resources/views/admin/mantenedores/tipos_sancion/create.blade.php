@extends('layouts.app')

@section('title', 'Crear Tipo de Sanción')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Tipo de Sanción'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tipos_sancion.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_tipo_sancion" class="form-label">Nombre Sanción</label>
                            <input type="text" name="nombre_tipo_sancion" id="nombre_tipo_sancion" class="form-control" placeholder="Nombre de la Sanción" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion_tipo_sancion" class="form-label">Descripción</label>
                            <textarea name="descripcion_tipo_sancion" class="form-control" rows="3" required>{{ old('descripcion_tipo_sancion') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Tipo de Sanción</button>
                        <a href="{{ route('tipos_sancion.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
