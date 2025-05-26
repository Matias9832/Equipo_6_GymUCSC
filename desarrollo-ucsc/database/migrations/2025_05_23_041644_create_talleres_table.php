<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('talleres', function (Blueprint $table) {
            $table->id('id_taller');
            $table->string('nombre_taller', 100);
            $table->text('descripcion_taller');
            $table->integer('cupos_taller');
            $table->text('indicaciones_taller')->nullable();
            $table->boolean('activo_taller')->default(true);
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->unsignedBigInteger('id_espacio')->nullable(); 
            $table->foreign('id_admin')->references('id_admin')->on('administrador')->nullOnDelete();
            $table->foreign('id_espacio')->references('id_espacio')->on('espacio')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talleres');
    }
};
