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
        Schema::create('rol_admin', function (Blueprint $table) {
            $table->integer('id_rol');
            $table->integer('id_admin');
            $table->primary(['id_rol', 'id_admin']);

            $table->foreign('id_rol')->references('id_rol')->on('rol');
            $table->foreign('id_admin')->references('id_admin')->on('administrador');

            $table->boolean('habilitado')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_admin');
    }
};
