<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioTenantSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuario_tenant')->insert([
            [
                'rut_usuario' => '20839592',
                'nombre_usuario' => 'JOAQUÍN GUZMÁN',
                'gmail_usuario' => 'jguzmana@ing.ucsc.cl',
                'tipo_usuario_tenant' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rut_usuario' => '21080600',
                'nombre_usuario' => 'MATÍAS CARRASCO',
                'gmail_usuario' => 'mcarrascoa@ing.ucsc.cl',
                'tipo_usuario_tenant' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rut_usuario' => '20154345',
                'nombre_usuario' => 'JAVIERA RIQUELME',
                'gmail_usuario' => 'jriquelmec@ing.ucsc.cl',
                'tipo_usuario_tenant' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rut_usuario' => '21164518',
                'nombre_usuario' => 'SEBASTIÁN CONSTANZO',
                'gmail_usuario' => 'sconstanzo@ing.ucsc.cl',
                'tipo_usuario_tenant' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
