<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AcademySetting;

class AcademySettingController extends Controller
{
    public function edit(AcademySetting $academy_setting)
    {
        return view('academy_setting.edit', ['setting' => $academy_setting]);
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

        return redirect()->route('academynews.index')->with('success', 'Banner actualizado correctamente');
    }
}
