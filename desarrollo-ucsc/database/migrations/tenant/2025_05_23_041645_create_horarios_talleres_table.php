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
        Schema::create('horarios_talleres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_taller');
            $table->foreign('id_taller')->references('id_taller')->on('talleres')->onDelete('cascade');
            $table->string('dia_taller', 20);
            $table->time('hora_inicio');
            $table->time('hora_termino');
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_talleres');
    }
};
