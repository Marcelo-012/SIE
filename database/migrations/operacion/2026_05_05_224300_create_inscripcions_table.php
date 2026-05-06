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
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id('id_inscripcion');
            $table->foreignId('id_alumno')->constrained('alumnos', 'id_alumno');
            $table->foreignId('id_grupo')->constrained('grupos', 'id_grupo');
            $table->integer('intento')->default(1);
            $table->enum('estatus', ['cursando', 'aprobado', 'reprobado'])->default('cursando');
            $table->timestamps();

            // Restricciones
            $table->check('intento BETWEEN 1 AND 3');

            // Un alumno solo puede estar una vez por grupo (evita duplicados)
            $table->unique(['id_alumno', 'id_grupo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};
