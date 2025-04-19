<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" id="correo" required>
        <br>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" required>
        <br>
        <label for="contraseña_confirmation">Confirmar Contraseña:</label>
        <input type="password" name="contraseña_confirmation" id="contraseña_confirmation" required>
        <br>
        <label for="rut">RUT:</label>
        <input type="text" name="rut" id="rut" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>