<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    protected $table = 'rutinas';

    protected $fillable = [
        'user_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id_usuario');
    }

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'ejercicio_rutina', 'rutina_id', 'ejercicio_id')
            ->withPivot('series', 'repeticiones', 'descanso') // <-- Añadido 'descanso'
            ->withTimestamps();
    }
}