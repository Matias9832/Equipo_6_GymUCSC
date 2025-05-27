@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Mis Rutinas Personalizadas</h2>
            <div class="card shadow rounded-4 p-4" style="background: #fff;">
                @if($rutinas->isEmpty())
                    <div class="alert alert-info">No tienes rutinas asignadas.</div>
                @else
                    @foreach($rutinas as $rutina)
                        <div class="mb-4">
                            <h5 style="color:#D12421;">
                                {{ $rutina->nombre }}
                                <span class="text-muted" style="font-size:1rem;">
                                    &mdash; 
                                    @if($rutina->creador && $rutina->creador->alumno)
                                        {{ $rutina->creador->alumno->nombre_alumno }} {{ $rutina->creador->alumno->apellido_paterno }}
                                    @else
                                        {{ $rutina->creador_rut }}
                                    @endif
                                </span>
                            </h5>
                            <ul>
                                @foreach($rutina->ejercicios as $ejercicio)
                                    <li>
                                        <strong>{{ $ejercicio->nombre }}</strong>
                                        - Series: {{ $ejercicio->pivot->series }}
                                        - Repeticiones: {{ $ejercicio->pivot->repeticiones }}
                                    </li>
                                @endforeach
                            </ul>
                            <button class="btn btn-primary btn-sm mt-2 iniciar-rutina"
                                style="background:#D12421; border:none;"
                                data-rutina="{{ $rutina->id }}">
                                <i class="fa fa-play"></i> Realizar rutina
                            </button>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')

    <!-- Modal de rutina -->
    <div class="modal fade" id="visorRutinaModal" tabindex="-1" aria-labelledby="visorRutinaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="background:#fff;">
                <div class="modal-header" style="border-bottom:2px solid #D12421;">
                    <h5 class="modal-title" id="visorRutinaLabel" style="color:#D12421;">Rutina</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div id="visor-ejercicio" class="text-center">
                        <!-- Aquí se carga el ejercicio -->
                    </div>
                    <div id="visor-descanso" class="text-center mt-4" style="display:none;">
                        <h5 style="color:#646567;">¡Descanso!</h5>
                        <div id="timer" style="font-size:2rem; color:#D12421;"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background:#646567; border:none;">Salir</button>
                    <button type="button" class="btn btn-warning" id="btn-saltar-descanso" style="display:none; background:#ffc107; color:#646567; border:none;">Saltar descanso</button>
                    <button type="button" class="btn btn-primary" id="btn-continuar-ejercicio" style="background:#D12421; border:none;">Continuar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Carga ejercicios de la rutina seleccionada
    const rutinas = @json($rutinas->keyBy('id')->map->only(['ejercicios']));

    let ejerciciosActuales = [];
    let idxEjercicio = 0;
    let serieActual = 1;
    let descansoEnCurso = false;
    let timerInterval = null;
    let pausaEntreEjercicios = false;

    function mostrarEjercicio(idx, serie) {
        const ejercicio = ejerciciosActuales[idx];
        if (!ejercicio) return;

        // Imagen/gif si existe
        let imgHtml = '';
        if (ejercicio.imagen) {
            imgHtml = `<img src="/img/${ejercicio.imagen}" alt="Ejercicio" class="img-fluid mb-3" style="max-height:220px; border-radius:10px; border:2px solid #D12421;">`;
        } else {
            imgHtml = `<div class="mb-3 text-muted" style="font-size:1.2rem;">Sin imagen</div>`;
        }

        document.getElementById('visor-ejercicio').innerHTML = `
            <h4 style="color:#D12421;">${ejercicio.nombre}</h4>
            ${imgHtml}
            <div class="mb-2" style="color:#646567;">
                <span><b>Serie:</b> ${serie} de ${ejercicio.pivot.series}</span> &nbsp; 
                <span><b>Repeticiones:</b> ${ejercicio.pivot.repeticiones}</span>
            </div>
        `;
        document.getElementById('visor-ejercicio').style.display = '';
        document.getElementById('visor-descanso').style.display = 'none';
        document.getElementById('btn-continuar-ejercicio').innerText = 'Continuar';
        document.getElementById('btn-saltar-descanso').style.display = 'none';
        descansoEnCurso = false;
        pausaEntreEjercicios = false;
    }

    function mostrarDescanso(segundos) {
        document.getElementById('visor-ejercicio').style.display = 'none';
        document.getElementById('visor-descanso').style.display = '';
        let tiempo = segundos;
        document.getElementById('timer').innerText = tiempo + 's';
        document.getElementById('btn-continuar-ejercicio').disabled = true;
        document.getElementById('btn-saltar-descanso').style.display = '';
        descansoEnCurso = true;

        document.getElementById('btn-saltar-descanso').style.display = '';
        timerInterval = setInterval(() => {
            tiempo--;
            document.getElementById('timer').innerText = tiempo + 's';
            if (tiempo <= 0) {
                clearInterval(timerInterval);
                document.getElementById('btn-continuar-ejercicio').disabled = false;
                document.getElementById('btn-saltar-descanso').style.display = 'none';
                document.getElementById('timer').innerText = '¡Listo!';
            }
        }, 1000);
    }

    function cerrarModalRutina() {
        $('#visorRutinaModal').modal('hide');
        ejerciciosActuales = [];
        idxEjercicio = 0;
        serieActual = 1;
        descansoEnCurso = false;
        pausaEntreEjercicios = false;
        if (timerInterval) clearInterval(timerInterval);
        document.getElementById('btn-saltar-descanso').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Iniciar rutina
        document.querySelectorAll('.iniciar-rutina').forEach(btn => {
            btn.addEventListener('click', function() {
                const rutinaId = this.getAttribute('data-rutina');
                ejerciciosActuales = rutinas[rutinaId].ejercicios;
                idxEjercicio = 0;
                serieActual = 1;
                mostrarEjercicio(idxEjercicio, serieActual);
                document.getElementById('btn-continuar-ejercicio').disabled = false;
                $('#visorRutinaModal').modal('show');
            });
        });

        // Botón continuar
        document.getElementById('btn-continuar-ejercicio').addEventListener('click', function() {
            const ejercicio = ejerciciosActuales[idxEjercicio];
            const totalSeries = ejercicio.pivot.series;
            const descanso = ejercicio.pivot.descanso || 0;

            if (descansoEnCurso) {
                if (pausaEntreEjercicios) {
                    // Después del descanso entre ejercicios, mostrar el siguiente ejercicio
                    idxEjercicio++;
                    serieActual = 1;
                    pausaEntreEjercicios = false;
                    if (idxEjercicio < ejerciciosActuales.length) {
                        mostrarEjercicio(idxEjercicio, serieActual);
                    } else {
                        cerrarModalRutina();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Rutina completada!',
                            showConfirmButton: false,
                            timer: 1800,
                            background: '#fff',
                            color: '#646567'
                        });
                    }
                } else {
                    // Después del descanso entre series
                    serieActual++;
                    if (serieActual <= totalSeries) {
                        mostrarEjercicio(idxEjercicio, serieActual);
                    } else {
                        // Terminó el ejercicio, ahora toca descanso antes del siguiente ejercicio
                        if (descanso > 0) {
                            pausaEntreEjercicios = true;
                            mostrarDescanso(descanso);
                        } else {
                            idxEjercicio++;
                            serieActual = 1;
                            if (idxEjercicio < ejerciciosActuales.length) {
                                mostrarEjercicio(idxEjercicio, serieActual);
                            } else {
                                cerrarModalRutina();
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Rutina completada!',
                                    showConfirmButton: false,
                                    timer: 1800,
                                    background: '#fff',
                                    color: '#646567'
                                });
                            }
                        }
                    }
                }
            } else {
                // Al terminar una serie, si corresponde, mostrar descanso
                if (serieActual < totalSeries && descanso > 0) {
                    mostrarDescanso(descanso);
                } else if (serieActual === totalSeries) {
                    // Última serie del ejercicio, mostrar descanso antes de cambiar de ejercicio
                    if (descanso > 0) {
                        pausaEntreEjercicios = true;
                        mostrarDescanso(descanso);
                    } else {
                        idxEjercicio++;
                        serieActual = 1;
                        if (idxEjercicio < ejerciciosActuales.length) {
                            mostrarEjercicio(idxEjercicio, serieActual);
                        } else {
                            cerrarModalRutina();
                            Swal.fire({
                                icon: 'success',
                                title: '¡Rutina completada!',
                                showConfirmButton: false,
                                timer: 1800,
                                background: '#fff',
                                color: '#646567'
                            });
                        }
                    }
                } else {
                    // Avanzar a la siguiente serie
                    serieActual++;
                    mostrarEjercicio(idxEjercicio, serieActual);
                }
            }
        });

        // Botón saltar descanso
        document.getElementById('btn-saltar-descanso').addEventListener('click', function() {
            if (timerInterval) clearInterval(timerInterval);
            document.getElementById('btn-continuar-ejercicio').disabled = false;
            document.getElementById('btn-saltar-descanso').style.display = 'none';
            document.getElementById('timer').innerText = '¡Listo!';
        });

        // Cerrar modal: limpiar estado
        $('#visorRutinaModal').on('hidden.bs.modal', cerrarModalRutina);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush