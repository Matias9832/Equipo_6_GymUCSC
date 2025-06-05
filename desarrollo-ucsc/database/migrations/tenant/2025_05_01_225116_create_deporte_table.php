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
        Schema::create('deportes', function (Blueprint $table) {
            $table->id('id_deporte'); // Clave primaria
            $table->string('nombre_deporte'); // Nombre del deporte
            $table->integer('jugadores_por_equipo')->nullable(); // Número de jugadores por equipo
            $table->text('descripcion')->nullable(); // Descripción del deporte
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deportes');
    }
};