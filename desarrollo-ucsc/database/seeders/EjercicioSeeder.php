<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ejercicio;

class EjercicioSeeder extends Seeder
{
    public function run(): void
    {
        $ejercicios = [
            [
                'nombre' => 'Abdominales con polea',
                'grupo_muscular' => 'abdominales',
                'imagen' => 'ejercicios/Abdominales_con_polea.gif',
            ],
            [
                'nombre' => 'Antebrazo con barra',
                'grupo_muscular' => 'antebrazos',
                'imagen' => 'ejercicios/Antebrazo_con_barra.gif',
            ],
            [
                'nombre' => 'Curl de bicep de pie',
                'grupo_muscular' => 'bíceps',
                'imagen' => 'ejercicios/Curl_de_bicep_de_pie.gif',
            ],
            [
                'nombre' => 'Curl de biceps con barra',
                'grupo_muscular' => 'bíceps',
                'imagen' => 'ejercicios/Curl_de_biceps_con_barra.gif',
            ],
            [
                'nombre' => 'Dominadas',
                'grupo_muscular' => 'espalda',
                'imagen' => 'ejercicios/Dominadas.gif',
            ],
            [
                'nombre' => 'Extension de triceps overhead',
                'grupo_muscular' => 'tríceps',
                'imagen' => 'ejercicios/Extension_de_triceps_overhead.gif',
            ],
            [
                'nombre' => 'Isquiotibiales con maquina',
                'grupo_muscular' => 'isquiotibiales',
                'imagen' => 'ejercicios/Isquiotibiales_con_maquina.gif',
            ],
            [
                'nombre' => 'Kettlebell swing',
                'grupo_muscular' => 'glúteos',
                'imagen' => 'ejercicios/Kettlebell_swing.gif',
            ],
            [
                'nombre' => 'Pantorrillas con mancuerna',
                'grupo_muscular' => 'pantorrillas',
                'imagen' => 'ejercicios/Pantorrillas_con_mancuerna.gif',
            ],
            [
                'nombre' => 'Peso muerto con barra',
                'grupo_muscular' => 'isquiotibiales',
                'imagen' => 'ejercicios/Peso_muerto_con_barra.gif',
            ],
            [
                'nombre' => 'Prensa',
                'grupo_muscular' => 'cuádriceps',
                'imagen' => 'ejercicios/Prensa.gif',
            ],
            [
                'nombre' => 'Press banca',
                'grupo_muscular' => 'pecho',
                'imagen' => 'ejercicios/Press_banca.gif',
            ],
            [
                'nombre' => 'Press militar',
                'grupo_muscular' => 'hombros',
                'imagen' => 'ejercicios/Press_militar.gif',
            ],
            [
                'nombre' => 'Sentadilla',
                'grupo_muscular' => 'cuádriceps',
                'imagen' => 'ejercicios/Sentadilla.gif',
            ],
            [
                'nombre' => 'Trapecios con barra',
                'grupo_muscular' => 'trapecio',
                'imagen' => 'ejercicios/Trapecios_con_barra.gif',
            ],
            [
                'nombre' => 'Triceps con banco',
                'grupo_muscular' => 'tríceps',
                'imagen' => 'ejercicios/Triceps_con_banco.gif',
            ],
            [
                'nombre' => 'Triceps con polea',
                'grupo_muscular' => 'tríceps',
                'imagen' => 'ejercicios/Triceps_con_polea.gif',
            ],
            [
                'nombre' => 'Triceps Kickback',
                'grupo_muscular' => 'tríceps',
                'imagen' => 'ejercicios/Triceps_Kickback.gif',
            ],
            [
                'nombre' => 'Zancada Dividida',
                'grupo_muscular' => 'cuádriceps',
                'imagen' => 'ejercicios/Zancada_Dividida.gif',
            ],
        ];

        foreach ($ejercicios as $ejercicio) {
            Ejercicio::create($ejercicio);
        }
    }
}