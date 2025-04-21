<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticias;

class NoticiasController extends Controller
{
    public function index()
    {
        $noticias = Noticias::latest()->paginate(3); ; 
        return view('welcome', compact('noticias'));
    }
    
    public function show(Noticias $noticia)
    {
        return view('noticias.show', compact('noticia'));
    }

    public function create()
    {
        return view('noticias.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $noticia = new Noticias();
        $noticia->titulo = $request->titulo;
        $noticia->contenido = $request->contenido;

        // Subida de imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $nombre = time() . '_' . $file->getClientOriginalName();
            $ruta = $file->storeAs('public/noticias', $nombre);
            $noticia->imagen = 'storage/noticias/' . $nombre;
        }

        $noticia->save();

        return redirect()->route('noticias.index')->with('success', 'Noticia publicada');
    }


    public function edit(Noticias $noticia)
    {
        return view('noticias.edit', compact('noticia'));
    }

    public function update(Request $request, Noticias $noticia)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validación de imagen
        ]);
    
        // Guardar la nueva imagen si está presente
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($noticia->imagen && file_exists(storage_path('app/public/' . $noticia->imagen))) {
                unlink(storage_path('app/public/' . $noticia->imagen));
            }
    
            // Subir la nueva imagen
            $imagenPath = $request->file('imagen')->store('images', 'public');
            $noticia->imagen = $imagenPath;
        }
    
        // Actualizar la noticia
        $noticia->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);
    
        return redirect()->route('noticias.index')->with('success', 'Noticia actualizada con éxito.');
    }
    

    public function destroy(Noticias $noticia)
    {
        $noticia->delete();

        return redirect()->route('noticias.index')->with('success', 'Noticia eliminada con éxito.');
    }
}


