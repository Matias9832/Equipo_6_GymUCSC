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
        Schema::create('horarios_academia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_academia');
            $table->string('dia');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();

            $table->foreign('id_academia')->references('id_academia')->on('academias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
