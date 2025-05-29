<?php

namespace App\Http\Controllers;


use App\Models\NewsImage;

use Illuminate\Support\Facades\Storage;

class NewsImageController extends Controller{
    public function destroy($id)
    {
        $image = NewsImage::findOrFail($id);

        // Ruta absoluta al archivo en /public
        $filePath = public_path($image->image_path);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $image->delete();

        return back()->with('success', 'Imagen eliminada correctamente');
    }
}