<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioAcademia extends Model
{
    use HasFactory;

    protected $table = 'horarios_academia';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_academia',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    public function academia()
    {
        return $this->belongsTo(Academia::class, 'id_academia', 'id_academia');
    }
}
