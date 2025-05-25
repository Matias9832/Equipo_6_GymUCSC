<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioTaller extends Model
{
    use HasFactory;

    protected $table = 'horarios_talleres';

    protected $fillable = [
        'id_taller',
        'dia_taller',
        'hora_inicio',
        'hora_termino',
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class, 'id_taller', 'id_taller');
    }
}
