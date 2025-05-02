<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deporte extends Model
{
    use HasFactory;

    protected $table = 'deportes'; // Nombre de la tabla en la base de datos

    protected $primaryKey = 'id_deporte'; // Clave primaria

    protected $fillable = [
        'nombre_deporte',
        'jugadores_por_equipo',
        'descripcion',
    ]; // Campos que se pueden asignar masivamente
}