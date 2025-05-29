<?php
namespace App\Http\Controllers;

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
            'nombre_noticia' => $request->nombre_noticia,
            'descripcion_noticia' => $request->descripcion_noticia,
            'tipo_deporte' => $request->tipo_deporte,
        ]);

        // Eliminar imágenes seleccionadas
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = NewsImage::find($imageId);
                if ($image) {
                    $filePath = public_path($image->image_path);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
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
            $filePath = public_path($image->image_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
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
            $destinationPath = public_path('img/news_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $filename = Str::random(20) . '_' . $image->getClientOriginalName();
                $image->move($destinationPath, $filename);

                $news->images()->create([
                    'image_path' => 'img/news_images/' . $filename
                ]);
            }
        }
    }
}
