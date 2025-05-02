<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar las dos marcas con los logos correspondientes
        Marca::create([
            'nombre_marca' => 'GymUCSC',
            'logo_marca' => 'logos/marcas/JjQcWP1RjTaVsszTgsAPRV9TYtGQbpLy4sMyxo9Z.png',
            'mision_marca' => 'Nuestra misión es promover el bienestar físico y mental de los estudiantes a través del ejercicio.',
            'vision_marca' => 'Ser el gimnasio universitario más reconocido por su calidad, innovación y servicios en la UCSC.',
        ]);

        Marca::create([
            'nombre_marca' => 'OtraMarca',
            'logo_marca' => 'logos/marcas/ojaL0qbcQse4LGpX4L7PhUtjH3WXFuHyAGxX2dgX.png',
            'mision_marca' => 'Ofrecemos productos de alta calidad que mejoran la experiencia de nuestros clientes.',
            'vision_marca' => 'Ser líder en el mercado de productos innovadores y accesibles.',
        ]);
    }
}
