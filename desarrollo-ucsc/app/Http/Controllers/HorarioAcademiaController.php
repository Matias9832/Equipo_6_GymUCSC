<?php

namespace App\Http\Controllers;
use App\Models\Academia;
use App\Models\HorarioAcademia;

use Illuminate\Http\Request;

class HorarioAcademiaController extends Controller
{
    public function index()
    {
        $horarios = HorarioAcademia::with('academia')->get();
        return view('horarios.index', compact('horarios'));
    }

    public function create()
    {
        $academias = Academia::all();
        return view('horarios.create', compact('academias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_academia' => 'required|exists:academias,id_academia',
            'dia' => 'required|string',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        HorarioAcademia::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente.');
    }

    public function edit($id)
    {
        $horario = HorarioAcademia::findOrFail($id);
        $academias = Academia::all();
        return view('horarios.edit', compact('horario', 'academias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_academia' => 'required|exists:academias,id_academia',
            'dia' => 'required|string',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
        ]);

        $horario = HorarioAcademia::findOrFail($id);
        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $horario = HorarioAcademia::findOrFail($id);
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado.');
    }
}
