<?php

namespace App\Http\Controllers;

use App\Exports\MusculacionExport;
use App\Exports\SalaExport;
use App\Models\Sala;
use Illuminate\Http\Request;
use App\Exports\IngresosExport;
use Maatwebsite\Excel\Facades\Excel;

class SalaController extends Controller
{
    public function index()
    {
        $sucursalActiva = session('sucursal_activa');

        $salas = Sala::where('id_suc', $sucursalActiva)->get();

        return view('admin.sucursales.sala.index', compact('salas'));
    }

    public function create()
    {
        return view('admin.sucursales.sala.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_sala' => 'required|string|max:255',
            'aforo_sala' => 'required|integer|min:1',
            'horario_apertura' => 'required|date_format:H:i',
            'horario_cierre' => 'required|date_format:H:i',
        ]);

        if ($request->horario_apertura >= $request->horario_cierre) {
            return back()->withInput()->with('error', 'La hora de apertura debe ser anterior a la de cierre.');
        }

        $data = $request->all();
        $data['id_suc'] = session('sucursal_activa');
        $data['activo'] = false;

        Sala::create($data);

        return redirect()->route('salas.index')->with('success', 'Sala creada correctamente.');
    }

    public function edit($id)
    {
        $sala = Sala::findOrFail($id);

        return view('admin.sucursales.sala.edit', compact('sala'));
    }

    public function update(Request $request, Sala $sala)
    {
        $request->validate([
            'nombre_sala' => 'required|string|max:255',
            'aforo_sala' => 'required|integer|min:1',
        ]);

        if ($request->horario_apertura >= $request->horario_cierre) {
            return back()->withInput()->with('error', 'La hora de apertura debe ser anterior a la de cierre.');
        }

        $sala->update($request->all());

        return redirect()->route('salas.index')->with('success', 'Sala actualizada correctamente.');
    }

    public function exportIngresos(Request $request)
    {
        if (!$request->filled('fecha')) {
            return back()->with('error', 'Debes ingresar una fecha para la exportación.');
        }

        $request->validate([
            'sala_id' => 'required|integer|exists:sala,id_sala',
            'fecha' => 'required|date',
            'tipo' => 'required|in:diario,semanal,mensual',
        ]);

        $fecha = \Carbon\Carbon::parse($request->fecha);
        $inicio = $fecha->copy();
        $fin = $fecha->copy();

        switch ($request->tipo) {
            case 'semanal':
                $inicio->startOfWeek();
                $fin->endOfWeek();
                break;
            case 'mensual':
                $inicio->startOfMonth();
                $fin->endOfMonth();
                break;
            case 'diario':
            default:
                $inicio->startOfDay();
                $fin->endOfDay();
                break;
        }

        $sala = Sala::find($request->sala_id);
        $nombre_excel = 'ingresos_' . $sala->nombre_sala . '_' . $request->tipo . '.xlsx';

        return Excel::download(new SalaExport($request->sala_id, $inicio, $fin), $nombre_excel);
    }

    public function destroy(Sala $sala)
    {
        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala eliminada correctamente.');
    }
}
