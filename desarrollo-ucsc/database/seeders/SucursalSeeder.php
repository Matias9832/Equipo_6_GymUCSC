<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregar sucursal en Concepción
        Sucursal::create([
            'id_ciudad' => 11,
            'id_marca' => 1,
            'nombre_suc' => 'Sede San Andrés',
            'direccion_suc' => 'Av. Alonso de Ribera 2850',
        ]);

        // Agregar sucursal en Chillán
        Sucursal::create([
            'id_ciudad' => 12,
            'id_marca' => 1,
            'nombre_suc' => 'It Chillán',
            'direccion_suc' => 'Arauco 449, 3800676',
        ]);
    }
}
