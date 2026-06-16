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
        Marca::create([
            'nombre_marca' => 'UCSC',
            'logo_marca' => 'img/empresas/684a46da3a1e3.png',
            'mision_marca' => 'Entregar formación académica de calidad, inspirada en valores cristianos y orientada al bien común.',
            'vision_marca' => 'Ser una comunidad universitaria reconocida por su compromiso social y excelencia educativa.',
        ]);
    }
}
