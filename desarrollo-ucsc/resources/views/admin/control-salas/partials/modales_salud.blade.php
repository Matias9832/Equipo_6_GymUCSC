@foreach ($ingresos as $ingreso)
    @php $salud = $ingreso->usuario->salud; @endphp
    @if ($salud)
        <div class="modal fade" id="saludModal{{ $ingreso->id_ingreso }}" tabindex="-1" aria-labelledby="saludModalLabel{{ $ingreso->id_ingreso }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="saludModalLabel{{ $ingreso->id_ingreso }}">Información de Salud</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>¿Enfermo Crónico?:</strong> {{ $salud->enfermo_cronico ? 'Sí' : 'No' }}</p>
                        @if ($salud->enfermo_cronico)
                            <p><strong>Detalles:</strong>
                                {{ is_array($salud->cronicas) ? implode(', ', $salud->cronicas) : ($salud->cronicas ?? 'Sin detalles') }}
                            </p>
                        @endif

                        <p><strong>¿Alergias?:</strong> {{ $salud->alergias ? 'Sí' : 'No' }}</p>
                        @if ($salud->alergias)
                            <p><strong>Detalles de Alergias:</strong> {{ $salud->detalle_alergias ?? 'Sin detalles' }}</p>
                        @endif

                        <p><strong>¿Indicaciones Médicas?:</strong> {{ $salud->indicaciones_medicas ? 'Sí' : 'No' }}</p>
                        @if ($salud->indicaciones_medicas)
                            <p><strong>Detalles de Indicaciones:</strong> {{ $salud->detalle_indicaciones ?? 'Sin detalles' }}</p>
                        @endif

                        <p><strong>Otra Información:</strong> {{ $salud->informacion_salud ?? 'Ninguna' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach