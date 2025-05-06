<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Salud extends Model
{
    use HasFactory;
    protected $table = 'salud';
    protected $primaryKey = 'id_salud';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'enfermo_cronico',
        'alergias',
        'indicaciones_medicas',
        'informacion_salud',
        'detalle_alergias',
        'detalle_indicaciones',
        'cronicas',
        'id_usuario',
    ];

    protected $casts = [
        'cronicas' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
