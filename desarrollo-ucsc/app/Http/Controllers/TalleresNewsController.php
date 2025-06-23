<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;

use Illuminate\Http\Request;
use App\Models\TalleresNews; 
use App\Models\Administrador; 
use App\Models\TalleresImg; 
use App\Models\Taller; 
use App\Models\Espacio; 

class TalleresNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        // Paso 1: Desmarcar noticias cuya fecha destacada ha expirado
        TalleresNews::where('is_featured', true)
            ->whereNotNull('featured_until')
            ->where('featured_until', '<', now())
            ->update([
                'is_featured' => false,
                'featured_until' => null
            ]);

        // Paso 2: Obtener todas las noticias con paginación
        $news = TalleresNews::with('administrador', 'images')
            ->orderByDesc('fecha_noticia')
            ->paginate(4);

        // Paso 3: Obtener noticias destacadas válidas
        $featuredNews = TalleresNews::with('images', 'administrador')
            ->where('is_featured', true)
            ->where(function ($query) {
                $query->whereNull('featured_until')
                    ->orWhere('featured_until', '>=', now());
            })
            ->orderBy('fecha_noticia', 'desc')
            ->take(5)
            ->get();

        $banner = \App\Models\TalleresSetting::first();

        // Ordenar los horarios por día de la semana
        $diasOrden = [
            'Lunes' => 1,
            'Martes' => 2,
            'Miércoles' => 3,
            'Miercoles' => 3,
            'Jueves' => 4,
            'Viernes' => 5,
            'Sábado' => 6,
            'Sabado' => 6,
            'Domingo' => 7,
        ];

        $taller = Taller::with(['horarios', 'administrador'])
            ->where('activo_taller', true)
            ->get()
            ->map(function($t) use ($diasOrden) {
                $t->horarios = $t->horarios->sortBy(function($h) use ($diasOrden) {
                    return $diasOrden[$h->dia_taller] ?? 99;
                })->values();
                return $t;
            });

        return view('talleresnews.index', compact('news', 'featuredNews', 'banner', 'taller'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $espacios = Espacio::all();
        return view('talleresnews.create');
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

        $newstalleres = TalleresNews::create([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'encargado_noticia' => $admin->nombre_admin,
            'fecha_noticia' => now(),
            'id_admin' => $admin->id_admin,
            'is_featured' => $data['is_featured'] ?? 0,
            'featured_until' => $data['featured_until'] ?? null,

        ]);

        $this->guardarImagenes($request, $newstalleres);

        return redirect()->route('talleresnews.index')->with('success', 'Noticia creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $talleresnews = TalleresNews::with('images')->findOrFail($id);
        return view('talleresnews.show', compact('talleresnews'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $newstalleres = TalleresNews::with('images')->findOrFail($id);
        if ($newstalleres->is_featured && $newstalleres->featured_until && now()->greaterThan($newstalleres->featured_until)) {
            $newstalleres->is_featured = false;
            $newstalleres->featured_until = null;
            $newstalleres->save();
        }
        return view('talleresnews.edit', compact('newstalleres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $newstalleres = TalleresNews::findOrFail($id);

        $data = $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nombre_noticia' => 'required|string|max:255',
            'descripcion_noticia' => 'required',
            'is_featured' => 'nullable|boolean',
            'featured_until' => 'nullable|date',
        ]);
        
        $data['is_featured'] = $request->boolean('is_featured');

        $newstalleres->update([
            'nombre_noticia' => $data['nombre_noticia'],
            'descripcion_noticia' => $data['descripcion_noticia'],
            'is_featured' => $data['is_featured'] ?? 0,
            'featured_until' => $data['featured_until'] ?? null,
        ]);

        // Eliminar imágenes seleccionadas
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = Taller::find($imageId);
                if ($image) {
                    $this->eliminarImagenFisica($image->image_path);
                    $image->delete();
                }
            }
        }

        $this->guardarImagenes($request, $newstalleres);
        return redirect()->route('talleresnews.index')->with('success', 'Noticia actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $newstalleres = TalleresNews::with('images')->findOrFail($id);

        foreach ($newstalleres->images as $image) {
            $this->eliminarImagenFisica($image->image_path);
            $image->delete();
        }

        $newstalleres->delete();
        
        return redirect()->route('talleresnews.index')->with('success', 'Noticia eliminada con éxito.');
    }

     private function guardarImagenes(Request $request, TalleresNews $newstalleres)
    {
        if ($request->hasFile('images')) {
            $destinationPath = public_path('img/noticias');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {
                $filename = uniqid('noticia_') . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);

                $newstalleres->images()->create([
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
        $newstalleres = TalleresNews::findOrFail($id);

        // Solo admin o usuario con permiso
        $this->authorize('Editar Noticias');

        $newstalleres->is_featured = !$newstalleres->is_featured;

        if ($newstalleres->is_featured) {
            // Ejemplo: destacar por 7 días
            $newstalleres->featured_until = now()->addDays(7);
        } else {
            $newstalleres->featured_until = null;
        }

        $newstalleres->save();

        return response()->json([
            'success' => true,
            'destacado' => $newstalleres->is_featured,
        ]);
    }
    public function destroyImage($id)
    {
        $image = TalleresImg::findOrFail($id);
        $this->eliminarImagenFisica($image->image_path);
        $image->delete();

        // Redirige de vuelta a la página anterior con mensaje de éxito
        return redirect()->back()->with('success', 'Imagen eliminada con éxito.');
    }
}