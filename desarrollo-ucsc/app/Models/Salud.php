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
        'id_usuario',
    ];

    public function user()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
