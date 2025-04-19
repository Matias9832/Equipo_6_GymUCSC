<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    <h1>Formulario de Inicio de Sesión</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo" required>
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required>
        <br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>