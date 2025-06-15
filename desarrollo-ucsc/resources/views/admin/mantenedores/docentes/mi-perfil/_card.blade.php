<div class="card shadow-lg">
    <div class="card-header pb-0">
        <h5 class="mb-0">{{ $administrador->nombre_admin }}</h5>
    </div>
    <div class="card-body">
        <p><strong>RUT:</strong> {{ $administrador->rut_admin }}</p>
        <p><strong>Cargo:</strong> {{ $administrador->descripcion_cargo ?? 'No definido' }}</p>
        <p><strong>Número de contacto:</strong> {{ $administrador->numero_contacto ?? 'No registrado' }}</p>
        <p><strong>Sobre mí:</strong> {{ $administrador->sobre_mi ?? 'No hay descripción personal' }}</p>
        <hr>
        <h6>Talleres asociados:</h6>
        <ul>
            @forelse($administrador->talleres as $taller)
                <li>{{ $taller->nombre_taller }}</li>
            @empty
                <li>No tiene talleres asignados.</li>
            @endforelse
        </ul>
    </div>
</div>

