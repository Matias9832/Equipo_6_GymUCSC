<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingreso', function (Blueprint $table) {
            $table->integer('id_ingreso');
            $table->primary('id_ingreso');
            
            $table->integer('id_sala');
            $table->unsignedBigInteger('id_usuario'); // Cambiado a 'unsignedBigInteger'

            $table->foreign('id_sala')->references('id_sala')->on('sala');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario'); 

            $table->date('fecha_ingreso');
            $table->time('hora_ingreso');
            $table->time('hora_salida');
            $table->time('tiempo_uso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso');
    }
};