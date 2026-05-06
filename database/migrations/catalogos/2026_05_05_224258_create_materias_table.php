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
        Schema::create('materias', function (Blueprint $table) {
            $table->id('id_materia');
            $table->string('clave_materia', 10)->unique();
            $table->string('nombre_materia', 50);
            $table->integer('unidades')->default(1);
            $table->integer('creditos');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
