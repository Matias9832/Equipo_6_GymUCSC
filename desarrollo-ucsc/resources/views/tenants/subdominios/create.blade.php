@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Subdominio')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Crear Tenant'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Crear nuevo subdominio</h6>
                    </div>
                    <div class="card-body pt-0">
                        <form method="POST" action="{{ route('tenants.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="subdominio" class="form-label">Subdominio</label>
                                <div class="input-group">
                                    <input type="text" name="subdominio" id="subdominio"
                                        class="form-control @error('subdominio') is-invalid @enderror"
                                        value="{{ old('subdominio') }}" placeholder="ej: empresa1" required>
                                    <span class="input-group-text">.ugym.cl</span>
                                    @error('subdominio')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="empresa_id" class="form-label">Empresa</label>
                                <select name="empresa_id" id="empresa_id"
                                    class="form-select @error('empresa_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleccione una empresa</option>
                                    @foreach($empresasDisponibles as $empresa)
                                        <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>{{ $empresa->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('empresa_id')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="id_tema" class="form-label">Tema base</label>
                                <select name="id_tema" id="id_tema"
                                    class="form-select @error('id_tema') is-invalid @enderror" required>
                                    <option value="" disabled selected>Seleccione un tema</option>
                                    @foreach($temas as $tema)
                                        <option value="{{ $tema->id_tema }}" {{ old('id_tema') == $tema->id_tema ? 'selected' : '' }}>{{ $tema->nombre_tema }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tema')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Crear</button>
                            <a href="{{ route('tenants.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection