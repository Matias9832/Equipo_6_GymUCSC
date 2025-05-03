<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingreso', function (Blueprint $table) {
            $table->id('id_ingreso'); // Clave primaria
            $table->unsignedBigInteger('id_sala'); // Clave foránea hacia sala
            $table->unsignedBigInteger('id_usuario'); // Clave foránea hacia usuario

            $table->foreign('id_sala')->references('id_sala')->on('sala')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuario')->onDelete('cascade');

            $table->date('fecha_ingreso');
            $table->time('hora_ingreso');
            $table->time('hora_salida')->nullable();
            $table->time('tiempo_uso')->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB'; // Asegura que se use InnoDB
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingreso');
    }
};