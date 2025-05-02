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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('rut')->unique();
            $table->boolean('bloqueado_usuario')->default(0);
            $table->boolean('activado_usuario')->default(1);
            $table->string('correo_usuario');
            $table->string('contrasenia_usuario');
            $table->string('tipo_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};