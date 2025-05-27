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
    composer require laravel/ui
    composer require laravel-frontend-presets/argon
    
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
## Manejo de imagenes
    
    1. php artisan storage:link

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
# Configuración .env para correo
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=gymucsc@gmail.com
MAIL_PASSWORD="brez wsci luaq pnka"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=gymucsc@gmail.com
MAIL_FROM_NAME=UCSC

# Colores de la universidad
 #D12421 Rojo de la universidad
 #646567 Negro de la universidad
  
# Cómo Cambiar el Fondo de una página
## Color específico
```
@section('argon-bg-header')
    <div class="argon-bg-header bg-primary"></div>
@endsection
```
## Imágen
```
@section('argon-bg-header')
    <div class="argon-bg-header" style="background-image: url('URL_AQUI'); background-size:cover; background-position:center;">
        <span class="mask bg-success opacity-6" style="min-height:300px; display:block;"></span>
    </div>
@endsection
```

# Cómo añadir buscador Select2 Para buscar usuario por RUT o nombre
## Código para el blade
```
<select name="id_usuario" id="id_usuario" class="form-select">
                            <option value="">Selecciona un usuario</option>
                            @foreach($usuarios as $usuario)
                                @php
                                    $alumno = $usuario->alumno;
                                    $nombreCompleto = $alumno ? "{$alumno->nombre_alumno} {$alumno->apellido_paterno} {$alumno->apellido_materno}" : 'Nombre no disponible';
                                @endphp
                                <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                    {{ $usuario->rut }} - {{ $nombreCompleto }}
                                </option>
                            @endforeach
                        </select>
```
## Código para poner antes del @endsection
```
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#id_usuario').select2({
                theme: 'bootstrap-5',
                placeholder: "Buscar por RUT o nombre...",
                width: '100%',
                ajax: {
                    url: '{{ route('usuarios.buscar') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return { results: data };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                language: {
                    inputTooShort: function () {
                        return "Escribe para buscar...";
                    },
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    }
                }
            });
            $('#id_usuario').on('select2:open', function () {
                setTimeout(function() {
                    document.querySelector('.select2-search__field').focus();
                }, 100);
            });
        });
    </script>
@endpush
@stack('js')        
```
* Si ya tienes un Script u otra función con Javascript, lo importante es que esté dentro del ```<script>``` y de ```document.addEventListener('DOMContentLoaded', function () {```
* Puedes ver un ejemplo en admin/talleres/asistencia/registrar.blade.php