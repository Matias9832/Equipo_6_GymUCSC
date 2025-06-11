@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Color')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Editar Color'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Editar Color</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('personalizacion.colores.update', $color->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre_color" class="form-label">Nombre del color</label>
                                <input type="text" name="nombre_color" id="nombre_color" class="form-control"
                                    value="{{ old('nombre_color', $color->nombre_color) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="codigo_hex" class="form-label">Selecciona un color</label>
                                <input type="color" name="codigo_hex" id="codigo_hex"
                                    class="form-control form-control-color w-100"
                                    value="{{ old('codigo_hex', $color->codigo_hex) }}" style="height: 45px;">
                                <div class="form-text" id="hexPreview">
                                    Código HEX: {{ old('codigo_hex', $color->codigo_hex) }}
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('personalizacion.colores.index') }}"
                                    class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar Color</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const colorInput = document.getElementById('codigo_hex');
        const hexPreview = document.getElementById('hexPreview');

        colorInput.addEventListener('input', function () {
            hexPreview.textContent = 'Código HEX: ' + this.value;
        });
    </script>
@endsection