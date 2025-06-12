<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Tenants\Tema;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['empresa', 'domains'])->get();

        return view('tenants.subdominios.index', compact('tenants'));
    }
    public function create()
    {   
        $empresasDisponibles = \App\Models\Tenants\Empresa::where(function ($q) {
            $q->where('subdominio', 'Sin subdominio asignado')
                ->orWhereNull('subdominio');
        })->get();

        $temas = Tema::all();

        return view('tenants.subdominios.create', compact('empresasDisponibles', 'temas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subdominio' => 'required|string|alpha_dash|unique:tenants,id',
            'id_tema' => 'required|exists:temas,id_tema',
            'empresa_id' => 'required|exists:empresas,id',
        ]);

        $empresa = \App\Models\Tenants\Empresa::findOrFail($request->empresa_id);
        $subdominio = strtolower($request->subdominio);
        $dominioCompleto = "{$subdominio}.ugym.local";

        $tenant = Tenant::create([
            'id' => $subdominio,
            'empresa_id' => $request->empresa_id,
        ]);

        $tenant->domains()->create([
            'domain' => $dominioCompleto,
        ]);

        tenancy()->initialize($tenant);

        \App\Models\Marca::create([
            'nombre_marca' => $empresa->nombre,
            'logo_marca' => $empresa->logo,
            'mision_marca' => $empresa->mision,
            'vision_marca' => $empresa->vision,
        ]);

        tenancy()->end();

        $temaBase = Tema::findOrFail($request->id_tema);

        \App\Models\Tenants\TemaTenant::create([
            'tenant_id' => $tenant->id,
            'nombre_tema' => $temaBase->nombre_tema,
            'nombre_fuente' => $temaBase->nombre_fuente,
            'familia_css' => $temaBase->familia_css,
            'url_fuente' => $temaBase->url_fuente,
            'bs_primary' => $temaBase->bs_primary,
            'bs_success' => $temaBase->bs_success,
            'bs_danger' => $temaBase->bs_danger,
            'primary_focus' => $temaBase->primary_focus,
            'border_primary_focus' => $temaBase->border_primary_focus,
            'primary_gradient' => $temaBase->primary_gradient,
            'success_focus' => $temaBase->success_focus,
            'border_success_focus' => $temaBase->border_success_focus,
            'success_gradient' => $temaBase->success_gradient,
            'danger_focus' => $temaBase->danger_focus,
            'border_danger_focus' => $temaBase->border_danger_focus,
            'danger_gradient' => $temaBase->danger_gradient,
        ]);

        $empresa = \App\Models\Tenants\Empresa::find($request->empresa_id);
        $empresa->update([
            'subdominio' => $dominioCompleto,
        ]);

        return redirect()->route('tenants.index')->with('success', 'Tenant creado correctamente.');
    }


}
