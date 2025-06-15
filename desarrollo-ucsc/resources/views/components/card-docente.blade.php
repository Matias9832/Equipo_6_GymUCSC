<div class="card card-profile">
    <div class="d-flex justify-content-end">
        <button type="button" class="btn-close btn-cerrar-card" aria-label="Cerrar" id="cerrar-perfil-docente" style="position: absolute; top: 10px; right: 10px;">&times;</button>
    </div>
    <img src="/img/gym/foto-gimnasio.jpeg" alt="Image placeholder" class="card-img-top">
    <div class="d-flex justify-content-center mt-n6">
        <div class="avatar position-relative mt-n6" style="width: 150px; height: 150px;">
            <img src="{{ url('img/perfiles/' . ($foto ?? 'default.png')) }}"
                class="rounded-circle img-fluid border border-2 border-white shadow"
                style="object-fit: cover; width: 100%; height: 100%;">
        </div>
    </div>
    <div class="card-body pt-0">
        <div class="text-center mt-3">
            <h5 class="mb-1">{{ $nombre }}</h5>
            <div class="h6 font-weight-300 text-muted">
                {{ $cargo }}
            </div>
            @if($sucursal)
                <div class="mt-2">
                    <i class="ni ni-pin-3 me-1"></i> {{ $sucursal }}
                </div>
            @endif
            @if($ubicacion)
                <div>
                    <i class="ni ni-map-big me-1"></i> {{ $ubicacion }}
                </div>
            @endif
            <div class="mt-2">
                <i class="ni ni-email-83 me-1"></i> {{ $correo }}
                @if($telefono)
                    <i class="ni ni-mobile-button me-1"></i> {{ $telefono }}
                @endif
            </div>
            @if($sobre_mi)
                <div class="mt-3 px-3">
                    <p class="text-sm text-dark fst-italic" style="white-space: pre-wrap;">"{{ $sobre_mi }}"</p>
                </div>
            @endif
            @if($talleres && count($talleres))
                <hr class="horizontal dark mt-3 mb-2">
                <h6 class="text-sm text-primary text-uppercase mb-2">Talleres a cargo</h6>
                <ul class="list-unstyled text-start ps-4">
                    @foreach($talleres as $taller)
                        <li class="mb-1">
                            <i class="ni ni-hat-3 text-success me-2"></i> {{ $taller }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
