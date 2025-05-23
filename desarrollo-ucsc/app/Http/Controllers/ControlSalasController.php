<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingreso;
use App\Models\Sala;
use Carbon\Carbon;

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
            return back()->with('error', 'El aforo excede el máximo permitido para esta sala.');
        }

        $sala->activo = true;
        $sala->aforo_qr = $request->aforo;
        $sala->save();

        $encryptedId = Crypt::encrypt($sala->id_sala);
        $urlQR = route('sala.registro', ['id_sala' => $encryptedId, 'aforo' => $request->aforo]);

        $qrCode = QrCode::size(300)->generate($urlQR);

        $usuariosActivos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->count();

        return view('admin.control-salas.gestion_qr', [
            'qrCode' => $qrCode,
            'desdeQR' => true,
            'aforoPermitido' => $request->aforo,
            'usuariosActivos' => $usuariosActivos,
            'sala' => $sala,
        ]);
    }

    public function verQR(Request $request)
    {
        $request->validate([
            'id_sala' => 'required|exists:sala,id_sala',
            'aforo_qr' => 'required|integer|min:1',
        ]);

        $sala = Sala::findOrFail($request->id_sala);

        $encryptedId = Crypt::encrypt($sala->id_sala);
        $urlQR = route('sala.registro', ['id_sala' => $encryptedId, 'aforo' => $request->aforo_qr]);

        $qrCode = QrCode::size(300)->generate($urlQR);

        $ingresos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->with(['usuario.alumno', 'usuario.administrador'])
            ->get();

        $usuariosActivos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->count();

        
        //contar los usuarios tipo estudiantes y tipo seleccionado.
        $estudiantes = $ingresos->filter(function ($ingreso) {
            return $ingreso->usuario->tipo_usuario === 'estudiante';
        })->count();

        $seleccionados = $ingresos->filter(function ($ingreso) {
            return $ingreso->usuario->tipo_usuario === 'seleccionado';
        })->count();
        $personasConEnfermedad = $ingresos->filter(function ($ingreso) {
            return $ingreso->usuario &&
                $ingreso->usuario->salud &&
                $ingreso->usuario->salud->enfermo_cronico == 1;
        })->count();
        return view('admin.control-salas.gestion_qr', [
            'qrCode' => $qrCode,
            'desdeQR' => true,
            'aforoPermitido' => $request->aforo_qr,
            'usuariosActivos' => $usuariosActivos,
            'personasConEnfermedad' => $personasConEnfermedad ,
            'estudiantes' => $estudiantes,
            'seleccionados' => $seleccionados,
            'sala' => $sala,
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

        $aforo = $request->query('aforo');
        $sala = Sala::findOrFail($idSala);

        if (!$sala->activo) {
            return view('usuarios.ingreso.registro', [
                'mensaje' => 'En este momento no se puede acceder a la sala.',
                'aforo' => $aforo,
                'id_sala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
            ]);
        }

        $horaActual = now();
        $horaApertura = Carbon::createFromTimeString($sala->horario_apertura);
        $horaCierre = Carbon::createFromTimeString($sala->horario_cierre);

        if ($horaActual->lt($horaApertura) || $horaActual->gt($horaCierre)) {
            return view('usuarios.ingreso.registro', [
                'mensaje' => "La sala no está disponible en este horario.\nHorario permitido: " . $sala->horario_apertura . " a " . $sala->horario_cierre,
                'aforo' => $aforo,
                'id_sala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
            ]);
        }

        if (!Auth::check()) {
            return view('usuarios.ingreso.registro', [
                'qrCode' => null,
                'desdeQR' => true,
                'aforo' => $aforo,
                'id_sala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
            ]);
        }

        $usuario = Auth::user();

        $registroActivo = Ingreso::where('id_sala', $idSala)
            ->where('id_usuario', $usuario->id_usuario)
            ->whereNull('hora_salida')
            ->first();

        if ($registroActivo) {
            return view('usuarios.ingreso.registro', [
                'mensaje' => 'Ya ingresaste a la sala previamente.',
                'aforo' => $aforo,
                'id_sala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
            ]);
        }

        $usuariosActivos = Ingreso::where('id_sala', $idSala)
            ->whereNull('hora_salida')
            ->count();

        if ($usuariosActivos >= $aforo) {
            return view('usuarios.ingreso.registro', [
                'mensaje' => 'La sala está llena. Intenta más tarde.',
                'aforo' => $aforo,
                'id_sala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
            ]);
        }

        $registro = Ingreso::create([
            'id_sala' => $idSala,
            'id_usuario' => $usuario->id_usuario,
            'fecha_ingreso' => now()->format('Y-m-d'),
            'hora_ingreso' => now()->format('H:i:s'),
            'hora_salida' => null,
            'tiempo_uso' => null,
        ]);

        return view('usuarios.ingreso.mostrar_ingreso', [
            'fecha' => now()->format('Y-m-d'),
            'horaIngreso' => $registro->hora_ingreso,
            'idSala' => $idSala,
            'nombreSala' => $sala->nombre_sala,
            'horarioCierre' => $sala->horario_cierre,
            'mensaje' => null,
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
            ->whereNull('hora_salida')
            ->first();

        if ($registro) {
            $sala = $registro->sala;

            return view('usuarios.ingreso.mostrar_ingreso', [
                'mensaje' => null,
                'fecha' => $registro->fecha_ingreso,
                'horaIngreso' => $registro->hora_ingreso,
                'idSala' => $registro->id_sala,
                'nombreSala' => $sala->nombre_sala,
                'horarioCierre' => $sala->horario_cierre,
            ]);
        }

        return view('usuarios.ingreso.mostrar_ingreso', [
            'mensaje' => 'Escanea el código QR para ingresar a una sala.',
            'fecha' => null,
            'horaIngreso' => null,
            'idSala' => null,
            'nombreSala' => null,
            'horarioCierre' => null,
        ]);
    }


    public function registrarSalida(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = Auth::user();
        $fecha = now()->format('Y-m-d');

        // Buscar el registro de ingreso del usuario en la sala
        $registro = Ingreso::where('id_usuario', $usuario->id_usuario)
            ->where('id_sala', $request->id_sala)
            ->where('fecha_ingreso', $fecha)
            ->whereNull('hora_salida')
            ->first();

        if ($registro) {
            // Registrar la salida
            $horaSalida = now();
            $horaIngreso = Carbon::parse($registro->hora_ingreso);
            $tiempoUsoSegundos = $horaIngreso->diffInSeconds($horaSalida); // Diferencia en segundos

            // Convertir los segundos a formato HH:mm:ss
            $horaUso = gmdate("H:i:s", $tiempoUsoSegundos); // "gmdate" convierte los segundos a formato de hora

            // Guardar la hora de salida y el tiempo de uso en formato TIME (HH:mm:ss)
            $registro->hora_salida = $horaSalida->format('H:i:s');
            $registro->tiempo_uso = $horaUso; // Guardar en formato TIME
            $registro->save();
        }

        // Redirigir de nuevo con un mensaje de éxito
        return redirect()->route('ingreso.mostrar')->with('mensaje', 'Gracias por asistir');
    }

    public function seleccionarSala()
    {
        $sucursalActiva = session('sucursal_activa');

        $salas = Sala::where('id_suc', $sucursalActiva)
            ->where('activo', false)
            ->get();

        $salasActivas = Sala::where('id_suc', $sucursalActiva)
            ->where('activo', true)
            ->get();

        return view('admin.control-salas.seleccionar_sala', compact('salas', 'salasActivas'));
    }

    public function cambiarAforo(Request $request)
    {
        // Validar los datos
        $request->validate([
            'id_sala' => 'required|exists:sala,id_sala',
            'aforo_qr' => 'required|integer|min:1',
        ]);

        // Buscar la sala
        $sala = Sala::findOrFail($request->id_sala);

        // Verificar si el aforo no excede el máximo
        if ($request->aforo_qr > $sala->aforo_sala) {
            return back()->with('error', 'El aforo excede el máximo permitido para esta sala.');
        }

        // Modificar el aforo QR
        $sala->aforo_qr = $request->aforo_qr;
        $sala->save();

        // Redirigir a la vista de gestión de QR con los nuevos datos
        return redirect()->route('control-salas.seleccionar', []);
    }

    public function cerrarSala(Request $request)
    {
        $request->validate([
            'id_sala' => 'required|exists:sala,id_sala',
        ]);

        $sala = Sala::findOrFail($request->id_sala);
        $sala->activo = false;
        $sala->aforo_qr = null;
        $sala->save();

        // Cerrar salida de todos los ingresos activos en esa sala
        $ingresos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->get();

        foreach ($ingresos as $registro) {
            $horaSalida = now();
            $horaIngreso = Carbon::parse($registro->hora_ingreso);
            $tiempoUsoSegundos = $horaIngreso->diffInSeconds($horaSalida);
            $registro->hora_salida = $horaSalida->format('H:i:s');
            $registro->tiempo_uso = gmdate("H:i:s", $tiempoUsoSegundos);
            $registro->save();
        }

        return back()->with('mensaje', 'Sala cerrada correctamente y salidas registradas.');
    }

    public function sacarUsuario(Request $request)
    {
        $ingreso = Ingreso::find($request->id_ingreso);

        if ($ingreso && is_null($ingreso->hora_salida)) {
            $horaSalida = now();
            $horaIngreso = Carbon::parse($ingreso->hora_ingreso);
            $tiempoUsoSegundos = $horaIngreso->diffInSeconds($horaSalida);

            $ingreso->hora_salida = $horaSalida->format('H:i:s');
            $ingreso->tiempo_uso = gmdate("H:i:s", $tiempoUsoSegundos);
            $ingreso->save();
        }

        return back()->with('success', 'Usuario retirado correctamente.');
    }


    public function verUsuarios($id_sala)
    {
        $sala = Sala::where('activo', true)->where('id_sala', $id_sala)->firstOrFail();

        $sala->ingresos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->whereDate('fecha_ingreso', today())
            ->with(['usuario.alumno', 'usuario.administrador'])
            ->get();
    

        return view('admin.control-salas.ver_usuarios', compact('sala'));
    }



}
