# Gimnasio_UCSC
Repositorio Git para plataforma Web UCSC
 
## Iniciar proyecto laravel
    1.Habilitar extension=zip en php.ino
    2.composer create-project "laravel/laravel:^10.0" desarrollo-ucsc
    3.cd desarrollo-ucsc

    4.composer install / update
    5.php artisan key:generate
    6.php artisan serve

> Si el paso anterior no funciona se debe Verificar que en la carpeta .env existe e instalar composer en la carpeta desarrollo-ucsc
     

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