<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error de conexión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: linear-gradient(87deg, #172b4d 0,rgb(23, 21, 49) 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Open Sans', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-error {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px #0002;
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .logo-marca {
            width: 90px;
            height: 90px;
            object-fit: contain;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 8px #0001;
            padding: 10px;
        }
        h1 {
            font-size: 2.2rem;
            color:rgb(200, 7, 0);
            margin-bottom: 1rem;
        }
        p {
            color: #525f7f;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }
        a {
            color: #172b4d;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card-error">
        <img src="{{ url('img/tenants/logo_ugym-sinfondo.png') }}" alt="Logo UGYM" class="logo-marca">
        <h1>Error de conexión</h1>
        <p>No se pudo conectar con la base de datos.<br>
        Por favor, intenta nuevamente más tarde.</p>
        <a href="{{ url('/') }}" style="
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #172b4d;
            color: #fff;
            border-radius: 0.7rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            box-shadow: 0 2px 8px #0001;
            transition: background 0.2s;
        " onmouseover="this.style.background='#1a174d'" onmouseout="this.style.background='#172b4d'">
            Ir al inicio
        </a>
    </div>
</body>
</html>