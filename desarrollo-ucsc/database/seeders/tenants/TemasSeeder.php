<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TemasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $temas = [
            [
                'nombre_tema' => 'Predeterminado',
                'nombre_fuente' => null,
                'familia_css' => null,
                'url_fuente' => null,
                'bs_primary' => '#fb6340',
                'bs_success' => '#2dce89',
                'bs_danger' => '#D12421',
            ],
            [
                'nombre_tema' => 'UCSC',
                'nombre_fuente' => null,
                'familia_css' => null,
                'url_fuente' => null,
                'bs_primary' => '#D12421',
                'bs_success' => '#2dce89',
                'bs_danger' => '#646567',
            ],
        ];

        foreach ($temas as &$tema) {
            // Calculamos las variantes
            $tema['primary_focus'] = self::shadeColor($tema['bs_primary'], -10);
            $tema['border_primary_focus'] = self::shadeColor($tema['bs_primary'], -20);
            $tema['primary_gradient'] = self::shadeColor($tema['bs_primary'], 20);

            $tema['success_focus'] = self::shadeColor($tema['bs_success'], -10);
            $tema['border_success_focus'] = self::shadeColor($tema['bs_success'], -20);
            $tema['success_gradient'] = self::shadeColor($tema['bs_success'], 20);

            $tema['danger_focus'] = self::shadeColor($tema['bs_danger'], -10);
            $tema['border_danger_focus'] = self::shadeColor($tema['bs_danger'], -20);
            $tema['danger_gradient'] = self::shadeColor($tema['bs_danger'], 20);

            $tema['created_at'] = $now;
            $tema['updated_at'] = $now;
        }

        DB::table('temas')->insert($temas);
    }

    /**
     * Simula la función JS shadeColor en PHP.
     */
    private static function shadeColor(string $hex, float $percent): string
    {
        $r = hexdec(substr($hex, 1, 2));
        $g = hexdec(substr($hex, 3, 2));
        $b = hexdec(substr($hex, 5, 2));

        $r = max(0, min(255, $r + ($r * $percent / 100)));
        $g = max(0, min(255, $g + ($g * $percent / 100)));
        $b = max(0, min(255, $b + ($b * $percent / 100)));

        return sprintf("#%02x%02x%02x", round($r), round($g), round($b));
    }
}
