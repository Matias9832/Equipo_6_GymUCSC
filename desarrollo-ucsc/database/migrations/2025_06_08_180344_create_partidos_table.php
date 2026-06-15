<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidosTable extends Migration
{
    public function up()
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('torneo_id');
            $table->unsignedBigInteger('equipo_local_id');
            $table->unsignedBigInteger('equipo_visitante_id');
            $table->string('resultado_local')->nullable();
            $table->string('resultado_visitante')->nullable();
            $table->integer('ronda')->nullable(); // Para agrupar por fecha/ronda
            $table->enum('etapa', ['liga', 'fase_grupos', 'eliminatoria'])->default('liga'); // NUEVO: etapa del partido
            $table->boolean('finalizada')->default(false); // indica si la fecha está finalizada
            $table->timestamps();

            $table->foreign('torneo_id')->references('id')->on('torneos')->onDelete('cascade');
            $table->foreign('equipo_local_id')->references('id')->on('equipos')->onDelete('cascade');
            $table->foreign('equipo_visitante_id')->references('id')->on('equipos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('partidos');
    }
}