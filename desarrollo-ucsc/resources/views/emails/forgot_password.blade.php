<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
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
        .btn-primary {
            display: inline-block;
            background: #D12421 !important; /* <-- Color UCSC */
            color: #fff !important;
            padding: 12px 32px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 18px 0;
            font-size: 1rem;
            border: none;
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
        <div class="header">Restablecer Contraseña</div>
        <p>¡Hola!</p>
        <p>Recibiste este correo porque se solicitó restablecer la contraseña de tu cuenta.</p>
        <a href="{{ $url }}" class="btn-primary">Restablecer Contraseña</a>
        <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
        <p>¡Gracias!</p>
        <div class="footer">
            © {{ date('Y') }} UCSC. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>