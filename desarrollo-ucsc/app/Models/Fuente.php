<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    use HasFactory;

    protected $table = 'fuentes';

    protected $fillable = [
        'nombre_fuente',
        'familia_css',
        'url_fuente',
    ];
}
