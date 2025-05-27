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
            $file = $request->file('imagen');
            $filename = uniqid('ejercicio_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/ejercicios'), $filename);
            $data['imagen'] = 'ejercicios/' . $filename;
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
            // Elimina la imagen anterior si existe
            if ($ejercicio->imagen && file_exists(public_path('img/' . $ejercicio->imagen))) {
                unlink(public_path('img/' . $ejercicio->imagen));
            }
            $file = $request->file('imagen');
            $filename = uniqid('ejercicio_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/ejercicios'), $filename);
            $data['imagen'] = 'ejercicios/' . $filename;
        }

        $ejercicio->update($data);

        return redirect()->route('ejercicios.index')->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function destroy(Ejercicio $ejercicio)
    {
        if ($ejercicio->imagen && file_exists(public_path('img/' . $ejercicio->imagen))) {
            unlink(public_path('img/' . $ejercicio->imagen));
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