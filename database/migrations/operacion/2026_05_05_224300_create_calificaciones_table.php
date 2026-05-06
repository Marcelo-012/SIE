<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id('id_calificacion');
            $table->foreignId('id_inscripcion')->constrained('inscripciones', 'id_inscripcion');
            $table->integer('unidad');
            $table->integer('calificacion');
            $table->date('fecha');
            $table->integer('califiacion_final')->nullable();
            $table->timestamps();

            // Solo 3 unidades por inscripción
            $table->unique(['id_inscripcion', 'unidad']);
        });
        DB::statement('ALTER TABLE calificaciones ADD CONSTRAINT chk_calificacion CHECK (calificacion >= 0 AND calificacion <= 100)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};
