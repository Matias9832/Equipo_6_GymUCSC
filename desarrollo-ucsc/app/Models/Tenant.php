<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenant';
    protected $primaryKey = 'id_tenant';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre_tenant',
        'id_marca',
        'id_tema',
    ];

    // Relación con Tema (un tenant tiene un tema)
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
