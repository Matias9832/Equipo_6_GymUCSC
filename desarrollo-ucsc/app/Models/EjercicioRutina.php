<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EjercicioRutina extends Model
{
    protected $table = 'ejercicio_rutina';

    protected $fillable = [
        'rutina_id',
        'ejercicio_id',
        'series',
        'repeticiones',
        'descanso', // Nuevo campo
    ];

    public function rutina()
    {
        return $this->belongsTo(Rutina::class, 'rutina_id', 'id');
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'ejercicio_id', 'id');
    }
}