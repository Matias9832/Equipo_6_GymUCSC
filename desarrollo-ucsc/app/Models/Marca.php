<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marca';

    protected $primaryKey = 'id_marca';

    protected $fillable = [
        'nombre_marca',
        'logo_marca',
        'mision_marca',
        'vision_marca',
    ];
}
