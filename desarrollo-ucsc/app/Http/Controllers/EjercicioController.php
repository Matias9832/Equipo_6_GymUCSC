<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;

class EjercicioController extends Controller
{
    public function index()
    {
        $ejercicios = Ejercicio::all();
        return view('admin.mantenedores.ejercicios.index', compact('ejercicios'));
    }

    public function create()
    {
        return view('admin.mantenedores.ejercicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'grupo_muscular' => 'required|in:pecho,espalda,hombros,bíceps,tríceps,abdominales,cuádriceps,isquiotibiales,glúteos,pantorrillas,antebrazos,trapecio',
            'imagen' => 'nullable|image|mimes:gif|max:2048',
        ]);

        $data = $request->only(['nombre', 'grupo_muscular']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('ejercicios', 'public');
        }

        Ejercicio::create($data);

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio creado correctamente.');
    }

    public function edit(Ejercicio $ejercicio)
    {
        return view('admin.mantenedores.ejercicios.edit', compact('ejercicio'));
    }

    public function update(Request $request, Ejercicio $ejercicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'grupo_muscular' => 'required|in:pecho,espalda,hombros,bíceps,tríceps,abdominales,cuádriceps,isquiotibiales,glúteos,pantorrillas,antebrazos,trapecio',
            'imagen' => 'nullable|image|mimes:gif|max:2048',
        ]);

        $data = $request->only(['nombre', 'grupo_muscular']);

        if ($request->hasFile('imagen')) {
            if ($ejercicio->imagen) {
                \Storage::disk('public')->delete($ejercicio->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('ejercicios', 'public');
        }

        $ejercicio->update($data);

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function destroy(Ejercicio $ejercicio)
    {
        if ($ejercicio->imagen) {
            \Storage::disk('public')->delete($ejercicio->imagen);
        }

        $ejercicio->delete();

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio eliminado correctamente.');
    }

    // NUEVO: Para mostrar ejercicios por grupo o todos
    public function porGrupo($grupo)
    {
        if ($grupo === 'todos') {
            $ejercicios = Ejercicio::all(['id', 'nombre']);
        } else {
            $ejercicios = Ejercicio::where('grupo_muscular', $grupo)->get(['id', 'nombre']);
        }
        return response()->json($ejercicios);
    }
}