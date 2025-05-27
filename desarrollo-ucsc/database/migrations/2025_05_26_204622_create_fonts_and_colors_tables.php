<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('colores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_color', 100);
            $table->string('codigo_hex', 7);
            $table->boolean('activo_color')->default(true);
            $table->timestamps();
        });

        Schema::create('fuentes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_fuente', 100);
            $table->string('familia_css', 100);
            $table->string('url_fuente')->nullable();
            $table->boolean('activo_fuente')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuentes');
        Schema::dropIfExists('colores');
    }
};
