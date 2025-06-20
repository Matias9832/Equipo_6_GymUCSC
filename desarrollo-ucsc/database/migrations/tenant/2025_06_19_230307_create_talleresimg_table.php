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
        Schema::create('talleresimg', function (Blueprint $table) {
            $table->id('id_imagen');
            $table->unsignedBigInteger('id_noticia');
            $table->string('image_path');
            $table->timestamps();
            $table->foreign('id_noticia')->references('id_noticia')->on('talleresnews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talleresimg');
    }
};