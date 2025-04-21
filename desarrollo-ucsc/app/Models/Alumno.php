<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumno'; // Nombre de la tabla
    protected $primaryKey = 'rut'; // Clave primaria
    public $incrementing = false; // Indica que la clave primaria no es autoincremental
    protected $keyType = 'int'; // Tipo de dato de la clave primaria
    protected $fillable = ['rut', 'nombre', 'carrera', 'estado']; // Columnas asignables
}