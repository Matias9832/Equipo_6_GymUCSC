<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEspacio extends Model
{
    protected $table = 'tipos_espacio';

    public $timestamps = false;

    protected $fillable = ['nombre_tipo'];
    
}
