<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorneosTable extends Migration
{
    public function up()
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_torneo');
            $table->unsignedBigInteger('id_sucursal');
            $table->unsignedBigInteger('id_deporte');
            $table->enum('tipo_competencia', ['liga', 'copa', 'encuentro']);
            $table->integer('max_equipos');
            $table->timestamps();

            $table->foreign('id_sucursal')->references('id_suc')->on('sucursal')->onDelete('cascade');
            $table->foreign('id_deporte')->references('id_deporte')->on('deportes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('torneos');
    }
}