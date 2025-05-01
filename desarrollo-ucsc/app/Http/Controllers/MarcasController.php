<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcasController extends Controller
{
    public function index()
    {
        // Obtener todas las marcas y pasarlas a la vista
        $marcas = Marca::all();
        return view('admin.mantenedores.marcas.index', compact('marcas'));
    }

    public function create()
    {
        // Mostrar el formulario de creación
        return view('admin.mantenedores.marcas.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_marca' => 'required|string|max:100',
            'logo_marca' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'mision_marca' => 'required|string',
            'vision_marca' => 'required|string',
        ]);

        // Subir el logo a la carpeta 'logos/marcas' dentro de 'public/storage'
        $logoPath = $request->file('logo_marca')->store('logos/marcas', 'public');

        // Crear la nueva marca en la base de datos
        Marca::create([
            'nombre_marca' => $request->nombre_marca,
            'logo_marca' => $logoPath,  // Guardar la ruta del logo
            'mision_marca' => $request->mision_marca,
            'vision_marca' => $request->vision_marca,
        ]);

        // Redirigir al índice de marcas con un mensaje de éxito
        return redirect()->route('marcas.index')->with('success', 'Marca creada correctamente.');
    }

    public function edit($id)
    {
        // Buscar la marca por su ID
        $marca = Marca::findOrFail($id);

        // Pasar la marca a la vista de edición
        return view('admin.mantenedores.marcas.edit', compact('marca'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_marca' => 'required|string|max:100',
            'logo_marca' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  // El logo es opcional para la actualización
            'mision_marca' => 'required|string',
            'vision_marca' => 'required|string',
        ]);

        // Buscar la marca por su ID
        $marca = Marca::findOrFail($id);

        // Si el usuario ha subido un nuevo logo
        if ($request->hasFile('logo_marca')) {
            // Eliminar el logo anterior, si existe
            if ($marca->logo_marca && Storage::disk('public')->exists($marca->logo_marca)) {
                Storage::disk('public')->delete($marca->logo_marca);
            }

            // Subir el nuevo logo a la carpeta 'logos/marcas'
            $logoPath = $request->file('logo_marca')->store('logos/marcas', 'public');
            $marca->logo_marca = $logoPath;  // Actualizar la ruta del logo
        }

        // Actualizar la marca con los nuevos datos
        $marca->update([
            'nombre_marca' => $request->nombre_marca,
            'mision_marca' => $request->mision_marca,
            'vision_marca' => $request->vision_marca,
            'logo_marca' => $marca->logo_marca,  // Asegurarse de guardar la ruta del logo
        ]);

        // Redirigir al índice de marcas con un mensaje de éxito
        return redirect()->route('marcas.index')->with('success', 'Marca actualizada correctamente.');
    }

    public function destroy($id)
    {
        // Buscar la marca por su ID
        $marca = Marca::findOrFail($id);

        // Eliminar el logo si existe
        if ($marca->logo_marca && Storage::disk('public')->exists($marca->logo_marca)) {
            Storage::disk('public')->delete($marca->logo_marca);
        }

        // Eliminar la marca de la base de datos
        $marca->delete();

        // Redirigir con un mensaje de éxito
        return redirect()->route('marcas.index')->with('success', 'Marca eliminada correctamente.');
    }
}
