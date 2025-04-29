<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('espacios', function (Blueprint $table) {
            $table->increments('id_espacio');
            $table->string('nombre_espacio');
            $table->string('tipo_espacio');
            $table->unsignedBigInteger('id_suc');
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('espacios');
    }
};

