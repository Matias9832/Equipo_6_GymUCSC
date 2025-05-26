<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    protected $table = 'ejercicios';

    protected $fillable = [
        'nombre',
        'imagen', // Campo para la imagen
        'grupo_muscular',
    ];

    public function rutinas()
    {
        return $this->belongsToMany(Rutina::class, 'ejercicio_rutina')
            ->withPivot('series', 'repeticiones')
            ->withTimestamps();
    }
}