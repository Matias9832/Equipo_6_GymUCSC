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
        Schema::create('administrador', function (Blueprint $table) {
            $table->id('id_admin');

            $table->string('rut_admin');
            $table->foreign('rut_admin')->references('rut')->on('usuario');

            $table->string('nombre_admin');

            $table->timestamp('fecha_creacion');

            $table->string('numero_contacto')->nullable();
            $table->text('sobre_mi')->nullable();
            $table->text('descripcion_ubicacion')->nullable();
            $table->string('foto_perfil')->default('img/perfiles/default.png');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrador');
    }
};
