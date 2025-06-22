<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrador;
use App\Models\QuienesSomosSetting;

class QuienesSomosController extends Controller
{
    public function index()
    {
        $docentes = Administrador::whereHas('sucursales', function ($query) {
            // $query->where('admin_sucursal.activa', true)
            //     ->where('admin_sucursal.id_suc', session('sucursal_activa'));
        })
        ->whereHas('usuario.roles', function ($query) {
            $query->whereNotIn('name', ['Super Admin', 'Visor QR']);
        })
        ->with([
            'sucursales' => function ($query) {
                $query->wherePivot('activa', true);
            },
            'usuario.roles'
        ])
        ->get();

        $banner = QuienesSomosSetting::first();

        return view('quienes_somos.index', compact('docentes', 'banner'));
    }

    public function editBanner()
    {
        $banner = QuienesSomosSetting::first();
        return view('quienes_somos.edit', compact('banner'));
    }

    public function updateBanner(Request $request)
    {
        $request->validate([
            'banner_image' => 'nullable|image|max:2048',
            'banner_title' => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
        ]);

        $banner = QuienesSomosSetting::first() ?? new QuienesSomosSetting();

        if ($request->hasFile('banner_image')) {
            $filename = time() . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('img/banner_nosotros'), $filename);

            $banner->banner_image_path = 'img/banner_nosotros/' . $filename;
        
        }

        $banner->banner_title = $request->input('banner_title');
        $banner->banner_subtitle = $request->input('banner_subtitle');
        $banner->save();

        return redirect()->route('quienes-somos.index')->with('success', 'Banner actualizado correctamente.');
    }
}