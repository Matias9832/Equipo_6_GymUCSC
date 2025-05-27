<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FontColorSeeder extends Seeder
{
    public function run(): void
    {
        // Colores
        DB::table('colores')->insert([
            // 1. Clásico Académico
            ['nombre_color' => 'Fondo Clásico Académico', 'codigo_hex' => '#f4f4f4', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Barra Azul Académico', 'codigo_hex' => '#00274D', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Botón Azul Universitario', 'codigo_hex' => '#0057B7', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Texto Oscuro', 'codigo_hex' => '#212121', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Éxito Verde', 'codigo_hex' => '#2E7D32', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Error Rojo', 'codigo_hex' => '#C62828', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],

            // 2. Deportivo Moderno
            ['nombre_color' => 'Fondo Deportivo Moderno', 'codigo_hex' => '#ffffff', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Barra Azul Eléctrico', 'codigo_hex' => '#0D47A1', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Botón Azul Fuerte', 'codigo_hex' => '#1976D2', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Texto Negro Suave', 'codigo_hex' => '#212121', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Éxito Verde Deportivo', 'codigo_hex' => '#4CAF50', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Error Rojo Moderno', 'codigo_hex' => '#F44336', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],

            // 3. Campus Verde
            ['nombre_color' => 'Fondo Verde Claro', 'codigo_hex' => '#F1F8E9', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Barra Verde Bosque', 'codigo_hex' => '#33691E', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Botón Verde Saludable', 'codigo_hex' => '#689F38', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Texto Verde Fuerte', 'codigo_hex' => '#1B5E20', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Éxito Verde Claro', 'codigo_hex' => '#43A047', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Error Rojo Alerta', 'codigo_hex' => '#D32F2F', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],

            // 4. Universitario Rojo
            ['nombre_color' => 'Fondo Blanco Gris', 'codigo_hex' => '#FAFAFA', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Barra Morado Universitario', 'codigo_hex' => '#7B1FA2', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Botón Rojo Intenso', 'codigo_hex' => '#C62828', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Texto Grafito', 'codigo_hex' => '#263238', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Éxito Verde Oscuro', 'codigo_hex' => '#388E3C', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Error Rojo', 'codigo_hex' => '#D32F2F', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],

            // 5. Deportivo Naranja
            ['nombre_color' => 'Fondo Naranja Claro', 'codigo_hex' => '#FFF3E0', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Barra Naranja Fuerte', 'codigo_hex' => '#EF6C00', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Botón Naranja Intermedio', 'codigo_hex' => '#FB8C00', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Texto Marrón Oscuro', 'codigo_hex' => '#4E342E', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Éxito Verde', 'codigo_hex' => '#43A047', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Error Rojo Coral', 'codigo_hex' => '#E53935', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],

            // 6. Futuro Digital
            ['nombre_color' => 'Fondo Gris Claro', 'codigo_hex' => '#ECEFF1', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Barra Grafito Oscuro', 'codigo_hex' => '#263238', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Botón Gris Azulado', 'codigo_hex' => '#546E7A', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Texto Gris Fuerte', 'codigo_hex' => '#37474F', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Éxito Verde Neón', 'codigo_hex' => '#00C853', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_color' => 'Mensaje Error Rojo Neón', 'codigo_hex' => '#D50000', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Fuentes
        DB::table('fuentes')->insert([
            ['nombre_fuente' => 'Montserrat', 'familia_css' => 'Montserrat, sans-serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Montserrat', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_fuente' => 'Merriweather', 'familia_css' => 'Merriweather, serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Merriweather', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_fuente' => 'Roboto', 'familia_css' => 'Roboto, sans-serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Roboto', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_fuente' => 'Lato', 'familia_css' => 'Lato, sans-serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Lato', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_fuente' => 'Open Sans', 'familia_css' => 'Open Sans, sans-serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Open+Sans', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_fuente' => 'Poppins', 'familia_css' => 'Poppins, sans-serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Poppins', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_fuente' => 'Inter', 'familia_css' => 'Inter, sans-serif', 'url_fuente' => 'https://fonts.googleapis.com/css2?family=Inter', 'activo' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
