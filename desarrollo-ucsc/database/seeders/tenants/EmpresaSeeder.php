<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('empresas')->insert([
            [
                'nombre' => 'UCSC',
                'logo' => 'img/empresas/684a46da3a1e3.png',
                'mision' => 'Entregar formación académica de calidad, inspirada en valores cristianos y orientada al bien común.',
                'vision' => 'Ser una comunidad universitaria reconocida por su compromiso social y excelencia educativa.',
                'subdominio' => 'Sin subdominio asignado',
                'dominio' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'UDEC',
                'logo' => 'img/empresas/684a468d7296d.png',
                'mision' => 'Formar personas integrales, comprometidas con el desarrollo sustentable y con una sólida base ética y científica.',
                'vision' => 'Ser una universidad líder en la formación de profesionales para enfrentar los desafíos del siglo XXI.',
                'subdominio' => 'Sin subdominio asignado',
                'dominio' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'UDD',
                'logo' => 'img/empresas/684a469ddf3ad.png',
                'mision' => 'Educar personas con espíritu emprendedor, sentido ético y vocación de servicio a la sociedad.',
                'vision' => 'Consolidarse como una universidad innovadora, reconocida por su excelencia académica y aporte al país.',
                'subdominio' => 'Sin subdominio asignado',
                'dominio' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
