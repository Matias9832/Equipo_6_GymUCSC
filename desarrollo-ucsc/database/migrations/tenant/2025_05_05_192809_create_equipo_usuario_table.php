<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoUsuarioTable extends Migration
{
    public function up()
    {
        Schema::create('equipo_usuario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipo_id'); // Debe coincidir con la clave primaria de la tabla equipos
            $table->unsignedBigInteger('usuario_id'); // Debe coincidir con la clave primaria de la tabla usuario
            $table->timestamps();

            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id_usuario')->on('usuario')->onDelete('cascade'); // Referencia corregida
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipo_usuario');
    }
}