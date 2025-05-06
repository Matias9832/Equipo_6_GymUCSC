<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorneosTable extends Migration
{
    public function up()
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre_torneo');
            $table->unsignedBigInteger('id_sucursal'); // Clave foránea hacia la tabla sucursal
            $table->unsignedBigInteger('id_deporte'); // Clave foránea hacia la tabla deportes
            $table->integer('max_equipos');
            $table->timestamps();

            // Clave foránea hacia la tabla sucursal
            $table->foreign('id_sucursal')->references('id_suc')->on('sucursal')->onDelete('cascade');

            // Clave foránea hacia la tabla deportes
            $table->foreign('id_deporte')->references('id_deporte')->on('deportes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('torneos');
    }
}