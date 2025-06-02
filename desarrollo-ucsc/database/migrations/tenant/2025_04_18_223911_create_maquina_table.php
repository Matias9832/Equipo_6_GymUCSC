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
            $table->id('id_maq'); // Clave primaria
            $table->string('nombre_maq');
            $table->boolean('estado_maq');
            $table->timestamps();
            $table->engine = 'InnoDB'; // Asegura que se use InnoDB
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquina');
    }
};