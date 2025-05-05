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
        Schema::create('news', function (Blueprint $table) {
            $table->id('id_noticia');
            $table->string('nombre_noticia');
            $table->string('encargado_noticia');
            $table->text('descripcion_noticia');
            $table->timestamp('fecha_noticia');
            $table->string('tipo_deporte');
            $table->unsignedBigInteger('id_admin');

            $table->foreign('id_admin')->references('id_admin')->on('administrador')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
