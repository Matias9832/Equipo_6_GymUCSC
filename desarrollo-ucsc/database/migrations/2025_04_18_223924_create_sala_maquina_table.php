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
        Schema::create('sala_maquina', function (Blueprint $table) {
            $table->id('id'); // Clave primaria
            $table->unsignedBigInteger('id_sala'); // Clave foránea hacia sala
            $table->unsignedBigInteger('id_maq'); // Clave foránea hacia maquina

            // Definición de claves foráneas
            $table->foreign('id_sala')->references('id_sala')->on('sala')->onDelete('cascade');
            $table->foreign('id_maq')->references('id_maq')->on('maquina')->onDelete('cascade');

            $table->integer('cantidad_maq');
            $table->timestamps();
            $table->engine = 'InnoDB'; // Asegura que se use InnoDB
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sala_maquina');
    }
};