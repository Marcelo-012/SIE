<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('unidades_temario', function (Blueprint $table) {
            $table->id('id_unidad');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedTinyInteger('numero');
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->unique(['id_materia', 'numero']);
            $table->foreign('id_materia')->references('id_materia')->on('materias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unidades_temario');
    }
};
