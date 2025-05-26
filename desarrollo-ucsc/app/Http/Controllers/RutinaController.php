<?php

namespace App\Http\Controllers;

use App\Models\Rutina;
use App\Models\Ejercicio;
use App\Models\Usuario;
use Illuminate\Http\Request;

class RutinaController extends Controller
{
    public function index()
    {
        $rutinas = auth()->user()->tipo_usuario === 'admin'
            ? Rutina::with('usuario')->get()
            : Rutina::where('user_id', auth()->id())->with('ejercicios')->get();

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
            'user_id' => 'required|exists:usuario,id_usuario',
            'ejercicios' => 'required|array',
            'ejercicios.*.id' => 'exists:ejercicios,id',
            'ejercicios.*.series' => 'required|integer|min:1',
            'ejercicios.*.repeticiones' => 'required|integer|min:1',
        ]);

        $rutina = Rutina::create(['user_id' => $request->user_id]);

        foreach ($request->ejercicios as $ejercicio) {
            $rutina->ejercicios()->attach($ejercicio['id'], [
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
            ]);
        }

        return redirect()->route('rutinas.index')->with('success', 'Rutina creada correctamente.');
    }

    public function edit(Rutina $rutina)
    {
        $usuarios = Usuario::where('tipo_usuario', 'alumno')->get();
        $ejercicios = Ejercicio::all();
        $rutina->load('ejercicios');
        return view('admin.mantenedores.rutinas.edit', compact('rutina', 'usuarios', 'ejercicios'));
    }

    public function update(Request $request, Rutina $rutina)
    {
        $request->validate([
            'user_id' => 'required|exists:usuario,id_usuario',
            'ejercicios' => 'required|array',
            'ejercicios.*.id' => 'exists:ejercicios,id',
            'ejercicios.*.series' => 'required|integer|min:1',
            'ejercicios.*.repeticiones' => 'required|integer|min:1',
        ]);

        $rutina->update(['user_id' => $request->user_id]);

        $rutina->ejercicios()->detach();
        foreach ($request->ejercicios as $ejercicio) {
            $rutina->ejercicios()->attach($ejercicio['id'], [
                'series' => $ejercicio['series'],
                'repeticiones' => $ejercicio['repeticiones'],
            ]);
        }

        return redirect()->route('rutinas.index')->with('success', 'Rutina actualizada correctamente.');
    }

    public function destroy(Rutina $rutina)
    {
        $rutina->delete();

        return redirect()->route('rutinas.index')->with('success', 'Rutina eliminada correctamente.');
    }
}