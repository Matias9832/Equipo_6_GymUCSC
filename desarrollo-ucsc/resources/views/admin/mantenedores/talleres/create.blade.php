@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Taller'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Crear Taller</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('talleres.store') }}" method="POST">
                            @csrf
                            <div class="mb-3 form-check">
                                <input type="hidden" name="activo_taller" value="0">
                                <input type="checkbox" name="activo_taller" id="activo_taller" class="form-check-input"
                                    value="1" {{ old('activo_taller', true) ? 'checked' : '' }}>
                                <label for="activo_taller" class="form-check-label">Taller activo</label>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_taller" class="form-label">Nombre Taller</label>
                                <input type="text" name="nombre_taller" id="nombre_taller" class="form-control"
                                    value="{{ old('nombre_taller') }}" required maxlength="100">
                                @error('nombre_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion_taller" class="form-label">Descripción</label>
                                <textarea name="descripcion_taller" id="descripcion_taller" class="form-control" rows="3"
                                    required>{{ old('descripcion_taller') }}</textarea>
                                @error('descripcion_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cupos_taller" class="form-label">Cupos</label>
                                <input type="number" name="cupos_taller" id="cupos_taller" class="form-control"
                                    value="{{ old('cupos_taller') }}" required min="1">
                                @error('cupos_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_admin" class="form-label">Profesor asignado</label>
                                <select name="id_admin" id="id_admin" class="form-select">
                                    <option value="">-- Sin asignar --</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id_admin }}" {{ old('id_admin') == $admin->id_admin ? 'selected' : '' }}>
                                            {{ $admin->nombre_admin }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_admin') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            

                            <hr>
                            <h6>Horarios</h6>

                            @php
                                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            @endphp

                            <div id="horarios-container">
                                <div class="row mb-2 horario-item">
                                    <div class="col-md-3">
                                        <select name="horarios[0][dia]" class="form-select" required>
                                            <option value="">-- Día --</option>
                                            @foreach($diasSemana as $dia)
                                                <option value="{{ $dia }}">{{ $dia }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="horarios[0][hora_inicio]" class="form-control" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="horarios[0][hora_termino]" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-horario d-none">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary btn-sm mt-2" id="agregar-horario">+ Añadir Horario</button>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary ">Crear</button>
                                <a href="{{ route('talleres.index') }}" class="btn btn-link ">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let index = 1;

        document.getElementById('agregar-horario').addEventListener('click', function () {
            const container = document.getElementById('horarios-container');
            const original = container.querySelector('.horario-item');
            const clone = original.cloneNode(true);

            clone.querySelectorAll('select, input').forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
                input.value = '';
            });

            clone.querySelector('.remove-horario').classList.remove('d-none');
            clone.querySelector('.remove-horario').addEventListener('click', function () {
                clone.remove();
            });

            container.appendChild(clone);
            index++;
        });
    });
    </script>
    @endpush
@endsection