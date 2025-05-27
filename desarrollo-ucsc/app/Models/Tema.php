<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;

class Tema extends Model
{
    use HasFactory;

    protected $table = 'temas';
    protected $primaryKey = 'id_tema';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre_tema',
        'color_fondo',
        'color_barra',
        'color_boton',
        'color_texto',
        'color_exito',
        'color_error',
        'nombre_fuente',
        'familia_css',
        'url_fuente',
        'activo',
    ];

    // Relación con Tenant (un tema puede tener muchos tenants)
    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'id_tema', 'id_tema');
    }
}
