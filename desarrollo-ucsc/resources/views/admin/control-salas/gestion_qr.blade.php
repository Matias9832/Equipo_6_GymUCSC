@extends('layouts.app')

@section('title', 'Gestor de Qr')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Gestor de QR'])

    <div class="container py-4">
        <h1 class="mb-4 text-center">Gestión de QR: {{ $sala->nombre_sala }}</h1>

        @if (isset($qrCode))
            <div class="row justify-content-center align-items-center mb-5">
                {{-- QR Code --}}
                <div class="col-md-6 mb-3">
                    <div class="card p-4 shadow-sm h-100 text-center">
                        <div style="overflow-x: auto;">
                            {!! $qrCode !!}
                        </div>
                    </div>
                </div>

                {{-- Datos de aforo --}}
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm p-4 mb-3 text-center">
                        <h5 class="text-muted mb-2">Aforo permitido</h5>
                        <h2 class="text-primary">{{ $aforoPermitido }}</h2>
                        <hr>
                        <h6 class="text-muted">Usuarios registrados</h6>
                        <h1 class="text-danger" id="aforo-actual">{{ $usuariosActivos }}</h1>
                    </div>

                    <div class="card shadow-sm p-4">
                        <div class="d-flex justify-content-around align-items-center gap-4 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user fs-4 {{ ($personasConEnfermedad ?? 0 ) > 0 ? 'text-primary' : 'text-success' }}"></i>
                                <div>
                                    <h4 class="fw-bold text-danger">{{ $estudiantes ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-solid fa-medal fs-4 text-success"></i>
                                <div>
                                    <h4 class="fw-bold text-danger">{{ $seleccionados ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="custom-tab-container mt-4">
                    {{-- TABS DE INGRESO Y SALIDA --}}
                    <div class="custom-tab-container mt-4">
                        <ul class="nav nav-tabs custom-tabs mb-4 w-100" id="registroTabs" role="tablist">
                            <li class="nav-item flex-fill text-center" role="presentation">
                                <button class="nav-link active border-primary text-primary bg-white w-100" 
                                        id="ingreso-tab"
                                        aria-controls="ingreso-tab-pane" 
                                        aria-selected="true"
                                        data-bs-toggle="tab" 
                                        data-bs-target="#ingreso" 
                                        type="button" 
                                        role="tab">
                                    Registrar Ingreso
                                </button>
                            </li>
                            <li class="nav-item flex-fill text-center" role="presentation">
                                <button class="nav-link  border-primary text-primary bg-white w-100" 
                                        id="salida-tab" 
                                        aria-controls="salida-tab-pane" 
                                        aria-selected="false"
                                        data-bs-toggle="tab" 
                                        data-bs-target="#salida" 
                                        type="button" 
                                        role="tab">
                                    Registrar Salida
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="registroTabsContent">
                        {{-- Formulario de ingreso manual con RUT y contraseña --}}
                        <div class="tab-pane fade show active" id="ingreso" role="tabpanel" aria-labelledby="ingreso-tab" tabindex="0">
                            
                                    <h5 class="mb-3 text-center">Registrar ingreso manual</h5>
                                    <form id="form-registro-manual" action="{{ route('registro.manual') }}" method="POST">

                                        @csrf
                                        <input type="hidden" name="id_sala" value="{{ $sala->id_sala }}">

                                        <div class="mb-3">
                                            <label for="rut" class="form-label">RUT</label>
                                            <input type="text" name="rut" id="rut" class="form-control" placeholder="Sin puntos ni dígito verificador" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary" >Registrar ingreso</button>
                                        </div>
                                    </form>

                                    <div id="respuestaIngreso" class="mt-3"></div>
                                
                        </div>

                        {{-- Formulario de salida manual con RUT --}}
                        <div class="tab-pane fade" id="salida" role="tabpanel" aria-labelledby="salida-tab" tabindex="0">
    
                                    <h5 class="mb-3 text-center">Registrar salida manual</h5>
                                    <form id="form-registro-manual" action="{{ route('salida.manual') }}" method="POST">

                                        @csrf
                                        <input type="hidden" name="id_sala" value="{{ $sala->id_sala }}">

                                        <div class="mb-3">
                                            <label for="rut" class="form-label">RUT</label>
                                            <input type="text" name="rut" id="rut" class="form-control" placeholder="Sin puntos ni dígito verificador" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Registrar salida</button>
                                        </div>
                                    </form>

                                    <div id="respuestaSalida" class="mt-3"></div>
                                
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
@endsection



@section('scripts')
<script>
    document.getElementById('form-registro-manual').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const idSala = document.getElementById('id_sala').value;

        fetch(`/admin/control-salas/registro-manual`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const mensajeDiv = document.getElementById('mensaje');
            mensajeDiv.textContent = data.message;
            mensajeDiv.style.color = data.success ? 'green' : 'red';

            if (data.success) {
                actualizarAforo(idSala);
                form.reset(); // Opcional: limpiar campos si fue exitoso
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    function actualizarAforo(idSala) {
        fetch(`/admin/control-salas/aforo/${idSala}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('aforo-actual').textContent = data.aforo;
            });
}
</script>

@endsection

