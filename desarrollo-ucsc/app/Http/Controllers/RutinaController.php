<?php
namespace App\Http\Controllers;

use App\Models\Rutina;
use App\Models\Ejercicio;
use App\Models\Usuario;
use App\Models\Alumno;
use Illuminate\Http\Request;

class RutinaController extends Controller
{
    public function index()
    {
        $rutinas = auth()->user()->tipo_usuario === 'admin'
            ? Rutina::with(['usuario', 'creador', 'ejercicios'])->get()
            : Rutina::where('user_id', auth()->user()->id_usuario)->with(['usuario', 'creador', 'ejercicios'])->get();

        return view('admin.mantenedores.rutinas.index', compact('rutinas'));
    }

    public function create()
    {
        $usuarios = Usuario::where('tipo_usuario', 'alumno')->get();
        $ejercicios = Ejercicio::all();
        return view('admin.mantenedores.rutinas.create', compact('usuarios', 'ejercicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'user_id' => 'required|exists:usuario,id_usuario',
            'ejercicios' => 'required|array|min:1',
            'ejercicios.*.id' => 'required|exists:ejercicios,id',
            'ejercicios.*.series' => 'required|integer|min:1',
            'ejercicios.*.repeticiones' => 'required|integer|min:1',
            'ejercicios.*.descanso' => 'required|integer|min:0',
        ], [
            'required' => 'Por favor completa todos los campos obligatorios.',
            'exists' => 'Uno de los valores seleccionados no es válido.',
            'min' => 'Debes agregar al menos un ejercicio.'
        ]);

        $rutina = Rutina::create([
            'nombre' => $request->nombre,
            'user_id' => $request->user_id,
            'creador_rut' => auth()->user()->rut,
        ]);

        foreach ($request->ejercicios as $ejercicio) {
            $rutina->ejercicios()->attach($ejercicio['id'], [
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
                'descanso' => $ejercicio['descanso'] ?? 0,
            ]);
        }

        return redirect()->route('rutinas.index')->with('success', 'Rutina creada correctamente.');
    }

    public function edit(Rutina $rutina)
    {
        $ejercicios = Ejercicio::all();
        return view('admin.mantenedores.rutinas.edit', compact('rutina', 'ejercicios'));
    }

    public function update(Request $request, Rutina $rutina)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // 'user_id' => 'required|exists:usuario,id_usuario', // No se permite cambiar usuario en edición
            'ejercicios' => 'required|array|min:1',
            'ejercicios.*.id' => 'required|exists:ejercicios,id',
            'ejercicios.*.series' => 'required|integer|min:1',
            'ejercicios.*.repeticiones' => 'required|integer|min:1',
            'ejercicios.*.descanso' => 'required|integer|min:0',
        ], [
            'required' => 'Por favor completa todos los campos obligatorios.',
            'exists' => 'Uno de los valores seleccionados no es válido.',
            'min' => 'Debes agregar al menos un ejercicio.'
        ]);

        $rutina->update([
            'nombre' => $request->nombre,
            // 'user_id' => $request->user_id, // No se actualiza el usuario asignado
        ]);

        $rutina->ejercicios()->detach();
        foreach ($request->ejercicios as $ejercicio) {
            $rutina->ejercicios()->attach($ejercicio['id'], [
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
                'descanso' => $ejercicio['descanso'] ?? 0,
            ]);
        }

        return redirect()->route('rutinas.index')->with('success', 'Rutina actualizada correctamente.');
    }

    public function destroy(Rutina $rutina)
    {
        $rutina->delete();

        return redirect()->route('rutinas.index')->with('success', 'Rutina eliminada correctamente.');
    }

    // Método para buscar alumno por RUT (para el formulario de rutinas)
    public function buscarPorRut($rut)
    {
        $usuario = Usuario::where('rut', $rut)
            ->where('tipo_usuario', 'alumno')
            ->where('bloqueado_usuario', 0)
            ->where('activado_usuario', 1)
            ->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'No hay alumno registrado, activo y habilitado con ese RUT.'
            ]);
        }

        // Buscar nombre en la tabla alumnos
        $alumno = Alumno::where('rut_alumno', $rut)->first();
        $nombre = $alumno ? $alumno->nombre_alumno : 'Sin nombre registrado';

        return response()->json([
            'success' => true,
            'usuario' => [
                'id_usuario' => $usuario->id_usuario,
                'nombre' => $nombre,
            ]
        ]);
    }
}