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
        Schema::create('taller_usuario', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_taller');

            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('id_taller')->references('id_taller')->on('talleres')->onDelete('cascade');

            $table->date('fecha_asistencia'); // Solo día, sin hora

            $table->timestamps();

            // Un usuario puede asistir varias veces a un taller en días distintos
            $table->unique(['id_usuario', 'id_taller', 'fecha_asistencia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taller_usuario');
    }
};