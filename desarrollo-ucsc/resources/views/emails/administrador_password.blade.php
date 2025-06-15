<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Credenciales de Administrador</title>
    <style>
        body {
            background: #fafbfc;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 480px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            padding: 32px 32px 24px 32px;
        }

        .header {
            text-align: center;
            color: #2d3e50;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 24px;
        }

        .password-box {
            background: #2d3e50;
            color: #fff;
            padding: 12px 0;
            border-radius: 6px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 18px 0 24px 0;
            letter-spacing: 2px;
        }

        .footer {
            margin-top: 32px;
            text-align: center;
            color: #8392ab;
            font-size: 0.95rem;
        }
    </style>

    @php
        use App\Models\Marca;
        $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
    @endphp
</head>

<body>
    <div class="container">
        <div class="header">Credenciales de Administrador</div>
        <p>¡Hola {{ $nombre_admin }}!</p>
        <p>Se ha creado tu cuenta de administrador en el sistema. Estas son tus credenciales:</p>
        <div class="password-box">
            Contraseña: {{ $password }}
        </div>
        <p><strong>Por favor, cambia tu contraseña después de iniciar sesión.</strong></p>
        <p>Si no solicitaste esta cuenta, puedes ignorar este correo.</p>
        <p>Saludos,<br>Equipo Deportes {{ $ultimaMarca->nombre_marca ?? 'Marca por defecto' }}</p>
        <div class="footer">
            © {{ date('Y') }} Ugym. Todos los derechos reservados.
        </div>
    </div>
</body>

</html>