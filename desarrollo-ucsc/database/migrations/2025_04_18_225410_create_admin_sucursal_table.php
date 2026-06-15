<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_sucursal', function (Blueprint $table) {
            $table->unsignedBigInteger('id_suc');
            $table->unsignedBigInteger('id_admin');
            $table->primary(['id_suc', 'id_admin']);
    
            $table->boolean('activa');
    
            $table->foreign('id_suc')
                  ->references('id_suc')
                  ->on('sucursal')
                  ->onDelete('cascade'); // Si se elimina la sucursal, elimina esta relación
    
            $table->foreign('id_admin')
                  ->references('id_admin')
                  ->on('administrador')
                  ->onDelete('cascade'); // Si se elimina el administrador, elimina esta relación
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('admin_sucursal');
    }
};
