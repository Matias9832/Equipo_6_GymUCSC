<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademySetting;

class AcademySettingController extends Controller
{
   
    public function edit()
    {
        $setting = AcademySetting::firstOrCreate([]);
        
        return view('academy_setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $banner = AcademySetting::first(); // o find($id) si manejas múltiples

        if ($request->hasFile('banner_image')) {
            $filename = time() . '.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('img/banner_academia'), $filename);

            $banner->banner_image_path = 'img/banner_academia/' . $filename;
        }

        $banner->banner_title = $request->input('banner_title');
        $banner->banner_subtitle = $request->input('banner_subtitle');
        $banner->save();

        return redirect()->route('academias.index')->with('success', 'Banner actualizado correctamente');
    }

    public function deleteImage()
    {
        $setting = AcademySetting::first();

        // Elimina el archivo del servidor si existe
        if ($setting && $setting->banner_image_path && file_exists(public_path($setting->banner_image_path))) {
            unlink(public_path($setting->banner_image_path));
        }

        // Limpia el campo en la base de datos
        $setting->banner_image_path = null;
        $setting->save();

        return redirect()->back()->with('success', 'Imagen del banner eliminada correctamente.');
    }

}

