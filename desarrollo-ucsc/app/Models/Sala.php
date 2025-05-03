<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'sala';
    protected $primaryKey = 'id_sala';
    public $timestamps = false;

    protected $fillable = [
        'nombre_sala',
        'aforo_sala',
        'id_suc',
    ];
}
