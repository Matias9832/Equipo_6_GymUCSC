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
        Schema::create('espacio', function (Blueprint $table) {
            $table->integer('id_espacio');
            $table->primary('id_espacio');
            
            $table->integer('id_suc');
            $table->foreign('id_suc')->references('id_suc')->on('sucursal');
            
            $table->string('nombre_espacio');
            $table->string('tipo_espacio')->constrained('tipos_espacio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('espacio');
    }
};
