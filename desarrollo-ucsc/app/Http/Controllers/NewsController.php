<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth'); // Asegura login
        $this->middleware('admin'); // Solo admins (crea middleware si no existe)
    }

    public function index()
    {
        $news = News::latest()->paginate(5);
       
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }
    

    public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required',
        'contenido' => 'required',
        'category' => 'required',
        'author' => 'required',
        'published_at' => 'required|date',
        'imagen' => 'nullable|image',
    ]);

    // Guardar la imagen si está presente
    $nombreImagen = null;
        if ($request->hasFile('imagen')) {
            $nombreImagen = time().'.'.$request->imagen->extension();
            $request->imagen->storeAs('public', $nombreImagen);
        }

        News::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'category' => $request->category,
            'author' => $request->author,
            'published_at' => $request->published_at,
            'imagen' => $nombreImagen,
        ]);

    return redirect()->route('news.index')->with('success', 'Noticia creada con éxito.');
}

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
            'category' => 'required',
            'author' => 'required',
            'published_at' => 'required|date',
            'imagen' => 'nullable|image',
        ]);

        if ($request->hasFile('imagen')) {
            if ($news->imagen) {
                Storage::delete('public/' . $news->imagen);
            }
            $nombreImagen = time().'.'.$request->imagen->extension();
            $request->imagen->storeAs('public', $nombreImagen);
            $news->imagen = $nombreImagen;
        }

        $news->update($request->except('imagen'));

        return redirect()->route('news.index')->with('success', 'Noticia actualizada.');
    }

    public function destroy(News $news)
    {
        if ($news->imagen) {
            Storage::delete('public/' . $news->imagen);
        }
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Noticia eliminada.');
    }
}

