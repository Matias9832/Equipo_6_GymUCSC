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
            $table->integer('id_usuario');
            $table->primary('id_usuario');

            $table->string('rut_alumno');
            $table->foreign('rut_alumno')->references('rut_alumno')->on('alumno'); //clave foranea

            $table->boolean('bloqueado_usuario');
            $table->boolean('activado_usuario');
            
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
