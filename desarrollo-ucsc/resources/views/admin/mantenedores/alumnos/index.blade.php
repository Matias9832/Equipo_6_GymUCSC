@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Alumnos'])
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-0">Lista de Alumnos</h6>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <form action="{{ route('alumnos.import') }}" method="POST" enctype="multipart/form-data"
                                    class="d-flex align-items-center gap-2">
                                    @csrf
                                    <div>
                                        <input type="file" name="file" id="file"
                                            class="btn form-control form-control-sm @error('file') is-invalid @enderror">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Importar</button>
                                </form>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('alumnos.index') }}" id="filtroForm" class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="ocultar_inactivos"
                                    id="ocultarInactivos" {{ request('ocultar_inactivos') ? 'checked' : '' }}
                                    onchange="document.getElementById('filtroForm').submit();">
                                <label class="form-check-label" for="ocultarInactivos">
                                    {{ request('ocultar_inactivos') ? 'Ocultar alumnos inactivos' : 'Ocultar alumnos inactivos' }}
                                </label>
                            </div>
                        </form>
                        @if(session('warning'))
                            <div class="alert alert-warning">
                                <strong>{{ session('warning') }}</strong>
                                @if(session('import_errors_missing_rut'))
                                    <h5>Errores por RUT faltante:</h5>
                                    <ul>
                                        @foreach (session('import_errors_missing_rut') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if(session('import_errors_incomplete_data'))
                                    <h5>Errores por datos incompletos:</h5>
                                    <ul>
                                        @foreach (session('import_errors_incomplete_data') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                @php use Illuminate\Support\Str; @endphp

                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Apellidos</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nombre</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Carrera</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Sexo</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alumnos as $alumno)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $alumno->rut_alumno }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $alumno->apellido_paterno }}
                                                    {{ $alumno->apellido_materno }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $alumno->nombre_alumno }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0" title="{{ $alumno->carrera }}">
                                                    {{ Str::limit($alumno->carrera, 40, '...') }}
                                                </p>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge badge-sm border {{ $alumno->sexo_alumno === 'M' ? 'bg-gradient-blue' : 'bg-gradient-pink' }}"
                                                    style="width: 35px;">
                                                    {{ $alumno->sexo_alumno }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm {{ $alumno->estado_alumno == 'Activo' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                    {{ $alumno->estado_alumno }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            {{-- Paginación --}}
                            <div class="d-flex justify-content-center mt-3">
                                {{ $alumnos->links('pagination::bootstrap-4') }}
                            </div>
                            @if($alumnos->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay alumnos registrados.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection