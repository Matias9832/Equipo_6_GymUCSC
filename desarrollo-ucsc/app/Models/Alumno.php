<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'alumno';

    // Especificar la clave primaria
    protected $primaryKey = 'rut_alumno';

    // Deshabilitar la auto-incrementación, ya que la clave primaria no es un entero
    public $incrementing = false;

    // Especificar el tipo de la clave primaria
    protected $keyType = 'string';

    // Permitir asignación masiva para estas columnas
    protected $fillable = [
        'rut_alumno',
        'apellido_paterno',
        'apellido_materno',
        'nombre_alumno',
        'carrera',
        'ua_carrera',
        'estado_alumno',
        'sexo_alumno',
        'correo_alumno',
    ];

    protected $dates = ['created_at', 'updated_at'];

}