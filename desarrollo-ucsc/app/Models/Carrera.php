<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';

    protected $fillable = [
        'UA',
        'nombre_carrera',
        'cantidad_estudiantes',
    ];
}
