# Gimnasio_UCSC
Repositorio Git para plataforma Web UCSC
 
## Iniciar proyecto laravel
    1.Habilitar extension=zip y gd en php.ino
    2.composer create-project "laravel/laravel:^10.0" desarrollo-ucsc
    3.cd desarrollo-ucsc

    4.composer install / update
    5.php artisan key:generate
    6.php artisan serve

> Si el paso anterior no funciona se debe Verificar que en la carpeta .env existe e instalar composer en la carpeta desarrollo-ucsc

### Dependencias adicionales:
    composer require maatwebsite/excel
    composer require simplesoftwareio/simple-qrcode
    composer require spatie/laravel-permission
    
### Hacer:
    php artisan config:clear
    php artisan cache:clear
    php artisan config:cache

## Para el manejo de la base de datos:
    1. php artisan migrate :    Migra la base de datos
    2. php artisan migrate:fresh o refresH :    Actualizan los atributos de las mismas

## Para el manejo de rutas:
    1. php artisan optimize :   Para actualizar las utas según corresponda

## Para el Login y Register 
Se debe iniciar la instancia del login y register con:

    1. composer require laravel/breeze --dev
    2. php artisan breeze:install

Se debe montar la concección a travez de:

    1. npm install
    2. npm run dev


# Creacion de tablas en laravel 10.x

## php artisan make:migration create_[nombre_tabla]

    $table->integer(''); //Se define la variable
    $table->primary(''); //Se le añade como clave primaria

    $table->string('');
    $table->foreign('')->references('')->on('');


## php artisan make:seeder AlumnoSeeder
Crear un seeder, ayuda a cargar datos de manera automatica, para ejecutar un sedder se debe:


Para ejecutar todos los sedders:
> php artisan db:seed 

Para ejecutar un sedder en especifico:
> php artisan db:seed --class=AlumnoSeeder

# Creación de un Mantenedor

## Estructura del Proyecto

### 1. Layout Principal
El layout principal del panel de control es admin.blade.php
`resources/views/layouts/admin.blade.php`
### 2. Carpeta para los CRUDS
Los CRUDs se organizan dentro de la carpeta mantenedores, ubicada en:
`resources/views/admin/mantenedores`

Cada CRUD tiene su propia carpeta, por ejemplo:
```
mantenedores/
    alumnos/
        create.blade.php
        edit.blade.php
        index.blade.php
```
## Pasos para crear un crud

### Paso 1: Crear el Controlador
1. Genera un controlador con los métodos necesarios para un CRUD:
`php artisan make:controller NombreController`
2. Esto generará un archivo en:
`app/Http/Controllers/NombreController.php`
por ejemplo:
`app/Http/Controllers/CursoController.php`
3. El controlador incluirá métodos como index, create, store, edit, update, y destroy.

### Paso 2 Configurar las rutas
1. Abre el archivo web.php ubicado en:
`routes/web.php`
2. Agrega las rutas para el CRUD dentro del grupo admin:
Route::prefix('admin')->group(function () {
    Route::resource('cursos', CursoController::class);
});

Esto generará automáticamente las rutas necesarias:

/admin/cursos → Lista de cursos.
/admin/cursos/create → Formulario para crear un curso.
/admin/cursos/{cursos}/edit → Formulario para editar un curso.

## Paso 3: Crear las Vistas
1. Crea una carpeta para el CRUD dentro de mantenedores:
`resources/views/admin/mantenedores/cursos`

2.Dentro de esta carpeta, crea los siguientes archivos:
* index.blade.php (listar cursos)
* create.blade.php (formulario para crear un Curso)
* edit.blade.php (formulario para editar un Curso)

### ejemplo de index.blade.php:
```
@extends('layouts.admin')

@section('title', 'Lista de Cursos')

@section('content')
    <h1 class="h3">Lista de Cursos</h1>
    <a href="{{ route('cursos.create') }}" class="btn btn-primary mb-3">Crear Curso</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->nombre }}</td>
                    <td>{{ $curso->descripcion }}</td>
                    <td>
                        <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
```
### Ejemplo de create.blade.php
```
@extends('layouts.admin')

@section('title', 'Crear Curso')

@section('content')
    <h1 class="h3">Crear Curso</h1>
    <form action="{{ route('cursos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre del curso" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción del curso" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Crear Curso</button>
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
```
### Ejemplo de edit.blade.php
```
@extends('layouts.admin')

@section('title', 'Editar Curso')

@section('content')
    <h1 class="h3">Editar Curso</h1>
    <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $curso->nombre }}" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ $curso->descripcion }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
```

## Paso 4: Agregar la Opción al Sidebar

1. Abre el archivo admin.blade.php ubicado en:
```
resources/views/layouts/admin.blade.php
```

2. Agrega un enlace al CRUD en la barra lateral (sidebar):
```
@section('sidebar')
<div class="p-3">
    <h5 class="mb-4">Panel de Control</h5>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('welcome') }}" class="nav-link text-dark">
                <i class="bi bi-house-door me-2"></i> Inicio
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('alumnos.index') }}" class="nav-link text-dark">
                <i class="bi bi-people me-2"></i> Alumnos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('cursos.index') }}" class="nav-link text-dark">
                <i class="bi bi-book me-2"></i> Cursos
            </a>
        </li>
    </ul>
</div>
@endsection
```
## Paso 5: Probar el CRUD

Cada tabla tiene sus atributos y restricciones distintas que deben hacer seguimiento de errores.