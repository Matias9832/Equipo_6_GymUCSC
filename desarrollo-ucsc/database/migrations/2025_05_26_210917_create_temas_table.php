<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemasTable extends Migration
{
    public function up(): void
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_tema', 100);

            // Colores como campos individuales
            $table->string('color_fondo', 7);
            $table->string('color_barra', 7);
            $table->string('color_boton', 7);
            $table->string('color_texto', 7);
            $table->string('color_exito', 7);
            $table->string('color_error', 7);

            // Fuente completa
            $table->string('nombre_fuente', 100);
            $table->string('familia_css', 150);
            $table->string('url_fuente', 255);

            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('temas');
    }
}
