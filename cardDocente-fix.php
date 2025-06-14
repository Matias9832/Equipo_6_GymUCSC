 <!-- Tarjeta lateral -->
            <div class="col-md-4">
                <div class="card card-profile">
                    <!-- Imagen de cabecera -->
                    <img src="/img/gym/foto-gimnasio.jpeg" alt="Image placeholder" class="card-img-top">

                    <!-- Foto de perfil superpuesta -->
                      <div class="d-flex justify-content-center mt-n6">
                        <div class="avatar position-relative mt-n6" style="width: 150px; height: 150px;">
                            <img src="{{ url('img/perfiles/' . $administrador->foto_perfil) }}"
                                class="rounded-circle img-fluid border border-2 border-white shadow"
                                style="object-fit: cover; width: 100%; height: 100%;">
                        </div>
                        <!-- Cuerpo de la tarjeta -->
                    <div class="card-body pt-0">
                        <div class="text-center mt-3">
                            <h5 class="mb-1">{{ $administrador->nombre_admin }}</h5>
                            <div class="h6 font-weight-300 text-muted">
                                {{ $administrador->descripcion_cargo ?? $rol }}
                            </div>

                            @if($sucursal)
                                <div class="mt-2">
                                    <i class="ni ni-pin-3 me-1"></i> {{ $sucursal->nombre_suc }}
                                </div>
                            @endif

                            @if($administrador->descripcion_ubicacion)
                                <div>
                                    <i class="ni ni-map-big me-1"></i> {{ $administrador->descripcion_ubicacion }}
                                </div>
                            @endif
                             <div class="mt-2">
                                <i class="ni ni-email-83 me-1"></i> {{ $admin->correo_usuario }}
                                @if($administrador->numero_contacto)
                                    <i class="ni ni-mobile-button me-1"></i> {{ $administrador->numero_contacto }}
                                @endif
                            </div>
                            
                            @if($administrador->sobre_mi)
                                <div class="mt-3 px-3">
                                    <p class="text-sm text-dark fst-italic" style="white-space: pre-wrap;">"{{ $administrador->sobre_mi }}"</p>
                                </div>
                            @endif

                            @if($talleres && $talleres->count())
                                <hr class="horizontal dark mt-3 mb-2">
                                <h6 class="text-sm text-primary text-uppercase mb-2">Talleres a cargo</h6>
                                <ul class="list-unstyled text-start ps-4">
                                    @foreach($talleres as $taller)
                                        <li class="mb-1">
                                            <i class="ni ni-hat-3 text-success me-2"></i> {{ $taller->nombre_taller }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
    <script>
    document.getElementById('input_foto').addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.size > 2 * 1024 * 1024) { // 2MB en bytes
                alert('La imagen supera el límite de 2 MB.');
                this.value = ''; // limpia el input
            } else {
                document.getElementById('form-foto').submit();
            }
        });
    </script>
    <style>
        .readonly-input {
            cursor: default !important;
            pointer-events: none;
        }
        </style>
@endsection    
