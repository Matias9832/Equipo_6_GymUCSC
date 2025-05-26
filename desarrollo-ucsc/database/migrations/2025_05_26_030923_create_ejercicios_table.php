<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('imagen')->nullable(); // Campo para la imagen
            $table->enum('grupo_muscular', [
                'pecho', 'espalda', 'hombros', 'bíceps', 'tríceps',
                'abdominales', 'cuádriceps', 'isquiotibiales', 'glúteos',
                'pantorrillas', 'antebrazos', 'trapecio'
            ]);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};