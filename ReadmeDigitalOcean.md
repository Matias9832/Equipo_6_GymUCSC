# Tutorial Digital Ocean

## Comandos luego de hacer pull (Copiar y pegar en terminal)

php artisan migrate:fresh
php artisan db:seed --class=CentralSeeder
php artisan optimize 
php artisan config:clear
php artisan cache:clear
php artisan config:cache


php artisan db:seed

## Comandos importantes
    1. cd : moverse entre directorios => cd "Nombre_directorio"
    2. cd.. : volver al directorio anterior
    3. ls : ver elementos dentro del directorio actual
    4. ls -l : ver elementos dentro del directorio actual pero mas detallado
    5. nano : abrir editor de texto de un archivo => nano "Nombre_archivo" (Si no existe el archivo, se crea y si existe, se modifica)

## Como acceder
    1. Abrir CMD
    2. Introducir comando ssh root@"IP" => ssh root@147.182.241.246 
    3. Cuando salga este mensaje "Are you sure you want to continue connecting (yes/no/[fingerprint])?" Responder "yes"
    4. Contraseña : gimnasioTis2insano

> Si el paso anterior no funciona se debe Verificar que en la carpeta .env existe e instalar composer en la carpeta desarrollo-ucsc

## Ir al directorio raiz  
    1. Actualmente te ubicas en la ruta "~" (root@ubuntu-s-1vcpu-1gb-sfo3-01:~#)
    2. Para ir a la carpeta del proyecto debes volver un directorio atras con el comando => cd ..
    3. Ahora estás en la ruta "/" que es la raiz

## Como llegar a la carpeta del proyecto
    1. Ya estando a la ruta "/" debes ir a el directorio "var" => cd var 
    2. Ya estando a la ruta "/var" debes ir a el directorio "www" => cd www
    3. Ya estando a la ruta "/var/www" debes ir a el directorio "Equipo_6_GymUCSC" => cd Equipo_6_GymUCSC
    4. Ya estando a la ruta "/var/www/Equipo_6_GymUCSC" debes ir a el directorio "desarrollo-ucsc" => cd desarrollo-ucsc

>Para acceder mas rapido, usar este comando => cd /var/www/Equipo_6_GymUCSC/desarrollo-ucsc

## Comandos de git
    1. (NO USAR YA QUE ESTÁ CLONADO) git clone https://github.com/Matias9832/Equipo_6_GymUCSC.git : Clonar repositorio 
    2. git fetch : Hacer fetch  
    3. git pull : Hacer pull
    4. git checkout dev : cambiar a la rama d# Tutorial Digital Ocean
 
## Comandos importantes
    1. cd : moverse entre directorios => cd "Nombre_directorio"
    2. cd.. : volver al directorio anterior
    3. ls : ver elementos dentro del directorio actual
    4. ls -l : ver elementos dentro del directorio actual pero mas detallado
    5. nano : abrir editor de texto de un archivo => nano "Nombre_archivo" (Si no existe el archivo, se crea y si existe, se modifica)

## Como acceder
    1. Abrir CMD
    2. Introducir comando ssh root@"IP" => ssh root@147.182.241.246 
    3. Cuando salga este mensaje "Are you sure you want to continue connecting (yes/no/[fingerprint])?" Responder "yes"
    4. Contraseña : gimnasioTis2insano

> Si el paso anterior no funciona se debe Verificar que en la carpeta .env existe e instalar composer en la carpeta desarrollo-ucsc

## Ir al directorio raiz  
    1. Actualmente te ubicas en la ruta "~" (root@ubuntu-s-1vcpu-1gb-sfo3-01:~#)
    2. Para ir a la carpeta del proyecto debes volver un directorio atras con el comando => cd ..
    3. Ahora estás en la ruta "/" que es la raiz

## Como llegar a la carpeta del proyecto
    1. Ya estando a la ruta "/" debes ir a el directorio "var" => cd var 
    2. Ya estando a la ruta "/var" debes ir a el directorio "www" => cd www
    3. Ya estando a la ruta "/var/www" debes ir a el directorio "Equipo_6_GymUCSC" => cd Equipo_6_GymUCSC
    4. Ya estando a la ruta "/var/www/Equipo_6_GymUCSC" debes ir a el directorio "desarrollo-ucsc" => cd desarrollo-ucsc

>Para acceder mas rapido, usar este comando => cd /var/www/Equipo_6_GymUCSC/desarrollo-ucsc

## Comandos de git
    1. (NO USAR YA QUE ESTÁ CLONADO) git clone https://github.com/Matias9832/Equipo_6_GymUCSC.git : Clonar repositorio 
    2. git fetch : Hacer fetch  
    3. git pull : Hacer pull
    4. git checkout dev : cambiar a la rama dev


Mail::raw('Esto es un correo de prueba.', function ($message) {
    $message->to('shevi.1720@gmail.com')->subject('Prueba Mailgun');
});