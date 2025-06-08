<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all(); // Ya tienes el modelo extendido

        return view('tenants.index', compact('tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subdominio' => 'required|string|alpha_dash|unique:tenants,id',
        ]);

        $subdominio = strtolower($request->subdominio);
        $dominioCompleto = "{$subdominio}.ugym.local";

        $tenant = Tenant::create([
            'id' => $subdominio,
        ]);

        $tenant->domains()->create([
            'domain' => $dominioCompleto,
        ]);

        return redirect()->back()->with('success', 'Tenant creado correctamente.');
    }

}
