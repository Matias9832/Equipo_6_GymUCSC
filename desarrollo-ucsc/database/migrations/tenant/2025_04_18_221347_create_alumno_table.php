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
        Schema::create('alumno', function (Blueprint $table) {
            $table->string('rut_alumno');
            $table->primary('rut_alumno');

            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('nombre_alumno');
            $table->integer('ua_carrera');
            $table->string('carrera');
            $table->string('estado_alumno');
            $table->string('correo_alumno')->nullable();
            $table->string('sexo_alumno')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno');
    }
};
