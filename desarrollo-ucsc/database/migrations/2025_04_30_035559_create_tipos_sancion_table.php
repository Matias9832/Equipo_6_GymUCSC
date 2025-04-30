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
        Schema::create('tipos_sancion', function (Blueprint $table) {
            
            $table->primary('id_tipo_sancion');
            $table->unsignedBigInteger('id_tipo_sancion'); // Esto es obligatorio por defecto

            $table->string('nombre_tipo_sancion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_sancion');
    }
};
