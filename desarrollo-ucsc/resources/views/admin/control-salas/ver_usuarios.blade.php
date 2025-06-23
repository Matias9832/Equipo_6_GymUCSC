@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Usuario Sala'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Usuarios Activos - {{ $sala->nombre_sala }}</h6>
                    <a href="{{ route('control-salas.seleccionar') }}" class="btn btn-secondary btn-sm">
                        ← Volver a Selección de Sala
                    </a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div id="tabla-usuarios-sala">
                        @include('admin.control-salas.partials.tabla_usuarios', ['ingresos' => $sala->ingresos])
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>

{{-- Modales de Salud --}}
<div id="modales-salud">
    @include('admin.control-salas.partials.modales_salud', ['ingresos' => $sala->ingresos])
</div>
@endsection

<!-- AGREGAR ESTE SCRIPT FUERA DE LA SECCIÓN -->
<script>
function actualizarTablaUsuarios() {
    $.ajax({
        url: "{{ route('admin.control-salas.ver_usuarios', ['id_sala' => $sala->id_sala]) }}",
        type: 'GET',
        dataType: 'json',
        headers: {'X-Requested-With': 'XMLHttpRequest'},
        success: function(res) {
            $('#tabla-usuarios-sala').html(res.tabla);
            $('#modales-salud').html(res.modales);
        }
    });
}
setInterval(actualizarTablaUsuarios, 5000);
</script>