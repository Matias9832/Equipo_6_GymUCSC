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
        Schema::create('maquina', function (Blueprint $table) {
            $table->integer('id_maq');
            $table->primary('id_maq');
            
            $table->string('nombre_maq');
            $table->boolean('estado_maq');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquina');
    }
};
