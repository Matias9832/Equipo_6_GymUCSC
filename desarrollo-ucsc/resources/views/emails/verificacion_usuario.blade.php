<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Cuenta</title>
</head>
<body>
    <h1>Hola {{ $nombreCompleto }}!</h1>
    <p>Gracias por registrarte. Por favor, usa el siguiente código para verificar tu cuenta:</p>
    <h2 style="color: red;">{{ $codigo }}</h2>
    <p>Si no realizaste esta solicitud, ignora este correo.</p>
    <p>Saludos,<br>Equipo GYMUCSC</p>
</body>
</html>