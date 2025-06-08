<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_equipo');
            $table->unsignedBigInteger('id_deporte');
            $table->unsignedBigInteger('capitan_id')->nullable(); // Agregar esta línea
            $table->timestamps();

            $table->foreign('id_deporte')->references('id_deporte')->on('deportes')->onDelete('cascade');
            $table->foreign('capitan_id')->references('id_usuario')->on('usuario')->onDelete('set null'); // Agregar esta línea
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipos');
    }
}