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
        Schema::create('admin_sucursal', function (Blueprint $table) {
            $table->integer('id_suc');
            $table->integer('id_admin');
            $table->primary(['id_suc', 'id_admin']);

            $table->foreign('id_suc')->references('id_suc')->on('sucursal');
            $table->foreign('id_admin')->references('id_admin')->on('administrador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_sucursal');
    }
};
