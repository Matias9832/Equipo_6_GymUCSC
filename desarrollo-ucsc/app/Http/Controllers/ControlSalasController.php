<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Ingreso;
use App\Models\Usuario;
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

        // Activar la sala y guardar aforo
        $sala->activo = true;
        $sala->aforo_qr = $request->aforo;
        $sala->save();

        // Redirigir a la vista correcta donde sí funciona ingreso manual
        return redirect()->route('control-salas.verQR', [
            'id_sala' => $sala->id_sala,
            'aforo_qr' => $request->aforo
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
            'personasConEnfermedad' => $personasConEnfermedad,
            'estudiantes' => $estudiantes,
            'seleccionados' => $seleccionados,
            'sala' => $sala,
        ]);
    }

      public function registroDesdeQR(Request $request)
    {
        try {
            $encryptedId = $request->query('id_sala');
            $idSala = \Crypt::decrypt($encryptedId);
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

        if (!\Auth::check()) {
            return view('usuarios.ingreso.registro', [
                'qrCode' => null,
                'desdeQR' => true,
                'aforo' => $aforo,
                'id_sala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
            ]);
        }

        $usuario = \Auth::user();

        $registroActivo = Ingreso::where('id_sala', $idSala)
            ->where('id_usuario', $usuario->id_usuario)
            ->whereNull('hora_salida')
            ->first();

        if ($registroActivo) {
            return view('usuarios.ingreso.mostrar_ingreso', [
                'mensaje' => 'Ya ingresaste a la sala previamente.',
                'fecha' => $registroActivo->fecha_ingreso,
                'horaIngreso' => $registroActivo->hora_ingreso,
                'idSala' => $idSala,
                'nombreSala' => $sala->nombre_sala,
                'horarioCierre' => $sala->horario_cierre,
                'horaSalidaEsperada' => $registroActivo->hora_salida_estimada,
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

        // Calcular hora de salida estimada (90 minutos o cierre de sala)
        $minutosUso = 6; // Cambia a lo que necesites
        $horaIngreso = now();
        $horaSalidaEstimada = $horaIngreso->copy()->addMinutes($minutosUso);
        if ($horaSalidaEstimada->gt($horaCierre)) {
            $horaSalidaEstimada = $horaCierre;
        }

        $registro = Ingreso::create([
            'id_sala' => $idSala,
            'id_usuario' => $usuario->id_usuario,
            'fecha_ingreso' => $horaIngreso->format('Y-m-d'),
            'hora_ingreso' => $horaIngreso->format('H:i'),
            'hora_salida' => null,
            'hora_salida_estimada' => $horaSalidaEstimada->format('H:i'),
            'tiempo_uso' => null,
        ]);

        return view('usuarios.ingreso.mostrar_ingreso', [
            'fecha' => now()->format('Y-m-d'),
            'horaIngreso' => $registro->hora_ingreso,
            'idSala' => $idSala,
            'nombreSala' => $sala->nombre_sala,
            'horarioCierre' => $sala->horario_cierre,
            'mensaje' => null,
            'horaSalidaEsperada' => $registro->hora_salida_estimada,
        ]);
    }

    public function mostrarIngreso()
    {
        if (!\Auth::check()) {
            return redirect()->route('login');
        }

        $usuario = \Auth::user();
        $fecha = now()->format('Y-m-d');

        $registro = Ingreso::where('id_usuario', $usuario->id_usuario)
            ->where('fecha_ingreso', $fecha)
            ->whereNull('hora_salida')
            ->first();

        if ($registro) {
            $sala = $registro->sala;
            $horaIngreso = \Carbon\Carbon::parse($registro->hora_ingreso);
            $horaCierre = \Carbon\Carbon::createFromTimeString($sala->horario_cierre);
            $horaSalidaEsperada = $horaIngreso->copy()->addMinutes(2);
            if ($horaSalidaEsperada->gt($horaCierre)) {
                $horaSalidaEsperada = $horaCierre;
            }

            return view('usuarios.ingreso.mostrar_ingreso', [
                'mensaje' => null,
                'fecha' => $registro->fecha_ingreso,
                'horaIngreso' => $registro->hora_ingreso,
                'idSala' => $registro->id_sala,
                'nombreSala' => $sala->nombre_sala,
                'horarioCierre' => $sala->horario_cierre,
                'horaSalidaEsperada' => $horaSalidaEsperada->format('H:i'),
            ]);
        }

        return view('usuarios.ingreso.mostrar_ingreso', [
            'mensaje' => 'Escanea el código QR para ingresar a una sala.',
            'fecha' => null,
            'horaIngreso' => null,
            'idSala' => null,
            'nombreSala' => null,
            'horarioCierre' => null,
            'horaSalidaEsperada' => null,
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

        $ingresos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->whereDate('fecha_ingreso', today())
            ->with(['usuario.alumno', 'usuario.administrador', 'usuario.salud'])
            ->get();

        if (request()->ajax()) {
            $tabla = view('admin.control-salas.partials.tabla_usuarios', ['ingresos' => $ingresos])->render();
            $modales = view('admin.control-salas.partials.modales_salud', ['ingresos' => $ingresos])->render();
            return response()->json([
                'tabla' => $tabla,
                'modales' => $modales,
            ]);
        }

        // Solo para la carga inicial, así la vista principal también usa el mismo filtro
        $sala->ingresos = $ingresos;
        return view('admin.control-salas.ver_usuarios', compact('sala'));
    }

    public function registroManual(Request $request)
    {
        $request->validate([
            'rut' => 'required|string',
            'password' => 'required|string',
            'id_sala' => 'required|exists:sala,id_sala',
        ]);

        $usuario = Usuario::where('rut', $request->rut)->first();

        if (!$usuario || !\Hash::check($request->password, $usuario->contrasenia_usuario)) {
            return back()->with('error', 'El rut o la contraseña son incorrectos.')->withInput();
        }

        $sala = Sala::findOrFail($request->id_sala);

        if (!$sala->activo) {
            return back()->with('error', 'La sala no está activa actualmente.')->withInput();
        }

        $horaActual = now();
        $horaApertura = Carbon::createFromTimeString($sala->horario_apertura);
        $horaCierre = Carbon::createFromTimeString($sala->horario_cierre);

        if ($horaActual->lt($horaApertura) || $horaActual->gt($horaCierre)) {
            return back()->with('error', 'La sala no está disponible en este horario.')->withInput();
        }

        $yaIngresado = Ingreso::where('id_usuario', $usuario->id_usuario)
            ->where('id_sala', $request->id_sala)
            ->whereDate('fecha_ingreso', today())
            ->whereNull('hora_salida')
            ->exists();

        if ($yaIngresado) {
            return back()->with('error', 'Ya hay un ingreso activo para este usuario.')->withInput();
        }

        // Calcular hora de salida estimada (90 minutos o cierre de sala)
        $minutosUso = 6; // Cambia a lo que necesites
        $horaIngreso = now();
        $horaSalidaEstimada = $horaIngreso->copy()->addMinutes($minutosUso);
        if ($horaSalidaEstimada->gt($horaCierre)) {
            $horaSalidaEstimada = $horaCierre;
        }

        Ingreso::create([
            'id_sala' => $request->id_sala,
            'id_usuario' => $usuario->id_usuario,
            'fecha_ingreso' => $horaIngreso->format('Y-m-d'),
            'hora_ingreso' => $horaIngreso->format('H:i'),
            'hora_salida' => null,
            'hora_salida_estimada' => $horaSalidaEstimada->format('H:i'),
            'tiempo_uso' => null,
        ]);

        return redirect()->back()->with('success', 'Ingreso registrado correctamente.');
    }

    public function salidaManual(Request $request)
    {
        // Validar entrada
        $request->validate([
            'rut' => 'required',
            'password' => 'required',
            'id_sala' => 'required',
        ]);

        // Buscar usuario por RUT
        $usuario = Usuario::where('rut', $request->rut)->first();

        // Verificar si existe y la contraseña coincide
        if (!$usuario || !Hash::check($request->password, $usuario->contrasenia_usuario)) {
            return back()->with('error', 'El rut o contraseña ingresados son incorrectos')->withInput();
        }



        // Buscar el registro de ingreso aún activo
        $registro = Ingreso::where('id_usuario', $usuario->id_usuario)
            ->where('id_sala', $request->id_sala)
            ->where('fecha_ingreso', today())
            ->whereNull('hora_salida')
            ->first();

        if (!$registro) {
            return back()->with('mensaje', 'No se encontró un ingreso activo para registrar la salida.')->withInput();
        }

        // Calcular la hora de salida y tiempo de uso
        $horaSalida = now();
        $horaIngreso = \Carbon\Carbon::parse($registro->hora_ingreso);
        $tiempoUsoSegundos = $horaIngreso->diffInSeconds($horaSalida);
        $tiempoUso = gmdate("H:i:s", $tiempoUsoSegundos);

        $registro->hora_salida = $horaSalida->format('H:i:s');
        $registro->tiempo_uso = $tiempoUso;
        $registro->save();

        return back()->with('success', 'Salida registrada correctamente.');
    }

    public function estadoUsuario()
    {
        $ingreso = Ingreso::where('id_usuario', auth()->id())->whereNull('hora_salida')->first();

        $horaSalidaEstimada = null;
        if ($ingreso) {
            $horaSalidaEstimada = $ingreso->hora_salida_estimada;
        }

        return response()->json([
            'enSala' => $ingreso ? true : false,
            'nombreSala' => $ingreso?->sala->nombre_sala,
            'horaIngreso' => $ingreso?->hora_ingreso,
            'horarioCierre' => $ingreso?->sala->horario_cierre,
            'horaSalidaEsperada' => $horaSalidaEstimada,
        ]);
    }

    public function aforoData($idSala)
    {
        $sala = Sala::findOrFail($idSala);

        $ingresos = Ingreso::where('id_sala', $sala->id_sala)
            ->whereNull('hora_salida')
            ->with(['usuario.alumno', 'usuario.administrador', 'usuario.salud'])
            ->get();

        $usuariosActivos = $ingresos->count();

        $estudiantes = $ingresos->filter(function ($ingreso) {
            return $ingreso->usuario && $ingreso->usuario->tipo_usuario === 'estudiante';
        })->count();

        $seleccionados = $ingresos->filter(function ($ingreso) {
            return $ingreso->usuario && $ingreso->usuario->tipo_usuario === 'seleccionado';
        })->count();

        $personasConEnfermedad = $ingresos->filter(function ($ingreso) {
            return $ingreso->usuario &&
                $ingreso->usuario->salud &&
                $ingreso->usuario->salud->enfermo_cronico == 1;
        })->count();

        return response()->json([
            'aforoPermitido' => $sala->aforo_qr ?? $sala->aforo_sala,
            'usuariosActivos' => $usuariosActivos,
            'estudiantes' => $estudiantes,
            'seleccionados' => $seleccionados,
            'personasConEnfermedad' => $personasConEnfermedad,
        ]);
    }

}
