<?php

namespace App\Http\Controllers;


use App\Models\NewsImage;

use Illuminate\Support\Facades\Storage;

class NewsImageController extends Controller{
    public function destroy($id)
    {
        $image = NewsImage::findOrFail($id);

        // Elimina el archivo del almacenamiento si existe
        Storage::disk('public')->delete($image->image_path);
        
        $image->delete();
        
        return back()->with('success', 'Imagen eliminada correctamente');
    }

}