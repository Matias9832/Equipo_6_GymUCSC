<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;

    protected $table = 'ciudad'; // Nombre de la tabla
    protected $primaryKey = 'id_ciudad'; // Clave primaria
    protected $keyType = 'integer'; // Tipo de la clave primaria

    protected $fillable = ['id_region', 'nombre_ciudad']; // Campos asignables

    // Relación con el modelo Region
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }
}