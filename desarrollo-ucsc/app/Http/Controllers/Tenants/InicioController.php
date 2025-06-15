<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use App\Models\Tenants\Empresa;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        // Solo empresas con subdominio válido
        $empresas = Empresa::whereNotNull('subdominio')
            ->where('subdominio', '!=', 'Sin subdominio asignado')
            ->get();

        return view('tenants.inicio', compact('empresas'));
    }
}
