<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';
    protected $primaryKey = 'id_tema';
    public $timestamps = true;

    protected $fillable = [
        'nombre_tema',
        'nombre_fuente',
        'familia_css',
        'url_fuente',

        // Colores principales
        'bs_primary',
        'bs_success',
        'bs_danger',

        // Variantes PRIMARY
        'primary_focus',
        'border_primary_focus',
        'primary_gradient',

        // Variantes SUCCESS
        'success_focus',
        'border_success_focus',
        'success_gradient',

        // Variantes DANGER
        'danger_focus',
        'border_danger_focus',
        'danger_gradient',
    ];
}
