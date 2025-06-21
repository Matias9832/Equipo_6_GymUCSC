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
            $query->where('admin_sucursal.activa', true)
                  ->where('admin_sucursal.id_suc', session('sucursal_activa'));
        })->with([
            'sucursales' => function ($query) {
                $query->wherePivot('activa', true);
            }
        ])->get();

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
            'banner_title' => 'required|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
        ]);

        $banner = QuienesSomosSetting::first() ?? new QuienesSomosSetting();

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $path = $file->store('banners', 'public');
            $banner->banner_image_path = $path;
        }

        $banner->banner_title = $request->banner_title;
        $banner->banner_subtitle = $request->banner_subtitle;
        $banner->save();

        return redirect()->route('quienes-somos.index')->with('success', 'Banner actualizado correctamente.');
    }
}