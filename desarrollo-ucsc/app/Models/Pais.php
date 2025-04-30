<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    use HasFactory;

    protected $table = 'pais'; // Nombre de la tabla
    protected $primaryKey = 'id_pais'; // Clave primaria
    protected $keyType = 'integer'; // Tipo de la clave primaria

    protected $fillable = ['nombre_pais', 'bandera_pais']; // Campos asignables
}