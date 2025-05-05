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
        Schema::create('salud', function (Blueprint $table) {
            $table->id('id_salud');
            $table->boolean('enfermo_cronico')->default(false);
            $table->boolean('alergias')->default(false);
            $table->boolean('indicaciones_medicas')->default(false);
            $table->text('informacion_salud')->nullable();
            $table->unsignedBigInteger('id_usuario'); 
            
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salud');
    }
};
