<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::paginate(5);
        return view('tenants.empresas.index', compact('empresas'));
    }

    public function create()
    {
        return view('tenants.empresas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'logo' => 'required|image|max:2048',
            'mision' => 'required|string',
            'vision' => 'required|string',
        ]);

        $logo = $request->file('logo');
        $logoName = uniqid() . '.' . $logo->getClientOriginalExtension();
        $logo->move(public_path('img/empresas'), $logoName);

        Empresa::create([
            'nombre' => $request->nombre,
            'logo' => 'img/empresas/' . $logoName,
            'mision' => $request->mision,
            'vision' => $request->vision,
            'subdominio' => 'Sin subdominio asignado',
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');
    }

    public function show(Empresa $empresa)
    {
        return view('tenants.empresas.show', compact('empresa'));
    }

    public function edit(Empresa $empresa)
    {
        return view('tenants.empresas.edit', compact('empresa'));
    }
    public function update(Request $request, Empresa $empresa)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'logo' => 'nullable|image|max:2048',
            'mision' => 'required|string',
            'vision' => 'required|string',
        ]);

        if ($empresa->subdominio) {
            $request->validate([
                'dominio' => 'nullable|string|max:100',
            ]);
            $empresa->dominio = $request->dominio ?: 'Sin dominio asignado';
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = uniqid() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('img/empresas'), $logoName);
            $empresa->logo = 'img/empresas/' . $logoName;
        }

        $empresa->update([
            'nombre' => $request->nombre,
            'mision' => $request->mision,
            'vision' => $request->vision,
        ]);

        return redirect()->route('empresas.index')->with('success', 'Empresa actualizada.');
    }

    public function destroy(Empresa $empresa)
    {
        $empresa->delete();
        return redirect()->route('empresas.index')->with('success', 'Empresa eliminada.');
    }
}
