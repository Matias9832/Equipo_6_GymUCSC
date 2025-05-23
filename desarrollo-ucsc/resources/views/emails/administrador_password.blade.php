<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credenciales de Administrador</title>
</head>
<body>
    <h1>Hola {{ $nombre_admin }}!</h1>
    <p>Se ha creado tu cuenta de administrador en el sistema. Estas son tus credenciales:</p>
    <p><strong>Contraseña:</strong> {{ $password }}</p>
    <p>Por favor, cambia tu contraseña después de iniciar sesión.</p>
    <p>Saludos,<br>Equipo GYMUCSC</p>
</body>
</html>