<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    use HasFactory;
    protected $table = 'espacio';
    public $timestamps = false;

    protected $primaryKey = 'id_espacio';
    public $incrementing = true;

    protected $fillable = [
        'nombre_espacio',
        'tipo_espacio',
        'id_suc',
    ];

    /*public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }*/
}
