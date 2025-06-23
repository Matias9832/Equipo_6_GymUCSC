<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use App\Models\AcademyNews; 
use App\Models\Administrador; 
use App\Models\AcademyImg; 
use App\Models\Academia; 
use App\Models\Espacio; 
class AcademyNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
         // Paso 1: Desmarcar noticias cuya fecha destacada ha expirado
        AcademyNews::where('is_featured', true)
            ->whereNotNull('featured_until')
            ->where('featured_until', '<', now())
            ->update([
                'is_featured' => false,
                'featured_until' => null
            ]);

        // Paso 2: Obtener todas las noticias con paginación
        $news = AcademyNews::with('administrador', 'images') // también cargamos imágenes si las usas en la vista
            ->orderByDesc('fecha_noticia')
            ->paginate(4);

        // Paso 3: Obtener noticias destacadas válidas
        $featuredNews = AcademyNews::with('images', 'administrador')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('featured_until')
                    ->orWhere('featured_until', '>=', now());
            })
            ->orderBy('fecha_noticia', 'desc')
            ->take(5)
            ->get();

        $banner = \App\Models\AcademySetting::first();
        $academias = Academia::with('horarios')->get();
        return view('academynews.index', compact('news', 'featuredNews', 'banner', 'academias'));

     

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $espacios = Espacio::all();
        return view('academynews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nombre_noticia' => 'required|string|max:255',
            'descripcion_noticia' => 'required',
            'is_featured' => 'nullable|boolean',
            'featured_until' => 'nullable|date',
        ]);
        
        $data['is_featured'] = $request->boolean('is_featured');
        $admin = Administrador::where('rut_admin', auth()->user()->rut)->firstOrFail();

        $newsacademy = AcademyNews::create([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'encargado_noticia' => $admin->nombre_admin,
            'fecha_noticia' => now(),
            'id_admin' => $admin->id_admin,
            'is_featured' => $data['is_featured'] ?? 0,
            'featured_until' => $data['featured_until'] ?? null,

        ]);

        $this->guardarImagenes($request, $newsacademy);

        return redirect()->route('academynews.index')->with('success', 'Noticia creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $academynews = AcademyNews::with('images')->findOrFail($id);
        return view('academynews.show', compact('academynews'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $newsacademy = AcademyNews::with('images')->findOrFail($id);
        if ($newsacademy->is_featured && $newsacademy->featured_until && now()->greaterThan($newsacademy->featured_until)) {
            $newsacademy->is_featured = false;
            $newsacademy->featured_until = null;
            $newsacademy->save();
        }
        return view('academynews.edit', compact('newsacademy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newsacademy = AcademyNews::findOrFail($id);

        $data = $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nombre_noticia' => 'required|string|max:255',
            'descripcion_noticia' => 'required',
            'is_featured' => 'nullable|boolean',
            'featured_until' => 'nullable|date',
        ]);
        
        $data['is_featured'] = $request->boolean('is_featured');

        $newsacademy->update([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'is_featured' => $data['is_featured'] ?? 0,
            'featured_until' => $data['featured_until'] ?? null,
        ]);

        // Eliminar imágenes seleccionadas
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = AcademyImg::find($imageId);
                if ($image) {
                    $this->eliminarImagenFisica($image->image_path);
                    $image->delete();
                }
            }
        }

        $this->guardarImagenes($request, $newsacademy);
        return redirect()->route('academynews.index')->with('success', 'Noticia actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newsacademy = AcademyNews::with('images')->findOrFail($id);

        foreach ($newsacademy->images as $image) {
            $this->eliminarImagenFisica($image->image_path);
            $image->delete();
        }

        $newsacademy->delete();
        
        return redirect()->route('academynews.index')->with('success', 'Noticia eliminada con éxito.');
    }

     private function guardarImagenes(Request $request, AcademyNews $newsacademy)
    {
        if ($request->hasFile('images')) {
            $destinationPath = public_path('img/noticias');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $filename = uniqid('noticia_') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);

                $newsacademy->images()->create([
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
        $newsacademy = AcademyNews::findOrFail($id);

        // Solo admin o usuario con permiso
        $this->authorize('Editar Noticias');

        $newsacademy->is_featured = !$newsacademy->is_featured;

        if ($newsacademy->is_featured) {
            // Ejemplo: destacar por 7 días
            $newsacademy->featured_until = now()->addDays(7);
        } else {
            $newsacademy->featured_until = null;
        }

        $newsacademy->save();

        return response()->json([
            'success' => true,
            'destacado' => $newsacademy->is_featured,
        ]);
    }
    public function destroyImage($id)
    {
        $image = AcademyImg::findOrFail($id);
        $this->eliminarImagenFisica($image->image_path);
        $image->delete();

        // Redirige de vuelta a la página anterior con mensaje de éxito
        return redirect()->back()->with('success', 'Imagen eliminada con éxito.');
    }
}

