<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantTable extends Migration
{
    public function up(): void
    {
        Schema::create('tenant', function (Blueprint $table) {
            $table->id('id_tenant');
            $table->string('nombre_tenant', 100);

            $table->unsignedBigInteger('id_marca');
            $table->unsignedBigInteger('id_tema');

            $table->foreign('id_marca')->references('id_marca')->on('marca')->onDelete('cascade');
            $table->foreign('id_tema')->references('id_tema')->on('temas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant');
    }
}
