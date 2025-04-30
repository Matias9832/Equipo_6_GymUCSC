<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'region'; // Nombre de la tabla
    protected $primaryKey = 'id_region'; // Clave primaria
    protected $keyType = 'integer'; // Tipo de la clave primaria

    protected $fillable = ['id_pais', 'nombre_region']; // Campos asignables

    // Relación con el modelo Pais
    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id_pais');
    }
}