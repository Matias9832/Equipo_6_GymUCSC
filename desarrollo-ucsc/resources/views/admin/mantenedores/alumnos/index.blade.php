@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Alumnos'])
    <div class="container-fluid py-4">
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

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Alumnos</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <!-- Formulario para cargar el archivo Excel -->
                        <form action="{{ route('alumnos.import') }}" method="POST" enctype="multipart/form-data" class="mb-4 px-4">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="file" class="form-label">Seleccionar archivo Excel</label>
                                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror">
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary mt-4">Importar Alumnos</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Apellidos</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Carrera</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
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
                                                <p class="text-xs font-weight-bold mb-0">{{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $alumno->nombre_alumno }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $alumno->carrera }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm {{ $alumno->estado_alumno == 'Activo' ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
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