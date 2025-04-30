<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ControlSalasController extends Controller
{
    public function mostrarQR()
    {
        $fecha = now()->format('Y-m-d');

        // Generamos una URL firmada o simple que apunta al registro
        $urlQR = route('sala.registro', ['fecha' => $fecha]);

        // Generamos el código QR con la URL
        $qrCode = QrCode::size(300)->generate($urlQR);

        // Renderizamos la vista y pasamos el QR
        return view('admin.control_salas.gestion_qr', [
            'qrCode' => $qrCode,
            'desdeQR' => false,
        ]);
    }

    public function registroDesdeQR(Request $request)
    {
        $fecha = $request->query('fecha');

        return view('admin.control_salas.registro', compact('fecha'));
    }

}
