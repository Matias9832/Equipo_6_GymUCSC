@php
    use Carbon\Carbon;
@endphp
@if (empty($ingresos) || $ingresos->isEmpty())
    <div class="text-center py-4 text-muted">
        No hay usuarios activos en esta sala.
    </div>
@else
    <div class="table-responsive p-3">
        <table class="table align-items-center mb-0 table-bordered">
            <thead class="bg-light">
                <tr class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    <th></th>
                    <th>Rut</th>
                    <th>Nombre</th>
                    <th>Hora Ingreso</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresos as $ingreso)
                    @php
                        $usuario = $ingreso->usuario;
                        $tieneEnfermedad = $usuario && $usuario->salud && $usuario->salud->enfermo_cronico == 1;
                        $icono = $usuario->tipo_usuario === 'seleccionado' ? 'fa-medal' : 'fa-user';

                        $horaActual = Carbon::now();
                        $horaSalidaEstimada = $ingreso->hora_salida_estimada ?? null;
                        $marcarRojo = false;
                        if ($horaSalidaEstimada) {
                            $fechaHoy = $horaActual->format('Y-m-d');
                            $horaSalidaEstimadaFull = Carbon::parse($fechaHoy . ' ' . $horaSalidaEstimada);
                            if ($horaActual->greaterThanOrEqualTo($horaSalidaEstimadaFull)) {
                                $marcarRojo = true;
                            }
                        }
                    @endphp
                    <tr @if($marcarRojo) style="background-color:#ffcccc !important;" @endif>
                        <td class="text-center">
                            <button type="button" class="btn p-0 border-0 bg-transparent"
                                data-bs-toggle="modal" data-bs-target="#saludModal{{ $ingreso->id_ingreso }}">
                                <i class="fas {{ $icono }} fs-5 {{ $tieneEnfermedad ? 'text-primary' : 'text-success' }}"></i>
                            </button>
                        </td>
                        <td class="text-sm text-center">{{ $usuario->rut }}</td>
                        <td class="text-sm">
                            @if ($usuario->alumno)
                                {{ $usuario->alumno->nombre_alumno }} {{ $usuario->alumno->apellido_paterno }} {{ $usuario->alumno->apellido_materno }}
                            @else
                                {{ $usuario->administrador->nombre_admin }}
                            @endif
                        </td>
                        <td class="text-sm text-center">{{ $ingreso->hora_ingreso }}</td>
                        <td class="text-center">
                            <form action="{{ route('admin.control-salas.sacar_usuario') }}" method="POST"
                                onsubmit="return confirm('¿Seguro que deseas sacar a este usuario?')">
                                @csrf
                                <input type="hidden" name="id_ingreso" value="{{ $ingreso->id_ingreso }}">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Sacar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif