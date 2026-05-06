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
        Schema::create('calificacions', function (Blueprint $table) {
            $table->id('id_calificacion');
            $table->foreignId('id_inscripcion')->constrained('inscripcions', 'id_inscripcion');
            $table->integer('unidad');
            $table->integer('calificacion');
            $table->date('fecha');
            $table->integer('califiacion_final')->nullable();
            $table->timestamps();

            // Solo 3 unidades por inscripción
            $table->unique(['id_inscripcion', 'unidad']);
            $table->check('calificacion BETWEEN 0 AND 100');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacions');
    }
};
