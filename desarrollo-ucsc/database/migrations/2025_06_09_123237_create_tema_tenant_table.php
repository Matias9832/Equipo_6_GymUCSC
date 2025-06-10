<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tema_tenant', function (Blueprint $table) {
            $table->id('id_tema_tenant');
            
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');

            $table->string('nombre_tema', 100);
            $table->string('nombre_fuente', 100)->nullable();
            $table->string('familia_css', 150)->nullable();
            $table->string('url_fuente', 255)->nullable();

            $table->string('bs_primary', 7);
            $table->string('bs_success', 7);
            $table->string('bs_danger', 7);

            $table->string('primary_focus', 7)->nullable();
            $table->string('border_primary_focus', 7)->nullable();
            $table->string('primary_gradient', 7)->nullable();

            $table->string('success_focus', 7)->nullable();
            $table->string('border_success_focus', 7)->nullable();
            $table->string('success_gradient', 7)->nullable();

            $table->string('danger_focus', 7)->nullable();
            $table->string('border_danger_focus', 7)->nullable();
            $table->string('danger_gradient', 7)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tema_tenant');
    }
};
