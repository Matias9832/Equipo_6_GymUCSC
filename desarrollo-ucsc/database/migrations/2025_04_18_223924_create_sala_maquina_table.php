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
        if (!Schema::hasTable('sala_maquina')) {
            Schema::create('sala_maquina', function (Blueprint $table) {
                $table->integer('id_sala');
                $table->integer('id_maq');
                $table->primary(['id_sala', 'id_maq']);

                $table->foreign('id_sala')->references('id_sala')->on('sala');
                $table->foreign('id_maq')->references('id_maq')->on('maquina');

                $table->integer('cantidad_maq');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sala_maquina');
    }
};
