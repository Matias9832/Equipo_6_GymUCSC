<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTenantTable extends Migration
{
    public function up()
    {
        Schema::create('usuario_tenant', function (Blueprint $table) {
            $table->id('id_usuario_tenant');
            $table->string('rut_usuario', 20)->unique();
            $table->string('nombre_usuario', 100);
            $table->string('gmail_usuario', 100)->unique();
            $table->string('tipo_usuario_tenant', 20);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario_tenant');
    }
}
