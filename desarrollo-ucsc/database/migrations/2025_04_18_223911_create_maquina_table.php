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
        Schema::create('maquina', function (Blueprint $table) {
            $table->id('id_maq'); // Define 'id_maq' como clave primaria autoincremental
            $table->string('nombre_maq'); // Nombre de la máquina
            $table->boolean('estado_maq'); // Estado de la máquina (activo/inactivo)
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquina'); // Elimina la tabla si existe
    }
};