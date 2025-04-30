<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    use HasFactory;

    protected $table = 'maquina';
    protected $primaryKey = 'id_maq';
    public $timestamps = false;

    protected $fillable = [
        'nombre_maq',
        'estado_maq',
    ];
}