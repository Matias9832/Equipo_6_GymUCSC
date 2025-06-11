<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemasTable extends Migration
{
    public function up()
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id('id_tema');
            $table->string('nombre_tema', 100);

            // Fuente
            $table->string('nombre_fuente', 100)->nullable();
            $table->string('familia_css', 150)->nullable();
            $table->string('url_fuente', 255)->nullable();

            // Colores principales
            $table->string('bs_primary', 7)->default('#101820');
            $table->string('bs_success', 7)->default('#198754');
            $table->string('bs_danger', 7)->default('#d30d0d');

            // Variantes PRIMARY
            $table->string('primary_focus', 7)->nullable();
            $table->string('border_primary_focus', 7)->nullable();
            $table->string('primary_gradient', 7)->nullable();

            // Variantes SUCCESS
            $table->string('success_focus', 7)->nullable();
            $table->string('border_success_focus', 7)->nullable();
            $table->string('success_gradient', 7)->nullable();

            // Variantes DANGER
            $table->string('danger_focus', 7)->nullable();
            $table->string('border_danger_focus', 7)->nullable();
            $table->string('danger_gradient', 7)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temas');
    }
}
