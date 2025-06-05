<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personalizar extends Model
{
    use HasFactory;

    protected $table = 'personalizar';
    protected $primaryKey = 'id_personalizar';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre_personalizar',
        'id_marca',
        'id_tema',
    ];

    // Relación con Tema (un personalizar tiene un tema)
    public function tema()
    {
        return $this->belongsTo(Tema::class, 'id_tema', 'id_tema');
    }

    // Relación con Marca (asumiendo que tienes modelo Marca)
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }
}
