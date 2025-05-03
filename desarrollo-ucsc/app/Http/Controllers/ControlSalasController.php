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

        $encryptedId = Crypt::encrypt($sala->id_sala);

        $urlQR = route('sala.registro', [
            'id_sala' => $encryptedId,
            'aforo' => $request->aforo,
        ]);

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

        $registro = Ingreso::where('id_sala', $idSala)
            ->where('id_usuario', $usuario->id_usuario)
            ->where('fecha_ingreso', $fecha)
            ->first();

        if (!$registro) {
            $registro = Ingreso::create([
                'id_sala' => $idSala,
                'id_usuario' => $usuario->id_usuario,
                'fecha_ingreso' => $fecha,
                'hora_ingreso' => now()->format('H:i:s'),
                'hora_salida' => null,
                'tiempo_uso' => null,
            ]);
        }

        return view('usuarios.ingreso.mostrar_ingreso', [
            'fecha' => $fecha,
            'horaIngreso' => $registro->hora_ingreso,
            'idSala' => $idSala,
        ]);
    }

    public function mostrarIngreso()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();
        $fecha = now()->format('Y-m-d');

        $registro = Ingreso::where('id_usuario', $usuario->id_usuario)
            ->where('fecha_ingreso', $fecha)
            ->whereNull('hora_salida') // Solo si aún no ha salido
            ->first();

        if (!$registro) {
            return view('usuarios.ingreso.mostrar_ingreso', [
                'mensaje' => 'No te encuentras dentro de una Sala.',
            ]);
        }

        return view('usuarios.ingreso.mostrar_ingreso', [
            'fecha' => $registro->fecha_ingreso,
            'horaIngreso' => $registro->hora_ingreso,
            'idSala' => $registro->id_sala,
            'mensaje' => null,
        ]);
    }

    public function registrarSalida(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();
        $fecha = now()->format('Y-m-d');

        $registro = Ingreso::where('id_usuario', $usuario->id_usuario)
            ->where('id_sala', $request->id_sala)
            ->where('fecha_ingreso', $fecha)
            ->whereNull('hora_salida')
            ->first();

        if ($registro) {
            $horaSalida = now();
            $horaIngreso = \Carbon\Carbon::parse($registro->hora_ingreso);
            $tiempoUso = $horaIngreso->diffInSeconds($horaSalida);

            $registro->hora_salida = $horaSalida->format('H:i:s');
            $registro->tiempo_uso = $tiempoUso;
            $registro->save();
        }

        return redirect()->route('ingreso.mostrar');
    }



    public function seleccionarSala()
    {
        $sucursalActiva = session('sucursal_activa');

        $salas = Sala::where('id_suc', $sucursalActiva)->get();

        return view('admin.control_salas.seleccionar_sala', compact('salas'));
    }
}
