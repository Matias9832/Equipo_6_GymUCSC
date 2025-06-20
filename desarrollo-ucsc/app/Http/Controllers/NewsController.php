<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

use App\Models\News;
use App\Models\NewsImage;
use App\Models\Administrador;
use App\Models\Deporte;
use App\Models\Sucursal;
use App\Models\NewsSetting;

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
        // Paso 1: Desmarcar noticias cuya fecha destacada ha expirado
        News::where('is_featured', true)
            ->whereNotNull('featured_until')
            ->where('featured_until', '<', now())
            ->update([
                'is_featured' => false,
                'featured_until' => null
            ]);

        // Paso 2: Obtener todas las noticias con paginación
        $news = News::with('administrador', 'images') // también cargamos imágenes si las usas en la vista
            ->orderByDesc('fecha_noticia')
            ->paginate(6);

        // Paso 3: Obtener noticias destacadas válidas
        $featuredNews = News::with('images', 'administrador')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('featured_until')
                    ->orWhere('featured_until', '>=', now());
            })
            ->orderBy('fecha_noticia', 'desc')
            ->take(5)
            ->get();

        // Paso 4: Sucursales con salas
        $sucursalesConSalas = Sucursal::with('salas')
            ->where('id_marca', 1)
            ->whereHas('salas')
            ->get();
        
        $banner = \App\Models\NewsSetting::first();
        return view('news.index', compact('news', 'sucursalesConSalas', 'featuredNews', 'banner'));
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
            'is_featured' => 'nullable|boolean',
            'featured_until' => 'nullable|date',
        ]);
        
        $data['is_featured'] = $request->boolean('is_featured');
        $admin = Administrador::where('rut_admin', auth()->user()->rut)->firstOrFail();

        $news = News::create([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'tipo_deporte' => $data['tipo_deporte'],
            'encargado_noticia' => $admin->nombre_admin,
            'fecha_noticia' => now(),
            'id_admin' => $admin->id_admin,
            'is_featured' => $data['is_featured'] ?? 0,
            'featured_until' => $data['featured_until'] ?? null,

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
        if ($news->is_featured && $news->featured_until && now()->greaterThan($news->featured_until)) {
            $news->is_featured = false;
            $news->featured_until = null;
            $news->save();
        }
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
            'is_featured' => 'nullable|boolean',
            'featured_until' => 'nullable|date',
        ]);
        
        $data['is_featured'] = $request->boolean('is_featured');

        $news->update([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'tipo_deporte' => $data['tipo_deporte'],
            'is_featured' => $data['is_featured'] ?? 0,
            'featured_until' => $data['featured_until'] ?? null,
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

   public function toggleFeatured($id)
    {
        $noticia = News::findOrFail($id);

        // Solo admin o usuario con permiso
        $this->authorize('Editar Noticias');

        $noticia->is_featured = !$noticia->is_featured;

        if ($noticia->is_featured) {
            // Ejemplo: destacar por 7 días
            $noticia->featured_until = now()->addDays(7);
        } else {
            $noticia->featured_until = null;
        }

        $noticia->save();

        return response()->json([
            'success' => true,
            'destacado' => $noticia->is_featured,
        ]);
    }



}
