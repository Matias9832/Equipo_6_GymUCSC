<?php

namespace App\Http\Controllers;

use App\Models\NewsImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class NewsImageController extends Controller
{
    public function destroy($id)
    {
        $image = NewsImage::with('news.administrador')->findOrFail($id);

        // Verificar si el usuario autenticado es el creador de la noticia
        if (Auth::user()->rut !== $image->news->administrador->rut_admin) {
            abort(403, 'No tienes permiso para eliminar esta imagen.');
        }

        // Eliminar archivo físico
        $this->eliminarImagenFisica($image->image_path);

        // Eliminar registro de base de datos
        $image->delete();

        return back()->with('success', 'Imagen eliminada correctamente');
    }

    /**
     * Elimina físicamente una imagen del servidor.
     */
    private function eliminarImagenFisica($rutaRelativa)
    {
        $path = public_path($rutaRelativa);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
