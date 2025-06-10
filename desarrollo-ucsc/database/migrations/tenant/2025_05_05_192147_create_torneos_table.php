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
            $table->boolean('fase_grupos')->default(false);
            $table->integer('numero_grupos')->nullable();
            $table->integer('equipos_por_grupo')->nullable();
            $table->integer('clasifican_por_grupo')->nullable();
            $table->boolean('partidos_ida_vuelta')->default(false);
            $table->boolean('tercer_lugar')->default(false);
            $table->boolean('fase_grupos_finalizada')->default(false);

            $table->foreign('id_sucursal')->references('id_suc')->on('sucursal')->onDelete('cascade');
            $table->foreign('id_deporte')->references('id_deporte')->on('deportes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('torneos');
    }
}