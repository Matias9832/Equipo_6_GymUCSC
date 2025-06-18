<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HorarioAcademia;

class Academia extends Model
{
    use HasFactory;
    protected $table = 'academias';

    protected $primaryKey = 'id_academia';

    protected $fillable = [
        'nombre_academia',
        'descripcion_academia',
        'matricula',
        'mensualidad',
        'id_espacio',
        'implementos',

    ];

    public function horarios()
    {
        return $this->hasMany(HorarioAcademia::class, 'id_academia', 'id_academia');
    }
}
