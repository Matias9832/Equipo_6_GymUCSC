<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

use App\Models\News;
use App\Models\NewsImage;
use App\Models\Administrador;
use App\Models\Deporte;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $sucursalesConSalas = Sucursal::with('salas')
            ->where('id_marca', 1)
            ->whereHas('salas')
            ->get();

        return view('news.index', compact('news', 'sucursalesConSalas'));
    }

    public function create()
    {
        $deportes = Deporte::all();
        return view('news.create', compact('deportes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nombre_noticia' => 'required|string|max:255',
            'descripcion_noticia' => 'required',
            'tipo_deporte' => 'required|string',
        ]);

        $admin = Administrador::where('rut_admin', auth()->user()->rut)->firstOrFail();

        $news = News::create([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'tipo_deporte' => $data['tipo_deporte'],
            'encargado_noticia' => $admin->nombre_admin,
            'fecha_noticia' => now(),
            'id_admin' => $admin->id_admin,
        ]);

        $this->guardarImagenes($request, $news);

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
        $deportes = Deporte::all();
        return view('news.edit', compact('news', 'deportes'));
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
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'tipo_deporte' => $data['tipo_deporte'],
        ]);

        // Eliminar imágenes seleccionadas
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = NewsImage::find($imageId);
                if ($image) {
                    $this->eliminarImagenFisica($image->image_path);
                    $image->delete();
                }
            }
        }

        $this->guardarImagenes($request, $news);

        return redirect('/')->with('update', 'Noticia actualizada.');
    }

    public function destroy($id)
    {
        $news = News::with('images')->findOrFail($id);

        foreach ($news->images as $image) {
            $this->eliminarImagenFisica($image->image_path);
            $image->delete();
        }

        $news->delete();

        return redirect('/')->with('delete', 'Noticia eliminada.');
    }

    /**
     * Función auxiliar para guardar imágenes en public/img/news_images
     */
     private function guardarImagenes(Request $request, News $news)
    {
        if ($request->hasFile('images')) {
            $destinationPath = public_path('img/noticias');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $filename = uniqid('noticia_') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);

                $news->images()->create([
                    'image_path' => 'img/noticias/' . $filename
                ]);
            }
        }
    }

     private function eliminarImagenFisica($rutaRelativa)
    {
        $path = public_path($rutaRelativa);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

}
