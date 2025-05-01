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
        Schema::create('sala', function (Blueprint $table) {
            $table->id('id_sala'); // Clave primaria

            $table->string('nombre_sala');
            $table->integer('aforo_sala');

            $table->unsignedBigInteger('id_suc');
            $table->foreign('id_suc')->references('id_suc')->on('sucursal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sala');
    }
};