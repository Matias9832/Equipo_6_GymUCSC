<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rutinas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('user_id'); // Usuario asignado
            $table->string('creador_rut'); // Rut del creador
            $table->timestamps();

            $table->foreign('user_id')->references('id_usuario')->on('usuario')->onDelete('cascade');
            $table->foreign('creador_rut')->references('rut')->on('usuario')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rutinas');
    }
};