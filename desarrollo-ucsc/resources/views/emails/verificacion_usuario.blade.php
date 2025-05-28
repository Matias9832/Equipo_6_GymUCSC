<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de Cuenta</title>
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 32px 32px 24px 32px;
        }
        .header {
            text-align: center;
            color: #D12421;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 24px;
        }
        .code-box {
            background: #D12421;
            color: #fff;
            padding: 14px 0;
            border-radius: 6px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 18px 0 24px 0;
            letter-spacing: 4px;
        }
        .footer {
            margin-top: 32px;
            text-align: center;
            color: #8392ab;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Verificación de Cuenta</div>
        <p>¡Hola {{ $nombreCompleto }}!</p>
        <p>Gracias por registrarte. Por favor, usa el siguiente código para verificar tu cuenta:</p>
        <div class="code-box">
            {{ $codigo }}
        </div>
        <p>Si no realizaste esta solicitud, ignora este correo.</p>
        <p>Saludos,<br>Equipo GYMUCSC</p>
        <div class="footer">
            © {{ date('Y') }} UCSC. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>