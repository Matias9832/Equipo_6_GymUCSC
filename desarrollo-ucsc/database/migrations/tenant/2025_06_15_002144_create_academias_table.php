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
        Schema::create('academias', function (Blueprint $table) {
            $table->id('id_academia');
            $table->string('nombre_academia');
            $table->text('descripcion_academia');
            $table->unsignedBigInteger('id_espacio')->nullable();
            $table->text('implementos')->nullable();
            $table->string('matricula');
            $table->string('mensualidad');
            $table->timestamps();

            $table->foreign('id_espacio')->references('id_espacio')->on('espacio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academias');
    }
};
