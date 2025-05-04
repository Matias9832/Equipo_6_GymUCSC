<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsImage;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        $news = News::with('administrador')->orderByDesc('fecha_noticia')->paginate(3);
        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nombre_noticia' => 'required|string|max:255',
            'descripcion_noticia' => 'required',
            'tipo_deporte' => 'required|string',
        ]);

        $rutUsuario = auth()->user()->rut;
        $admin = Administrador::where('rut_admin', $rutUsuario)->first();
        
        

        
        $news = News::create([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'tipo_deporte' => $data['tipo_deporte'],
            'encargado_noticia' => $admin->nombre_admin,
            'fecha_noticia' => now(),
            'id_admin' => $admin->id_admin,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('news_images', 'public');
                
                NewsImage::create([
                    'id_noticia' => $news->id_noticia,
                    'image_path' => $path,
                ]);
            }
        }
        return redirect('/')->with('success', 'Noticia creada con éxito.');
    }

    public function show($id)
    {
        $news = News::with('images')->findOrFail($id);
        return view('news.show', compact('news'));
    }

    public function edit($id)
    {
        $news = News::with('images')->findOrFail($id);
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $data = $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nombre_noticia' => 'required|string|max:255',
            'descripcion_noticia' => 'required',
            'tipo_deporte' => 'required|string',
        ]);

        $news->update([
            'nombre_noticia' => $request->nombre_noticia,
            'descripcion_noticia' => $request->descripcion_noticia,
            'tipo_deporte' => $request->tipo_deporte,
        ]);

        // Eliminar imágenes seleccionadas
        if ($request->has('delete_images') && is_array($request->delete_images)) {
            foreach ($request->delete_images as $imageId) {
                $image = NewsImage::findOrFail($imageId);
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
       
         // Subir nuevas imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('news_images', 'public');
                $news->images()->create(['image_path' => $path]);
            }
        }

        return redirect('/')->with('update', 'Noticia actualizada.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Elimina todas las imágenes asociadas
        foreach ($news->images as $image) {
            Storage::delete('public/' . $image->image_path);
            $image->delete();
        }

        $news->delete();
        return redirect('/')->with('delete', 'Noticia eliminada.');
    }
}
