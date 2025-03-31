# Gimnasio_UCSC
Repositorio Git para plataforma Web UCSC

# Pasos para correr programa en PC

1.- Abrir Cmd 
2.- Ir a la carpeta del proyecto => cd example-app
3.- Ejecutar en cmd el comando composer install (Si se presentan problemas en la instalacion, mas abajo en el documneto se encuentra ayuda para solucionarlo)
4.- Renombrar el archivo .env.example y renombrarlo como .env => cp .env.example .env (si no funciona el comando, duplicar el archivo y renombrarlo manualmente)
5.-Generar la key en el archivo .env => php artisan key:generate
6.- Migrar la Base de datos => php artisan migrate
7.- Iniciar el servidor de desarrollo en el puerto 8000 de la computadora local => php artisan serve
8.- En otra terminal CMD (sin cerrar la actual), ir a la carpeta del proyecto => cd example-app
9.- Ejecutar el comando => npm run dev (si no funciona, ejecutar antes el comando => npm install)


## Problemas instalación composer

1.- Abrir una terminal en CMD
2.- Ir a la siguiente ruta en la terminal (C:\xampp\php>php.ini)
3.- Al abrir el documento de texto
4.- Se debe eliminar el ";" en la linea 962 ";extension=zip" (debe quedar asi "extension=zip")