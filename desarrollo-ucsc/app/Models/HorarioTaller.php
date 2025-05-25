<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    // Formateo de hora_inicio y hora_termino para verse sin segundos
    public function getHoraInicioAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    public function getHoraTerminoAttribute($value)
    {
        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }
}
