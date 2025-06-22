# README - Uso página de creación de Tenants

Se requiere hacer los comandos basicos de laravel como optimize y migrate:fresh
Ahora todas las rutas de la pagina web estan en routes/tenant.php y las de la pagina central en routes/web.php
Todos los migrations de la pagina web se movieron de migrations/ a migrations/tenant/

## URL para acceder a la creación de tenants

Abre en tu navegador la siguiente dirección: ff
http://ugym.cl:8000/tenants

---

## Seeder principal para la pagina de creación de Tenants

php artisan db:seed --class=CentralSeeder

## Configuración necesaria en el archivo hosts (Windows)

Para que el sistema funcione correctamente y puedas acceder a los tenants locales, debes agregar estas líneas en el archivo:

    C:\Windows\System32\drivers\etc\hosts

Debe abrirse como administrador

Agrega lo siguiente al final del archivo:

```plaintext
# Hosts para desarrollo local tenants ugym, de lo contrario windows no lo reconoce, es diferente para ubunto **por ver
127.0.0.1   ugym.cl
127.0.0.1   deportesucsc.ugym.cl
127.0.0.1   deportesudec.ugym.cl
127.0.0.1   deportesunab.ugym.cl
127.0.0.1   deportesudd.ugym.cl
127.0.0.1   deportesinacap.ugym.cl
127.0.0.1   deportes1.ugym.cl
127.0.0.1   deportes2.ugym.cl
127.0.0.1   deportes3.ugvym.local

127.0.0.1   ugym.cl
127.0.0.1   deportesucsc.ugym.cl
127.0.0.1   deportesudec.ugym.cl
127.0.0.1   deportesunab.ugym.cl
127.0.0.1   deportesudd.ugym.cl
127.0.0.1   deportesinacap.ugym.cl
127.0.0.1   deportes1.ugym.cl
127.0.0.1   deportes2.ugym.cl
127.0.0.1   deportes3.ugvym.cl