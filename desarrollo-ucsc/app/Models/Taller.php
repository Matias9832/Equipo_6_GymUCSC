<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'talleres';
    protected $primaryKey = 'id_taller';

    protected $fillable = [
        'nombre_taller',
        'descripcion_taller',
        'cupos_taller',
        'indicaciones_taller',
        'activo_taller',
        'duracion_taller',
    ];

    public function horarios()
    {
        return $this->hasMany(HorarioTaller::class, 'id_taller', 'id_taller');
    }
}
