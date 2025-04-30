<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Alumno;

class NewsController extends Controller
{
    
    public function __construct()
    {
        
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }


    public function index()
    {
        $news = News::latest()->paginate(3);
       
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
        'imagen' => 'nullable|image',
    ]);

    // Guardar la imagen si está presente
    $nombreImagen = null;
    if ($request->hasFile('imagen')) {
        $nombreImagen = time().'.'.$request->imagen->extension();
        $request->imagen->storeAs('public', $nombreImagen);
    }

    $rutUsuario = auth()->user()->rut_alumno;
    $alumno= Alumno::where('rut_alumno', $rutUsuario)->first();

    News::create([
        'titulo' => $request->titulo,
        'contenido' => $request->contenido,
        'category' => $request->category,
        'author' => $alumno->nombre_alumno,
        'published_at' => now(),
        'imagen' => $nombreImagen,
    ]);

    return redirect('/')->with('success', 'Noticia creada con éxito.');
}

public function show($id)
{
    $news = News::findOrFail($id);
    return view('news.show', compact('news'));
}

public function edit($id)
{
    $news = News::findOrFail($id);
    return view('news.edit', compact('news'));
}

public function update(Request $request, $id)
{
    $news = News::findOrFail($id);

    // Validación de campos
    $request->validate([
        'titulo' => 'required',
        'contenido' => 'required',
        'category' => 'required',
        'imagen' => 'nullable|image',  // Imagen opcional
    ]);

    // Si se ha subido una nueva imagen, reemplazar la anterior
    if ($request->hasFile('imagen')) {
        // Eliminar la imagen antigua si existe
        if ($news->imagen) {
            Storage::delete('public/' . $news->imagen);
        }
        // Guardar la nueva imagen
        $nombreImagen = time() . '.' . $request->imagen->extension();
        $request->imagen->storeAs('public', $nombreImagen);
        $news->imagen = $nombreImagen;
    }

    // Actualizar los demás campos
    $news->titulo = $request->titulo;
    $news->contenido = $request->contenido;
    $news->category = $request->category;
    

    // Guardar la noticia actualizada
    $news->save();

    // Redirigir con mensaje de éxito
    return redirect('/')->with('update', 'Noticia actualizada.');
}

    public function destroy(News $news)
    {
        if ($news->imagen) {
            Storage::delete('public/' . $news->imagen);
        }
        $news->delete();
        return redirect('/')->with('delete', 'Noticia eliminada.');
    }
}

