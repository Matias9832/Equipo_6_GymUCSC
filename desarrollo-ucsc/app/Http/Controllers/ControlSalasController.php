<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingreso;
use App\Models\Sala;

class ControlSalasController extends Controller
{
    public function generarQR(Request $request)
    {
        $request->validate([
            'id_sala' => 'required|exists:sala,id_sala',
            'aforo' => 'required|integer|min:1',
        ]);

        $sala = Sala::findOrFail($request->id_sala);

        if ($request->aforo > $sala->aforo_sala) {
            return back()->withErrors(['aforo' => 'El aforo excede el máximo permitido para esta sala.']);
        }

        // Encriptar el id_sala
        $encryptedId = Crypt::encrypt($sala->id_sala);

        $urlQR = route('sala.registro', [
            'id_sala' => $encryptedId,
            'aforo' => $request->aforo,
        ]);

        // Generar el QR
        $qrCode = QrCode::size(300)->generate($urlQR);

        return view('admin.control_salas.gestion_qr', [
            'qrCode' => $qrCode,
            'desdeQR' => false,
        ]);
    }

    public function registroDesdeQR(Request $request)
    {
        try {
            $encryptedId = $request->query('id_sala');
            $idSala = Crypt::decrypt($encryptedId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'ID de sala inválido o modificado.');
        }

        $fecha = now()->format('Y-m-d');

        if (!Auth::check()) {
            return view('usuarios.ingreso.registro', [
                'qrCode' => null,
                'desdeQR' => true,
            ]);
        }

        $usuario = Auth::user();

        // Evitar duplicados opcionalmente
        $existe = Ingreso::where('id_sala', $idSala)
            ->where('id_usuario', $usuario->id_usuario)
            ->where('fecha_ingreso', $fecha)
            ->exists();

        if (!$existe) {
            Ingreso::create([
                'id_sala' => $idSala,
                'id_usuario' => $usuario->id_usuario,
                'fecha_ingreso' => $fecha,
                'hora_ingreso' => now()->format('H:i:s'),
                'hora_salida' => null,
                'tiempo_uso' => null,
            ]);
        }

        return view('usuarios.ingreso.registro_confirmado', compact('fecha'));
    }

    public function seleccionarSala()
    {
        $sucursalActiva = session('sucursal_activa');

        // Obtener solo las salas de la sucursal activa
        $salas = Sala::where('id_suc', $sucursalActiva)->get();

        return view('admin.control_salas.seleccionar_sala', compact('salas'));
    }
}
