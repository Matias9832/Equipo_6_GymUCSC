<?php

namespace App\Http\Controllers\Tenants\Personalizacion;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colore = Color::paginate(5);
        return view('tenants.personalizacion.colores.index', compact('colore'));
    }

    public function create()
    {
        return view('tenants.personalizacion.colores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_color' => 'required|string|max:100',
            'codigo_hex' => 'required|string|size:7',
        ]);

        Color::create([
            'nombre_color' => $request->nombre_color,
            'codigo_hex' => $request->codigo_hex,
        ]);

        return redirect()->route('personalizacion.colores.index')->with('success', 'Color creado correctamente.');
    }

    public function edit(Color $colore) // Laravel infiere el singular como "colore"
    {
        return view('tenants.personalizacion.colores.edit', ['color' => $colore]);
    }

    public function update(Request $request, Color $colore)
    {
        $request->validate([
            'nombre_color' => 'required|string|max:100',
            'codigo_hex' => 'required|string|size:7',
        ]);

        $colore->update([
            'nombre_color' => $request->nombre_color,
            'codigo_hex' => $request->codigo_hex,
        ]);

        return redirect()->route('personalizacion.colores.index')->with('success', 'Color actualizado correctamente.');
    }

    public function destroy(Color $colore)
    {
        $colore->delete();
        return redirect()->route('personalizacion.colores.index')->with('success', 'Color eliminado.');
    }
}
